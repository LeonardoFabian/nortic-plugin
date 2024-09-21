<?php

if (!function_exists('nortic_plugin_achievement_post_type')) {
    /**
     * Register achievement post type
     *
     * @return void
     */
    function nortic_plugin_achievement_post_type()
    {
        $labels = array(
            'name'                  => _x('Achievements', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Achievement', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Achievements', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Achievement', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Achievement', 'nortic-plugin'),
            'new_item'              => __('New Achievement', 'nortic-plugin'),
            'edit_item'             => __('Edit Achievement', 'nortic-plugin'),
            'view_item'             => __('View Achievement', 'nortic-plugin'),
            'all_items'             => __('All Achievements', 'nortic-plugin'),
            'search_items'          => __('Search Achievements', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Achievements:', 'nortic-plugin'),
            'not_found'             => __('No Achievements found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Achievements found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Achievement Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Achievement archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Achievement', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Achievement', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Achievements list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Achievements list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Achievements list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'achievement'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 22,
            'menu_icon'          => 'dashicons-flag',
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for Achievements', 'nortic-plugin'),
        );

        register_post_type('achievement', $args);

        register_post_meta(
            'achievement',
            'highlight_achievement',
            array(
                'description'   => __('Highlight achievement', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'boolean',
                'default'       => false,
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );
    }
}
