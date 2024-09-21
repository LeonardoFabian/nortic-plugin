<?php 

if(!function_exists('nortic_plugin_province_taxonomy')) {
    function nortic_plugin_province_taxonomy() {
        $labels = array(
            'name'              => _x('Province', 'taxonomy general name', 'nortic-plugin'),
            'singular_name'     => _x('Province', 'taxonomy singular name', 'nortic-plugin'),
            'search_items'      => _('Search Province'),
            'all_items'         => _('All Province'),
            'parent_item'       => _('Parent'),
            'parent_item_colon' => _('Parent:'),
            'edit_item'         => _('Edit Province'),
            'update_item'       => _('Update Province'),
            'add_new_item'      => _('Add new Province'),
            'new_item_name'     => _('New Province'),
            'menu_name'         => _('Province'),
        );

        $args = array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => ['slug' => 'provincia'],
            'show_in_rest'      => true,
        );

        register_taxonomy(
            'province',
            array(
                'dependency',
                'post',
                'event',
            ), 
            $args
        );

        register_term_meta(
            'province',
            'rd_trabaja_province_id',
            array(
                'description' => __('RD-Trabaja province ID', 'nortic-plugin'),
                'type' => 'integer',
                'single' => true,
                'show_in_rest'  => true,
                'sanitize_callback' => 'absint',
                'auth_callback' => function() {
                    return current_user_can('edit_terms');
                }
            )        
        );

        register_term_meta(
            'province',
            'svg_path',
            array(
                'description' => __('SVG path', 'nortic-plugin'),
                'type'          => 'string',
                'single'        => true,
                'show_in_rest'  => true,
                'sanitize_callback' => 'wp_kses_post',
                'auth_callback' => function() {
                    return current_user_can('edit_terms');
                }
            )
        );
    }

}