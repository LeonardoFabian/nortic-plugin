<?php

if (!function_exists('nortic_plugin_save_post_document')) {
    /**
     * Fires once a document has been saved/published
     *
     * @return void
     */
    function nortic_plugin_save_post_document()
    {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    }
}
