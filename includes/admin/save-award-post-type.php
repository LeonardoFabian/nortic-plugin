<?php

if (!function_exists('nortic_plugin_save_post_award')) {
    /**
     * Fires once an award has been saved/published
     *
     * @param int $postID The award post type ID
     * @return void
     */
    function nortic_plugin_save_post_award($postID)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /**
         * @var string $iframe
         * @return string Embed content
         */
        $iframe = get_post_meta($postID, 'iframe', true);

        /**
         * @var string $identification_number
         * @return string Identification Number
         */
        $identification_number = get_post_meta($postID, 'identification_number', true);

        /**
         * @var string $expiry_date
         * @return string Expiry date
         */
        $expiry_date = get_post_meta($postID, 'expiry_date', true);

        /**
         * @var string $is_expired
         * @return boolean Return true if is's expired
         */
        $is_expired = get_post_meta($postID, 'is_expired', true);

        /**
         * @var string $description
         * @return string Description
         */
        $description = get_post_meta($postID, 'description', true);

        /**
         * @var string $url
         * @return string Return a link
         */
        $url = get_post_meta($postID, 'url', true);

        /* validations */

        $iframe =
            empty($iframe)
            ? ''
            : nortic_plugin_sanitize_iframe($iframe);

        $identification_number =
            empty($identification_number)
            ? ''
            : sanitize_text_field($identification_number);

        $expiry_date =
            empty($expiry_date)
            ? ''
            : sanitize_text_field($expiry_date);

        $is_expired =
            empty($is_expired)
            ? 0
            : nortic_plugin_sanitize_event_duration($expiry_date);

        $description =
            empty($description)
            ? ''
            : sanitize_textarea_field($description);

        $url =
            empty($url)
            ? ''
            : esc_url_raw($url);

        update_post_meta($postID, 'iframe', $iframe);
        update_post_meta($postID, 'identification_number', $identification_number);
        update_post_meta($postID, 'expiry_date', $expiry_date);
        update_post_meta($postID, 'is_expired', $is_expired);
        update_post_meta($postID, 'description', $description);
        update_post_meta($postID, 'url', $url);
    }
}
