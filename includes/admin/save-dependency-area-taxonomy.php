<?php

if (!function_exists('nortic_plugin_save_area_meta')) {
    /**
     * Fires after a new term is created for a specific taxonomy.
     *
     * @param int $termID Term ID
     * @return void
     */
    function nortic_plugin_save_area_meta($termID)
    {
        if (!isset($_POST['area_classification'])) {
            return;
        }

        update_term_meta(
            $termID,
            'area_classification',
            sanitize_text_field($_POST['area_classification'])
        );
    }
}
