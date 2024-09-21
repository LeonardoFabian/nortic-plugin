<?php

if (!function_exists('nortic_plugin_resolution_category_taxonomy')) {
    /**
     * Creates or modifies a Resolution's Category taxonomy object
     *
     * @return void
     */
    function nortic_plugin_resolution_category_taxonomy()
    {
        $labels = array(
            'name'              => _x('Resolution Categories', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Resolution Category', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Resolution Category'),
            'all_items'         => _('All Resolution Categories'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Resolution Category'),
            'update_item'       => _('Update Resolution Category'),
            'add_new_item'      => _('Add new Resolution Category'),
            'new_item_name'     => _('New Resolution Category'),
            'menu_name'         => _('Category'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'categories', 'with_front' => false],
            'show_in_rest'      => true,
        );

        register_taxonomy('resolution_category', array('resolution'), $args);
    }
}
