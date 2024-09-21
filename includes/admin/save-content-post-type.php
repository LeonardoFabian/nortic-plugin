<?php

if (!function_exists('nortic_plugin_save_post_content')) {
    /**
     * Fires once a content has been saved/published
     *
     * @return void
     */
    function nortic_plugin_save_post_content($postID)
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    }
}
