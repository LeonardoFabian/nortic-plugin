<?php

if (!function_exists('nortic_plugin_deactivation')) {
    function nortic_plugin_deactivation()
    {
        flush_rewrite_rules();
    }
}
