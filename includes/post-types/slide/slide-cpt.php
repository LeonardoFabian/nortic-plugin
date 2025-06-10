<?php

if (!function_exists('nortic_plugin_slide_cpt')) {
    function nortic_plugin_slide_cpt()
    {

        $labels = array(
            'name'                  => _x('Slides', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Slide', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Slides', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Slide', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Slide', 'nortic-plugin'),
            'new_item'              => __('New Slide', 'nortic-plugin'),
            'edit_item'             => __('Edit Slide', 'nortic-plugin'),
            'view_item'             => __('View Slide', 'nortic-plugin'),
            'all_items'             => __('All Slides', 'nortic-plugin'),
            'search_items'          => __('Search Slides', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Slides:', 'nortic-plugin'),
            'not_found'             => __('No Slides found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Slides found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Slide Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Slide archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Slide', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Slide', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Slides list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Slides list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Slides list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => false, // era true
            'hierarchical'       => false, // era false
            'show_in_rest'       => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'slide'),
            'capability_type'    => 'post',
            'menu_position'      => 21,
            'menu_icon'         => 'dashicons-cover-image',
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'description'        => __('A custom post type for Slides', 'nortic-plugin'),
        );

        register_post_type('slide', $args);

        
    }
}

// TODO registrar un post meta tipo boolean para mostrar u ocultar el titulo


register_post_meta( '', 'url_label', [
    'type'              => 'string',
    'default'           => '',
    'description'       => __('URL label', 'nortic-plugin'),
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function () {
        return current_user_can('edit_posts');
    }
] );


register_post_meta( '', 'template_style', [
    'type'              => 'string',
    'default'           => '',
    'description'       => __('Template style', 'nortic-plugin'),
    'single'            => true,
    'show_in_rest'      => true,
    'sanitize_callback' => 'sanitize_text_field',
    'auth_callback'     => function () {
        return current_user_can('edit_posts');
    }
]);