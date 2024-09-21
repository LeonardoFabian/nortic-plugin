<?php

if (!function_exists('nortic_plugin_newsletter_category_taxonomy')) {
    /**
     * Creates or modifies a Newsletter's Category taxonomy object
     *
     * @param int $postID Post ID
     * @return void
     */
    function nortic_plugin_newsletter_category_taxonomy($postID)
    {
        $labels = array(
            'name'              => _x('Newsletter Categories', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Newsletter Category', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Newsletter Category'),
            'all_items'         => _('All Newsletter Categories'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Newsletter Category'),
            'update_item'       => _('Update Newsletter Category'),
            'add_new_item'      => _('Add new Newsletter Category'),
            'new_item_name'     => _('New Newsletter Category'),
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

        register_taxonomy('newsletter_category', array('newsletter'), $args);
    }
}
