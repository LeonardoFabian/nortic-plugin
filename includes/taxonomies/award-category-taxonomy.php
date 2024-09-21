<?php

if (!function_exists('nortic_plugin_award_category_taxonomy')) {
    /**
     * Creates or modifies a Award's Category taxonomy object
     *
     * @param int $postID Post ID
     * @return void
     */
    function nortic_plugin_award_category_taxonomy($postID)
    {
        $labels = array(
            'name'              => _x('Award Categories', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Award Category', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Award Category'),
            'all_items'         => _('All Award Categories'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Award Category'),
            'update_item'       => _('Update Award Category'),
            'add_new_item'      => _('Add new Award Category'),
            'new_item_name'     => _('New Award Category'),
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

        register_taxonomy('award_category', array('award'), $args);

        wp_insert_term('nortic', 'award_category', array(
            'description' => 'Sellos NORTIC',
            'slug' => 'nortic',
            'parent' => 0
        ));

        wp_insert_term('awards', 'award_category', array(
            'description' => 'Awards received',
            'slug' => 'awards',
            'parent' => 0
        ));
    }
}
