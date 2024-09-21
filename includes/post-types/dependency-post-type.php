<?php

if (!function_exists('nortic_plugin_dependency_post_type')) {
    /**
     * Register dependency post type
     *
     * @return void
     */
    function nortic_plugin_dependency_post_type()
    {

        $labels = array(
            'name'                  => _x('Dependencies', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Dependency', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Dependencies', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Dependency', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Dependency', 'nortic-plugin'),
            'new_item'              => __('New Dependency', 'nortic-plugin'),
            'edit_item'             => __('Edit Dependency', 'nortic-plugin'),
            'view_item'             => __('View Dependency', 'nortic-plugin'),
            'all_items'             => __('All Dependencies', 'nortic-plugin'),
            'search_items'          => __('Search Dependencies', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Dependencies:', 'nortic-plugin'),
            'not_found'             => __('No Dependencies found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Dependencies found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Dependency Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Dependency archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Dependency', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Dependency', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Dependencies list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Dependencies list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Dependencies list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'dependency'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 22,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for dependencies', 'nortic-plugin'),
        );

        register_post_type('dependency', $args);

        register_post_meta('dependency', 'parent_dependency_id', [
            'type' => 'integer',
            'description' => __('Parent Dependency ID', 'nortic-plugin'),
            'single' => true,
            'default' => 0,
            'show_in_rest' => true,
        ]);

        // Unit responsible member from TEAM cpt
        register_post_meta('dependency', 'reponsible_member_id', [
            'type'              => 'integer',
            'description'       => __('Dependency responsible member ID', 'nortic-plugin'),
            'single'            => true,
            'default'           => 0,
            'show_in_rest'      => true
        ]);

        // General objective
        register_post_meta(
            '',
            'general_objective',
            array(
                'description'   => __('General objective', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Especific objective
        register_post_meta(
            '',
            'specific_objective',
            array(
                'description'   => __('Specific objective', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Mission
        register_post_meta(
            'dependency',
            'mission',
            array(
                'description'   => __('Mission', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Vision
        register_post_meta(
            'dependency',
            'vision',
            array(
                'description'   => __('Vision', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Values
        register_post_meta(
            'dependency',
            'values',
            array(
                'description'   => __('Values', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Dependency main functions
        register_post_meta(
            '',
            'main_functions',
            array(
                'description'   => __('Main functions', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Dependency interests
        register_post_meta(
            'dependency',
            'interests',
            array(
                'description'   => __('Interests', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Map location link
        register_post_meta(
            'dependency',
            'map_link',
            array(
                'description'   => __('Map link', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Map location iframe
        register_post_meta(
            'dependency',
            'map_iframe',
            array(
                'description'   => __('Embed map', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'nortic_plugin_sanitize_iframe',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Achievements
        register_post_meta(
            '',
            'achievements',
            array(
                'description'   => __('Achievements', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );
    }
}
