<?php

if (!function_exists('nortic_plugin_team_post_type')) {
    function nortic_plugin_team_post_type()
    {
        $labels = array(
            'name'                  => _x('Team', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Team', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Team', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Team', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Team', 'nortic-plugin'),
            'new_item'              => __('New Team', 'nortic-plugin'),
            'edit_item'             => __('Edit Team', 'nortic-plugin'),
            'view_item'             => __('View Team', 'nortic-plugin'),
            'all_items'             => __('All Team', 'nortic-plugin'),
            'search_items'          => __('Search Team', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Team:', 'nortic-plugin'),
            'not_found'             => __('No Team found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Team found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Team Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Team archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Team', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Team', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Team list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Team list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Team list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'team'),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => true,
            'menu_position'      => 21,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'show_in_rest'       => true,
            'description'        => __('A custom post type for Team', 'nortic-plugin'),
        );

        register_post_type('team', $args);

        // Team member name
        register_post_meta(
            'team',
            'full_name',
            array(
                'description'   => __('Full name', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Team member job title
        register_post_meta(
            'team',
            'job_title',
            array(
                'description'   => __('Job title', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Team member biography
        register_post_meta(
            'team',
            'biography',
            array(
                'description'   => __('Biography', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_textarea_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // URL declaracion jurada
        register_post_meta('team', 'sworn_statement', [
            'type'              => 'string',
            'description'       => __('Sworn statement', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Phone
        register_post_meta('team', 'mobile', [
            'type'              => 'string',
            'description'       => __('Mobile', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Facebook
        register_post_meta('team', 'facebook', [
            'type'              => 'string',
            'description'       => __('Facebook', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Instagram
        register_post_meta('team', 'instagram', [
            'type'              => 'string',
            'description'       => __('Instagram', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Twitter
        register_post_meta('team', 'twitter', [
            'type'              => 'string',
            'description'       => __('Twitter', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // LinkedIn
        register_post_meta('team', 'linkedin', [
            'type'              => 'string',
            'description'       => __('LinkedIn', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);
    }
}
