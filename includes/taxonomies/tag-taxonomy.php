<?php

if (!function_exists('nortic_plugin_service_tag_taxonomy')) {
    /**
     * Creates of modifies a Service's Classification taxonomy object
     *
     * @return void
     */
    function nortic_plugin_service_tag_taxonomy()
    {
        $labels = array(
            'name'              => _x('Tags', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Tag', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => __('Search Tags', 'nortic-plugin'),
            'all_items'         => __('All Tags', 'nortic-plugin'),
            'parent_item'       => null,
            'parent_item_colon' => null,
            'edit_item'         => __('Edit Tag', 'nortic-plugin'),
            'update_item'       => __('Update Tag', 'nortic-plugin'),
            'add_new_item'      => __('Add New Tag', 'nortic-plugin'),
            'new_item_name'     => __('New Tag Name', 'nortic-plugin'),
            'separate_items_with_commas' => __( 'Separate tags with commas', 'nortic-plugin' ),
            'add_or_remove_items' => __( 'Add or remove tags', 'nortic-plugin' ),
            'choose_from_most_used' => __( 'Choose from the most used tags', 'nortic-plugin' ),
            'menu_name'         => __('Tags', 'nortic-plugin'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'update_count_callback' => '_update_post_term_count',
            'rewrite'           => array('slug' => "servicios-por-categoria", 'with_front' => true),
            'show_in_rest'      => true,
        );

        register_taxonomy('service_tag', array('service'), $args);

        register_term_meta('service', 'icon', [
            'type' => 'string',
            'description' => __('Bootstrap icon font', 'nortic-plugin'),
            'single' => true,
            'show_in_rest' => true,
            'default' => '<i class="bi bi-tag"></i>'
        ]);
    }
}
