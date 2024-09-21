<?php

if (!function_exists('nortic_plugin_award_post_type')) {
    /**
     * Register award post type
     *
     * @return void
     */
    function nortic_plugin_award_post_type()
    {
        $labels = array(
            'name'                  => _x('Awards', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Award', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Awards', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Award', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Award', 'nortic-plugin'),
            'new_item'              => __('New Award', 'nortic-plugin'),
            'edit_item'             => __('Edit Award', 'nortic-plugin'),
            'view_item'             => __('View Award', 'nortic-plugin'),
            'all_items'             => __('All Awards', 'nortic-plugin'),
            'search_items'          => __('Search Awards', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Awards:', 'nortic-plugin'),
            'not_found'             => __('No Awards found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Awards found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Award Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Award archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Award', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Award', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Awards list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Awards list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Awards list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'award'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-awards',
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for Awards', 'nortic-plugin'),
        );

        register_post_type('award', $args);

        // Expiry date
        register_post_meta(
            '',
            'expiry_date',
            array(
                'description' => __('Expiry date', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Is expired
        register_post_meta('', 'is_expired', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Is expired?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);
    }
}
