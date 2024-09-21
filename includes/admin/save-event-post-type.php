<?php

if (!function_exists('nortic_plugin_save_post_event')) {
    /**
     * Fires once an event has been saved/published
     *
     * @param int $postID The event post type ID.
     * @return void
     */
    function nortic_plugin_save_post_event($postID)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /**
         * @var string $begin_date
         * @return string The event begin date
         */
        $begin_date = get_post_meta($postID, 'begin_date', true);

        /**
         * @var string $end_date
         * @return string The event end date
         */
        $end_date = get_post_meta($postID, 'end_date', true);

        /**
         * @var string $is_expired
         * @return boolean Return true if is's expired
         */
        $is_expired = get_post_meta($postID, 'is_expired', true);

        /**
         * @var string $location
         * @return string Dependency location address
         */
        $location = get_post_meta($postID, 'location', true);

        /* validations */

        $begin_date =
            empty($begin_date)
            ? ''
            : sanitize_text_field($begin_date);

        $end_date =
            empty($end_date)
            ? ''
            : sanitize_text_field($end_date);

        $is_expired =
            empty($is_expired)
            ? 0
            : nortic_plugin_sanitize_event_duration($end_date);

        $location =
            empty($location)
            ? ''
            : sanitize_textarea_field($location);

        /* actions */

        update_post_meta($postID, 'begin_date', $begin_date);

        update_post_meta($postID, 'end_date', $end_date);

        update_post_meta($postID, 'is_expired', $is_expired);

        update_post_meta($postID, 'location', $location);
    }
}
