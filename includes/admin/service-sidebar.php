<?php

if (!function_exists('nortic_plugin_service_sidebar')) {
    function nortic_plugin_service_sidebar()
    {
        register_sidebar(array(
            'name' => __('Service Page Sidebar', 'nortic-plugin'),
            'id' => 'service-sidebar',
            'before_widget' => '',
            'after_widget' => '',
            'before_title' => '<h4>',
            'after_title' => '</h4>'
        ));
    }
}
