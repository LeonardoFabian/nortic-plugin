<?php

if (!function_exists('nortic_plugin_document_post_type')) {
    function nortic_plugin_document_post_type()
    {

        $labels = array(
            'name'                  => _x('Documents', 'Post type general name', 'nortic-plugin'),
            'singular_name'         => _x('Document', 'Post type singular name', 'nortic-plugin'),
            'menu_name'             => _x('Documents', 'Admin Menu text', 'nortic-plugin'),
            'name_admin_bar'        => _x('Document', 'Add New on Toolbar', 'nortic-plugin'),
            'add_new'               => __('Add New', 'nortic-plugin'),
            'add_new_item'          => __('Add New Document', 'nortic-plugin'),
            'new_item'              => __('New Document', 'nortic-plugin'),
            'edit_item'             => __('Edit Document', 'nortic-plugin'),
            'view_item'             => __('View Document', 'nortic-plugin'),
            'all_items'             => __('All Documents', 'nortic-plugin'),
            'search_items'          => __('Search Documents', 'nortic-plugin'),
            'parent_item_colon'     => __('Parent Documents:', 'nortic-plugin'),
            'not_found'             => __('No Documents found.', 'nortic-plugin'),
            'not_found_in_trash'    => __('No Documents found in Trash.', 'nortic-plugin'),
            'featured_image'        => _x('Document Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'set_featured_image'    => _x('Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'remove_featured_image' => _x('Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'use_featured_image'    => _x('Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'nortic-plugin'),
            'archives'              => _x('Document archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'nortic-plugin'),
            'insert_into_item'      => _x('Insert into Document', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'nortic-plugin'),
            'uploaded_to_this_item' => _x('Uploaded to this Document', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'nortic-plugin'),
            'filter_items_list'     => _x('Filter Documents list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'nortic-plugin'),
            'items_list_navigation' => _x('Documents list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'nortic-plugin'),
            'items_list'            => _x('Documents list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'nortic-plugin'),
        );

        $args = array(
            'labels'             => $labels,
            'public'             => true,
            'has_archive'        => false, // era true
            'hierarchical'       => true, // era false
            'show_in_rest'       => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'rewrite'            => array('slug' => 'documentos'),
            'capability_type'    => 'post',
            'menu_position'      => 21,
            'supports'           => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes'),
            'description'        => __('A custom post type for documents', 'nortic-plugin'),
        );

        register_post_type('document', $args);

        // Document type: folder, file, note or url
        register_post_meta(
            'document',
            'document_type',
            array(
                'type'          => 'string',
                'single'        => true,
                'show_in_rest'  => true,
                'description'   => __('Document Type', 'nortic-plugin'),
                // 'sanitize_callback' => 'sanitize_text_field',
                // 'auth_callback' => function () {
                //     return current_user_can('edit_posts');
                // }
            )
        );

        register_post_meta('document', 'document_parent_id', [
            'type' => 'integer',
            'description' => __('Parent', 'nortic-plugin'),
            'single' => true,
            'default' => 0,
            'show_in_rest' => true,
        ]);

        // Document url
        register_post_meta(
            'document',
            'file_url',
            array(
                'description'   => __('File URL', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

         // Document external url
         register_post_meta(
            'document',
            'document_external_url',
            array(
                'description'   => __('External URL', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'esc_url_raw',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

         // Document size readable
         register_post_meta(
            'document',
            'document_external_url_label',
            array(
                'description'   => __('External URL Label', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

         // Additional information
         register_post_meta('document', 'note', [
            'type'              => 'string',
            'description'       => __('Note', 'nortic-plugin'),
            'single'            => true,
            'show_in_rest'      => true,
            'sanitize_callback' => 'sanitize_textarea_field',
            'auth_callback'     => function () {
                return current_user_can('edit_posts');
            }
        ]);

         // Document size readable
         register_post_meta(
            'document',
            'file_size_readable',
            array(
                'description'   => __('Size', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Document size in bytes
        register_post_meta(
            'document',
            'file_size_in_bytes',
            array(
                'description'   => __('File Size in Bytes', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'integer',
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Document title
        register_post_meta(
            'document',
            'file_title',
            array(
                'description'   => __('File Title', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Document name
        register_post_meta(
            'document',
            'file_name',
            array(
                'description'   => __('File Name', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        // Document alt
        register_post_meta(
            'document',
            'file_alt',
            array(
                'description'   => __('File alt attribute', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'string',
                'show_in_rest'  => true,
                'sanitize_callback' => 'sanitize_text_field',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

        

        // Document related post ID
        register_post_meta(
            'document',
            'file_related_post',
            array(
                'description'   => __('File related Post ID', 'nortic-plugin'),
                'single'        => true,
                'type'          => 'integer',
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function () {
                    return current_user_can('edit_posts');
                }
            )
        );

       

        // Document format
        register_post_meta(
            'document',
            'file_format',
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
    }
}
