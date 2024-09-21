<?php

if (!function_exists('nortic_plugin_directory_taxonomy')) {
    function nortic_plugin_directory_taxonomy()
    {
        $labels = array(
            'name'              => _x('Directory', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Directory', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Directory'),
            'all_items'         => _('All Directorys'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Directory'),
            'update_item'       => _('Update Directory'),
            'add_new_item'      => _('Add new Directory'),
            'new_item_name'     => _('New Directory'),
            'menu_name'         => _('Directory'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'directorio'],
            'show_in_rest'      => true,
        );

        register_taxonomy('directory', array('document'), $args);

        register_term_meta('directory', 'more_info_url', [
            'type' => 'string',
            'description' => __('A URL for more information on a dirctory', 'nortic-plugin'),
            'single' => true,
            'show_in_rest' => true,
            'default' => '#'
        ]);

        register_term_meta('directory', 'ordering', [
            'type' => 'integer',
            'description' => __('Directory order number', 'nortic-plugin'),
            'single' => true,
            'show_in_rest' => true,
            'default' => 0
        ]);

        register_term_meta('directory', 'published', [
            'type' => 'boolean',
            'description' => __('Show or hide directory', 'nortic-plugin'),
            'single' => true,
            'show_in_rest' => true,
            'default' => true
        ]);
    }
}
