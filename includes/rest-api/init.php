<?php

if (!function_exists('nortic_plugin_rest_api_init')) {
    function nortic_plugin_rest_api_init()
    {
        // $ratingMode = $request['ratingMode'];
        // $permission = '';

        // switch ($ratingMode) {
        //     case 'username':
        //         $permission = 'is_user_logged_in';
        //         break;

        //     case 'cookie':
        //         $permission = '__return_true';
        //         break;

        //     default:
        //         $permission = '__return_true';
        //         break;
        // }

        // http://wordpressmt.local/np/v1/rate
        register_rest_route('np/v1', '/rate', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'nortic_plugin_rest_api_add_rating_handler',
            'permission_callback' => '__return_true'
        ]);

        // http://wordpressmt.local/np/v1/completion/create
        // register_rest_route('np/v1', '/create-completion', [
        //     'methods' => WP_REST_Server::CREATABLE,
        //     'callback' => function () {
        //         wp_enqueue_script('openai', NORTIC_PLUGIN_URL . 'src/blocks/chatbot/openai.js', array('wp-api', 'wp-i18n', 'wp-components'), NORTIC_PLUGIN_VERSION, true);
        //     },
        //     'permission_callback' => '__return_true'
        // ]);

        // http://wordpressmt.local/np/v1/completion
        register_rest_route('np/v1', '/completion', [
            'methods' => WP_REST_Server::CREATABLE,
            'callback' => 'nortic_plugin_rest_create_chat_completion',
            'permission_callback' => '__return_true', // All users capability
        ]);
    }
}
