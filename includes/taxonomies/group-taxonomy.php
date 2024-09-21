<?php

if (!function_exists('nortic_plugin_group_taxonomy')) {
    /**
     * Creates or modifies a Team's Group taxonomy object
     *
     * @return void
     */
    function nortic_plugin_group_taxonomy()
    {
        $labels = array(
            'name'              => _x('Groups', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Group', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Group'),
            'all_items'         => _('All Groups'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Group'),
            'update_item'       => _('Update Group'),
            'add_new_item'      => _('Add new Group'),
            'new_item_name'     => _('New Group'),
            'menu_name'         => _('Group'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'groups', 'with_front' => false],
            'show_in_rest'      => true,
        );

        register_taxonomy('group', array('team'), $args);
    }
}
