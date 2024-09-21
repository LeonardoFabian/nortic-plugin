<?php

if (!function_exists('nortic_plugin_save_post_resolution')) {
    /**
     * Fires once a resolution has been saved/published
     *
     * @param [type] $postID
     * @return void
     */
    function nortic_plugin_save_post_resolution($postID)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /**
         * @var string $resolution_description
         * @return string Resolution description
         */
        $resolution_description = get_post_meta($postID, 'resolution_description', true);

        /**
         * @var string $resolution_number
         * @return string Resolution number
         */
        $resolution_number = get_post_meta($postID, 'resolution_number', true);

        /**
         * @var string $resolution_date
         * @return string Resolution date
         */
        $resolution_date = get_post_meta($postID, 'resolution_date', true);

        $resolution_description =
            empty($resolution_description)
            ? ''
            : sanitize_textarea_field($resolution_description);

        $resolution_number =
            empty($resolution_number)
            ? ''
            : sanitize_text_field($resolution_number);

        $resolution_date =
            empty($resolution_date)
            ? ''
            : sanitize_text_field($resolution_date);

        update_post_meta($postID, 'resolution_description', $resolution_description);

        update_post_meta($postID, 'resolution_number', $resolution_number);

        update_post_meta($postID, 'resolution_date', $resolution_date);
    }
}
