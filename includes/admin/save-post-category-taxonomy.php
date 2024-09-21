<?php

if (!function_exists('nortic_plugin_save_category_meta')) {
    /**
     * Fires after a new term is created for a specific taxonomy.
     *
     * @param int $termID Term ID
     * @return void
     */
    function nortic_plugin_save_category_meta($termID)
    {

        if (
            !isset($_POST['taxonomy_color'])
        ) {
            return;
        }

        update_term_meta(
            $termID,
            'taxonomy_color',
            sanitize_text_field($_POST['taxonomy_color'])
        );
    }
}
