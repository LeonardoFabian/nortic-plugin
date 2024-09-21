<?php 

if(!function_exists('nortic_plugin_save_province_meta')) {
    function nortic_plugin_save_province_meta($termID) {
        if (!isset($_POST['svg_path']) || !isset($_POST['rd_trabaja_province_id'])) {
            return;
        }

        update_term_meta(
            $termID,
            'rd_trabaja_province_id',
            absint($_POST['rd_trabaja_province_id'])
        );

        update_term_meta(
            $termID,
            'svg_path',
            wp_kses_post($_POST['svg_path'])
        );

        // update_term_meta(
        //     $termID,
        //     'svg_path',
        //     sanitize_text_field($_POST['svg_path'])
        // );
    }
}