<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Post Meta
    |--------------------------------------------------------------------------
    |
    | Post meta to be registered with WordPress.
    |
    | Each entry accepts all standard register_post_meta() args plus:
    |   'field' — UI definition for the Blade metabox (label, type, placeholder, help, options).
    |             Supported types: text | url | number | textarea | checkbox | select
    |
    */

    'post_meta' => [
        'partner_url' => [
            'post_type' => 'partner',
            'single' => true,
            'type' => 'string',
            'description' => 'URL of the partner',
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
            'show_in_rest' => true,
            'field' => [
                'label' => 'Partner URL',
                'type' => 'url',
                'placeholder' => 'https://example.com',
                'help' => 'Link to the partner website.',
            ],
        ],
        'partner_dark_mode' => [
            'post_type' => 'partner',
            'single' => true,
            'type' => 'boolean',
            'description' => 'Dark mode preference for the partner',
            'sanitize_callback' => 'rest_sanitize_boolean',
            'auth_callback' => function () {
                return current_user_can('edit_posts');
            },
            'show_in_rest' => true,
            'field' => [
                'label' => 'Dark Mode',
                'type' => 'checkbox',
                'help' => 'Enable dark mode for this partner.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Meta Boxes
    |--------------------------------------------------------------------------
    |
    | Override the auto-generated metabox title, context, and priority per
    | post type. Defaults: title = "{Post Type} Details", context = "normal",
    | priority = "high".
    |
    */

    'meta_boxes' => [
        'partner' => [
            'title' => 'Partner Details',
            'context' => 'normal',
            'priority' => 'high',
        ],
    ],

];
