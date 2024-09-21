<?php 

if(!function_exists('nortic_plugin_template_include')) {
    function nortic_plugin_template_include($template) {
        if (get_query_var('service_classification') && get_query_var('service_tag')) {
            $taxonomy_template = locate_template('taxonomy-service_tag.html');
            if ($taxonomy_template) {
                return $taxonomy_template;
            }
        } elseif (get_query_var('service_classification')) {
            $taxonomy_template = locate_template('taxonomy-service_classification.html');
            if ($taxonomy_template) {
                return $taxonomy_template;
            }
        }
        return $template;
    }
}