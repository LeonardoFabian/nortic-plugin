<?php

if (!function_exists('nortic_plugin_gallery_post_type')) {
    function nortic_plugin_gallery_post_type()
    {
        $labels = array(
            'name'                  => _x('Galleries', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Gallery', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Galleries', 'Admin menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Gallery', 'Add new on toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Gallery', 'nortic-plugin'),
            'new_item'              => __('New Gallery', 'nortic-plugin'),
            'edit_item'             => __('Edit Gallery', 'nortic-plugin'),
            'view_item'             => __('View Gallery', 'nortic-plugin'),
            'all_items'             => __('All Galleries', 'nortic-plugin'),
            'search_items'          => __('Search Galleries', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Gallery:', 'nortic-plugin'),
            'not_found'             => __('No Galleries found', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Galleries found in trash', 'nortic-plugin'),
            'featured_image'        => _x('Gallery Cover Image', 'Overrides the "Featured Image" phrase for this post type. Added in 4.3', 'nortic-plugin'),

            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Gallery archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Gallery', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Gallery', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Galleries list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Galleries list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Galleries list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'galleries'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 21,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for galleries', 'nortic-plugin'),
        );

        register_post_type('gallery', $args);
    }
}
