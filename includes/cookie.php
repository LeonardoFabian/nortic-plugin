<?php

if (!function_exists('nortic_plugin_set_new_cookie')) {
    function nortic_plugin_set_new_cookie()
    {
        setcookie('trabajord-cookie', 'trabajord', time() + 3600, COOKIEPATH, COOKIE_DOMAIN);
    }
}
add_action('init', 'nortic_plugin_set_new_cookie');

if (!function_exists('nortic_plugin_set_new_chatbot_cookie')) {
    function nortic_plugin_set_new_chatbot_cookie($string)
    {
        setcookie('nortic_chatbot_cookie', $string, 0, COOKIEPATH, COOKIE_DOMAIN);

        $cookie = (isset($_COOKIE['nortic_chatbot_cookie'])) ? $_COOKIE['nortic-chatbot-cookie'] : "";

        return $cookie;
    }
}

if (!function_exists('nortic_plugin_rating_set_cookie')) {
    function nortic_plugin_rating_set_cookie($post_id, $ip, $date)
    {
        // set default timezone
        date_default_timezone_set('America/Santo_Domingo');

        $expiretime = $date;
        $postID = strval($post_id);
        $time = time();
        $time = date('Ymd', $time);

        $cookieName = 'nortic_plugin_rating_cookie_' . $postID;

        if (!isset($_COOKIE[$cookieName])) {
            setcookie($cookieName, $postID . '.' . $ip . '.' . $time, time() +  $expiretime);
        }

        return $_COOKIE[$cookieName];

        // return $ratingCookie;
    }
}
