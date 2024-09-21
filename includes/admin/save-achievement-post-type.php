<?php

if (!function_exists('nortic_plugin_save_post_achievement')) {
    /**
     * Fires once an achievement has been saved/published
     *
     * @param int $postID The achievement post type ID
     * @return void
     */
    function nortic_plugin_save_post_achievement($postID)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /**
         * @var boolean $highlight_achievement
         * @return string If the achievement will be highlighted
         */
        $highlight_achievement = get_post_meta($postID, 'highlight_achievement', true);

        /* validations */

        $highlight_achievement =
            empty($highlight_achievement)
            ? 0
            : absint($highlight_achievement);

        /* actions */

        update_post_meta($postID, 'highlight_achievement', $highlight_achievement);
    }
}
