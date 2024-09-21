<?php 

if(!function_exists('nortic_plugin_save_post_system')) {
    function nortic_plugin_save_post_system($postID) {

        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    }
}