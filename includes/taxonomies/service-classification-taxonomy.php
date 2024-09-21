<?php

if (!function_exists('nortic_plugin_service_classification_taxonomy')) {
    /**
     * Creates of modifies a Service's Classification taxonomy object
     *
     * @return void
     */
    function nortic_plugin_service_classification_taxonomy()
    {
        $labels = array(
            'name'              => _x('Classifications', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Classification', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => __('Search Classifications', 'nortic-plugin'),
            'all_items'         => __('All Classifications', 'nortic-plugin'),
            'parent_item'       => __('Parent classification', 'nortic-plugin'),
            'parent_item_colon' => __('Parent:', 'nortic-plugin'),
            'edit_item'         => __('Edit Classification', 'nortic-plugin'),
            'update_item'       => __('Update Classification', 'nortic-plugin'),
            'add_new_item'      => __('Add new Classification', 'nortic-plugin'),
            'new_item_name'     => __('New Classification', 'nortic-plugin'),
            'menu_name'         => __('Classification', 'nortic-plugin'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'servicios-por-area', 'with_front' => true],
            'show_in_rest'      => true,
        );

        register_taxonomy('service_classification', array('service'), $args);

        register_term_meta('', 'color', [
            'type' => 'string',
            'description' => __('HEX color code', 'nortic-plugin'),
            'single' => true,
            'show_in_rest' => true,
            'default' => '#FFFFFF'
        ]);
    }
}
