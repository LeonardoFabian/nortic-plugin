<?php

if (!function_exists('nortic_plugin_dependency_category_taxonomy')) {
    function nortic_plugin_dependency_category_taxonomy()
    {
        $labels = array(
            'name'              => _x('Dependency Category', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Dependency Category', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Dependency Category'),
            'all_items'         => _('All Dependency Categories'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Dependency Category'),
            'update_item'       => _('Update Dependency Category'),
            'add_new_item'      => _('Add new Dependency Category'),
            'new_item_name'     => _('New Dependency Category'),
            'menu_name'         => _('Category'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'dependency-category'],
            'show_in_rest'      => true,
        );

        register_taxonomy('dependency_category', array('dependency'), $args);
    }
}
