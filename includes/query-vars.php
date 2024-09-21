<?php 

if(!function_exists('nortic_plugin_add_query_vars')) {
    function nortic_plugin_add_query_vars($vars) {
        $vars[] = 'service_classification';
        $vars[] = 'service_tag';
        return $vars;
    }
}