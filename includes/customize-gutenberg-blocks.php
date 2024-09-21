<?php 

if(!function_exists('nortic_plugin_custom_archive_title')) {
    function nortic_plugin_custom_archive_title($title) {
        if (is_tax('service_classification')) {
            $title = single_term_title('', false);
        } elseif (is_tax('service_tag')) {
            $title = single_term_title('', false);
        }
        return $title;
    }
}