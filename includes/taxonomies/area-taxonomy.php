<?php

if (!function_exists('nortic_plugin_area_taxonomy')) {
    function nortic_plugin_area_taxonomy()
    {
        $labels = array(
            'name'              => _x('Area', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Area', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Area'),
            'all_items'         => _('All Areas'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Area'),
            'update_item'       => _('Update Area'),
            'add_new_item'      => _('Add new Area'),
            'new_item_name'     => _('New Area'),
            'menu_name'         => _('Area'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'area'],
            'show_in_rest'      => true,
        );

        register_taxonomy('area', array('dependency'), $args);

        register_term_meta(
            'area',
            'area_classification',
            array(
                'description' => __('Area classification', 'nortic-plugin'),
                'type'          => 'string',
                'single'        => true,
                'show_in_rest'  => true,
            )
        );
    }
}
