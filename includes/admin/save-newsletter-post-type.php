<?php

if (!function_exists('nortic_plugin_save_post_newsletter')) {
    /**
     * Fires once a newsletter has been saved/published
     *
     * @param int $postID Post ID
     * @return void
     */
    function nortic_plugin_save_post_newsletter($postID)
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    }
}
