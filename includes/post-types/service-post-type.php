<?php

if (!function_exists('nortic_plugin_service_post_type')) {
    /**
     * Register service post type
     *
     * @return void
     */
    function nortic_plugin_service_post_type()
    {

        $labels = array(
            'name'                  => _x('Services', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Service', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Services', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Service', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Service', 'nortic-plugin'),
            'new_item'              => __('New Service', 'nortic-plugin'),
            'edit_item'             => __('Edit Service', 'nortic-plugin'),
            'view_item'             => __('View Service', 'nortic-plugin'),
            'all_items'             => __('All Services', 'nortic-plugin'),
            'search_items'          => __('Search Services', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Services:', 'nortic-plugin'),
            'not_found'             => __('No Services found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Services found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Service Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Service archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Service', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Service', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Services list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Services list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Services list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'has_archive'        => 'servicios',
            'rewrite'            => array('slug' => "servicios", 'with_front' => true),
            'capability_type'    => 'post',
            'hierarchical'       => false,
            'menu_position'      => 20,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'page-attributes'),
            'taxonomies'         => ['service_classification', 'service_tag'],
            'show_in_rest'       => true,
            'label'              => __('Services', 'nortic-plugin'),
            'description'        => __('A custom post type for services', 'nortic-plugin'),
        );

        register_post_type('service', $args);

        register_post_meta('', 'rating', [
            'type'          => 'number',
            'description'   => __('Rating metadata', 'nortic_plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => true
        ]);

        register_post_meta('', 'total_ratings', [
            'type'          => 'number',
            'description'   => __('Post ratings count', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => true
        ]);

        register_post_meta('', 'one_star_ratings', [
            'type'          => 'number',
            'description'   => __('Post one star ratings', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => false
        ]);

        register_post_meta('', 'two_star_ratings', [
            'type'          => 'number',
            'description'   => __('Post two star ratings', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => false
        ]);

        register_post_meta('', 'three_star_ratings', [
            'type'          => 'number',
            'description'   => __('Post three star ratings', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => false
        ]);

        register_post_meta('', 'four_star_ratings', [
            'type'          => 'number',
            'description'   => __('Post four star ratings', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => false
        ]);

        register_post_meta('', 'five_star_ratings', [
            'type'          => 'number',
            'description'   => __('Post five star ratings', 'nortic-plugin'),
            'single'        => true,
            'default'       => 0,
            'show_in_rest'  => false
        ]);

        // Alias
        register_post_meta('', 'alias', [
            'type'              => 'string',
            'description'       => __('Alias', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Description
        register_post_meta('', 'description', [
            'type'              => 'string',
            'description'       => __('Description', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Definition
        register_post_meta('', 'information', [
            'type'              => 'string',
            'description'       => __('Information', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Icon
        register_post_meta('', 'icon', [
            'type'              => 'string',
            'description'       => __('Icon', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'wp_kses_post',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Default Icon
        register_post_meta('', 'default_icon', [
            'type'              => 'string',
            'description'       => __('Default Icon', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Use Defautl Icon?
        register_post_meta(
            '',
            'use_default_icon',
            [
                'type'              => 'boolean',
                'default'           => false,
                'description'       => __('Use default icon', 'nortic-plugin'),
                'single'            => true,
                'show_in_rest'      => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback'     => function () {
                    return current_user_can('edit_posts');
                }
            ]
        );

        // Check if user can override icon
        register_post_meta('', 'override_icon', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Override icon?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Store the service target audience
        register_post_meta('', 'target_audience', [
            'type'              => 'string',
            'description'       => __('Target audience', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Store the service requirements
        register_post_meta('', 'requirements', [
            'type'              => 'string',
            'description'       => __('Requirements', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Store the service procedures
        register_post_meta('', 'procedure', [
            'type'              => 'string',
            'description'       => __('Procedure', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Benefits
        register_post_meta('', 'benefits', [
            'type'              => 'string',
            'description'       => __('Benefits', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Criteria
        register_post_meta('', 'criteria', [
            'type'              => 'string',
            'description'       => __('Criteria', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Additional information
        register_post_meta('', 'additional_info', [
            'type'              => 'string',
            'description'       => __('Additional Information', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Schedule
        register_post_meta('', 'schedule', [
            'type'              => 'string',
            'description'       => __('Schedule', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Store the cost of service
        register_post_meta('', 'cost', [
            'type'              => 'string',
            'description'       => __('Cost', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Store the service completion time
        register_post_meta('service', 'completion_time', [
            'type'              => 'string',
            'description'       => __('Completion time', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Online service available
        register_post_meta('', 'online_service_available', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Online service available?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Link
        register_post_meta('', 'url', [
            'type'              => 'string',
            'description'       => __('Link', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'esc_url_raw',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Service responsible unit
        register_post_meta('service', 'service_dependency_id', [
            'type'              => 'integer',
            'description'       => __('Service parent Dependency ID', 'nortic-plugin'),
            'single'            => true,
            'default'           => 0,
            'show_in_rest'      => true
        ]);


        // Phone service available
        register_post_meta('', 'phone_service_available', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Phone service available?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // App mobile service available
        register_post_meta('', 'app_service_available', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('App mobile service available?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Phone
        register_post_meta('', 'phone', [
            'type'              => 'string',
            'description'       => __('Phone', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Email service available
        register_post_meta('', 'email_service_available', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Email service available?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Email
        register_post_meta('', 'email', [
            'type'              => 'string',
            'description'       => __('Email', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_email',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // In-person service available
        register_post_meta('', 'in_person_service_available', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('In-person service available?', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Location
        register_post_meta('', 'location', [
            'type'              => 'string',
            'description'       => __('Location', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Open Graph title
        register_post_meta('', 'og_title', [
            'type'              => 'string',
            'description'       => __('Open Graph Title', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Open Graph description
        register_post_meta('', 'og_description', [
            'type'              => 'string',
            'description'       => __('Open Graph Description', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Open Graph Image
        register_post_meta('', 'og_image', [
            'type'              => 'string',
            'description'       => __('Open Graph Image', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

        // Open Graph Override image
        register_post_meta('', 'og_override_image', [
            'type'              => 'boolean',
            'default'           => false,
            'description'       => __('Open Graph override Image', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_text_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);
    }
}
