<?php

if (!function_exists('nortic_plugin_save_directory_meta')) {
    /**
     * Fires after a new term is created for a specific taxonomy.
     *
     * @param int $termID Term ID
     * @return void
     */
    function nortic_plugin_save_directory_meta($termID)
    {

        if (
            !isset($_POST['directory_published'])
        ) {
            return;
        }

        update_term_meta(
            $termID,
            'more_info_url',
            esc_url_raw($_POST['directory_more_info_url'])
        );

        update_term_meta(
            $termID,
            'ordering',
            sanitize_text_field($_POST['directory_ordering'])
        );

        update_term_meta(
            $termID,
            'published',
            sanitize_text_field($_POST['directory_published'])
        );
    }
}
