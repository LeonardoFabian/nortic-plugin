<?php

if (!function_exists('nortic_plugin_system_post_type')) {
    /**
     * Register system post type
     *
     * @return void
     */
    function nortic_plugin_system_post_type()
    {

        $labels = array(
            'name'                  => _x('Systems', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('System', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Systems', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('System', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New System', 'nortic-plugin'),
            'new_item'              => __('New System', 'nortic-plugin'),
            'edit_item'             => __('Edit System', 'nortic-plugin'),
            'view_item'             => __('View System', 'nortic-plugin'),
            'all_items'             => __('All Systems', 'nortic-plugin'),
            'search_items'          => __('Search Systems', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Systems:', 'nortic-plugin'),
            'not_found'             => __('No Systems found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Systems found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('System Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('System archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into System', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this System', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Systems list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Systems list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Systems list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => false,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'system'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for Systems', 'nortic-plugin'),
        );

        register_post_type('system', $args);


        // Store the System target audience
        // TODO: set target_audience for all users

        // alias


        // url



    }
}
