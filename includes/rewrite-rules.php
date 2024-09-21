<?php 

if(!function_exists('nortic_plugin_add_rewrite_rules')) {
    function nortic_plugin_add_rewrite_rules() {
         // Reglas de reescritura para /servicios/service_classification/service_tag/
         add_rewrite_rule(
            '^servicios/([^/]+)/([^/]+)/?$',
            'index.php?service_classification=$matches[1]&service_tag=$matches[2]',
            'top'
        );

        // Reglas de reescritura para /servicios/service_classification/
        add_rewrite_rule(
            '^servicios/([^/]+)/?$',
            'index.php?service_classification=$matches[1]',
            'top'
        );

        // Reglas de reescritura para /servicios-por-categoria/service_tag/
        add_rewrite_rule(
            '^servicios-por-categoria/([^/]+)/([^/]+)/?$',
            'index.php?service_classification=$matches[1]&service_tag=$matches[2]',
            'top'
        );
    }
}