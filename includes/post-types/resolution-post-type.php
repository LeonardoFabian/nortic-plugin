<?php

if (!function_exists('nortic_plugin_resolution_post_type')) {
    function nortic_plugin_resolution_post_type()
    {
        $labels = array(
            'name'                  => _x('Resolutions', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Resolution', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Resolutions', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Resolution', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Resolution', 'nortic-plugin'),
            'new_item'              => __('New Resolution', 'nortic-plugin'),
            'edit_item'             => __('Edit Resolution', 'nortic-plugin'),
            'view_item'             => __('View Resolution', 'nortic-plugin'),
            'all_items'             => __('All Resolutions', 'nortic-plugin'),
            'search_items'          => __('Search Resolutions', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Resolutions:', 'nortic-plugin'),
            'not_found'             => __('No Resolutions found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Resolutions found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Resolution Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Resolution archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Resolution', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Resolution', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Resolutions list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Resolutions list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Resolutions list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'resolution'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 21,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true, // save via Rest API
            'description'        => __('A custom post type for Resolutions', 'nortic-plugin'),
        );

        // 'taxonomies'         => ['category', 'post_tag']

        register_post_type('resolution', $args);

        // resolution number
        register_post_meta(
            '',
            'identification_number',
            array(
                'description' => __('Identification Number', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resolution number
        register_post_meta(
            '',
            'date',
            array(
                'description' => __('Date', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );
    }
}
