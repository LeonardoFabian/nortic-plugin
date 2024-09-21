<?php

if (!function_exists('nortic_plugin_save_post_faq')) {
    /**
     * Fires once a FAQ has been saved/published
     *
     * @return void
     */
    function nortic_plugin_save_post_faq()
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // code...
    }
}
