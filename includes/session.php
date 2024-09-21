<?php

if (!function_exists('nortic_plugin_session_start')) {
    function nortic_plugin_session_start()
    {
        if (!session_id()) {
            session_start();
        }
    }
}
