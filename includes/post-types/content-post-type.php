<?php

if (!function_exists('nortic_plugin_content_post_type')) {
    function nortic_plugin_content_post_type()
    {

        $labels = array(
            'name'                  => _x('Contents', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Content', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Contents', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Content', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Content', 'nortic-plugin'),
            'new_item'              => __('New Content', 'nortic-plugin'),
            'edit_item'             => __('Edit Content', 'nortic-plugin'),
            'view_item'             => __('View Content', 'nortic-plugin'),
            'all_items'             => __('All Contents', 'nortic-plugin'),
            'search_items'          => __('Search Contents', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Contents:', 'nortic-plugin'),
            'not_found'             => __('No Contents found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Contents found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Content Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Content archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Content', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Content', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Contents list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Contents list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Contents list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'content'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 24,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'post-formats', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for contents', 'nortic-plugin'),
        );

        register_post_type('content', $args);

        // Especific objective
        register_post_meta(
            '',
            'iframe',
            array(
                'description'   => __('Iframe', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'nortic_plugin_sanitize_iframe',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );
    }
}
