<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

add_action('pre_get_posts', function ($query) {
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }
    if ($query->is_post_type_archive('partner')) {
        $query->set('posts_per_page', -1);
        $query->set('orderby', 'created');
        $query->set('order', 'ASC');
    }
});

/**
 * Let Sage render events archives instead of TEC hijacking template_include.
 */
add_filter('tribe_events_views_v2_use_wp_template_hierarchy', '__return_true');

/**
 * Sage runs template_include at priority 100 and can resolve the wrong view for TEC.
 * Force the events Blade templates after Sage so calendar and single event views render.
 */
add_filter('template_include', function ($template) {
    if (! function_exists('tribe')) {
        return $template;
    }

    if (is_post_type_archive('tribe_events')) {
        app()->instance('sage.view', 'archive-tribe_events');
    }

    if (is_singular('tribe_events')) {
        app()->instance('sage.view', 'single-tribe_events');
    }

    return $template;
}, 101);
