<?php

if (!function_exists('nortic_plugin_faq_category_taxonomy')) {
    /**
     * Creates or modifies a FAQ's Category taxonomy object
     *
     * @param int $postID Post ID
     * @return void
     */
    function nortic_plugin_faq_category_taxonomy($postID)
    {
        $labels = array(
            'name'              => _x('FAQ Categories', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('FAQ Category', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search FAQ Category'),
            'all_items'         => _('All FAQ Categories'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit FAQ Category'),
            'update_item'       => _('Update FAQ Category'),
            'add_new_item'      => _('Add new FAQ Category'),
            'new_item_name'     => _('New FAQ Category'),
            'menu_name'         => _('Category'),
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'faqs', 'with_front' => false],
            'show_in_rest'      => true,
        );

        register_taxonomy('faq_category', array('faq'), $args);

        wp_insert_term('faqs', 'faq_category', array(
            'description' => 'General Frequently Asked Questions',
            'slug' => 'faqs',
            'parent' => 0
        ));
    }
}
