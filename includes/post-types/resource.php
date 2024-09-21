<?php

if (!function_exists('nortic_plugin_resource_post_type')) {
    function nortic_plugin_resource_post_type()
    {

        $labels = array(
            'name'                  => _x('Resources', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Resource', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Resources', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Resource', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Resource', 'nortic-plugin'),
            'new_item'              => __('New Resource', 'nortic-plugin'),
            'edit_item'             => __('Edit Resource', 'nortic-plugin'),
            'view_item'             => __('View Resource', 'nortic-plugin'),
            'all_items'             => __('All Resources', 'nortic-plugin'),
            'search_items'          => __('Search Resources', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Resources:', 'nortic-plugin'),
            'not_found'             => __('No Resources found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Resources found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Resource Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Resource archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Resource', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Resource', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Resources list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Resources list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Resources list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'recursos'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for Resources', 'nortic-plugin'),
        );

        register_post_type('resource', $args);

        // resource size in bytes
        register_post_meta(
            'resource',
            'resource_ID',
            array(
                'description'   => __('Resource ID', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'integer',
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource title
        register_post_meta(
            'resource',
            'resource_title',
            array(
                'description'   => __('Resource title', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource name
        register_post_meta(
            'resource',
            'resource_name',
            array(
                'description'   => __('Resource name', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource alt
        register_post_meta(
            'resource',
            'resource_alternative_text',
            array(
                'description'   => __('Resource alt attribute', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource url
        register_post_meta(
            'resource',
            'resource_file_url',
            array(
                'description'   => __('Resource file URL', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource related post ID
        register_post_meta(
            'resource',
            'resource_related_post_id',
            array(
                'description'   => __('Resource related PostId', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'integer',
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource size readable
        register_post_meta(
            'resource',
            'resource_size_readable',
            array(
                'description'   => __('Size readable', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource size in bytes
        register_post_meta(
            'resource',
            'resource_size_in_bytes',
            array(
                'description'   => __('Size in bytes', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'integer',
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource format
        register_post_meta(
            'resource',
            'resource_format',
            array(
                'description'   => __('Format', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // resource format
        register_post_meta(
            'resource',
            'resource_mime_type',
            array(
                'description'   => __('Mime Type', 'nortic-plugin'),
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
