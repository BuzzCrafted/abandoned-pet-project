<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class PostMetaServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap metabox registration and save handler.
     */
    public function boot(): void
    {
        $this->groupedByPostType()->each(function (Collection $fields, string $postType): void {
            add_action('add_meta_boxes', function () use ($postType, $fields): void {
                $this->registerMetaBox($postType, $fields);
            });

            // Run at priority 30 so WordPress has already added 'postcustom' at its default priority 10.
            add_action('add_meta_boxes', function () use ($postType): void {
                remove_meta_box('postcustom', $postType, 'normal');
            }, 30);

            add_action("save_post_{$postType}", function (int $postId) use ($postType, $fields): void {
                $this->saveFields($postId, $postType, $fields);
            });
        });
    }

    /**
     * Register a single metabox for all fields belonging to a post type.
     */
    protected function registerMetaBox(string $postType, Collection $fields): void
    {
        $boxConfig = $this->app->config->get("post-meta.meta_boxes.{$postType}", []);

        $title    = $boxConfig['title']    ?? ucfirst($postType) . ' Details';
        $context  = $boxConfig['context']  ?? 'normal';
        $priority = $boxConfig['priority'] ?? 'high';

        add_meta_box(
            "post-meta-{$postType}",
            $title,
            function (\WP_Post $post) use ($postType, $fields): void {
                $this->renderMetaBox($post, $postType, $fields);
            },
            $postType,
            $context,
            $priority,
            ['__block_editor_compatible_meta_box' => true]
        );
    }

    /**
     * Render the metabox via Blade.
     */
    protected function renderMetaBox(\WP_Post $post, string $postType, Collection $fields): void
    {
        $resolvedFields = $fields->map(function (array $fieldConfig, string $metaKey) use ($post): array {
            return array_merge($fieldConfig['field'], [
                'key'   => $metaKey,
                'value' => get_post_meta($post->ID, $metaKey, true),
            ]);
        })->values()->all();

        echo view('admin.meta-box', [
            'post'     => $post,
            'postType' => $postType,
            'fields'   => $resolvedFields,
            'nonce'    => wp_create_nonce("post_meta_{$postType}_{$post->ID}"),
        ]);
    }

    /**
     * Save all meta fields for the post type, with nonce and capability checks.
     */
    protected function saveFields(int $postId, string $postType, Collection $fields): void
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (wp_is_post_revision($postId)) {
            return;
        }

        $nonce = sanitize_text_field(wp_unslash($_POST["post_meta_{$postType}_nonce"] ?? ''));

        if (! wp_verify_nonce($nonce, "post_meta_{$postType}_{$postId}")) {
            return;
        }

        if (! current_user_can('edit_post', $postId)) {
            return;
        }

        $fields->each(function (array $fieldConfig, string $metaKey) use ($postId): void {
            $fieldType = $fieldConfig['field']['type'] ?? 'text';

            if ($fieldType === 'checkbox') {
                $value = isset($_POST[$metaKey]) ? '1' : '0';
            } else {
                $value = sanitize_text_field(wp_unslash($_POST[$metaKey] ?? ''));
            }

            // Let register_post_meta's sanitize_callback run via update_post_meta.
            update_post_meta($postId, $metaKey, $value);
        });
    }

    /**
     * Return meta fields that have a 'field' UI definition, grouped by post type
     * with original meta key strings preserved.
     *
     * @return Collection<string, Collection>
     */
    protected function groupedByPostType(): Collection
    {
        $allMeta = Collection::make($this->app->config->get('post-meta.post_meta', []))
            ->filter(fn(array $config): bool => isset($config['field']));

        return $allMeta
            ->pluck('post_type')
            ->unique()
            ->mapWithKeys(fn(string $postType): array => [
                $postType => $allMeta->filter(
                    fn(array $config): bool => $config['post_type'] === $postType
                ),
            ]);
    }
}
