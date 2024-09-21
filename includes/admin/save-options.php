<?php

if (!function_exists('nortic_plugin_save_options')) {
    /**
     * Fires on an authenticated admin post request for the plugin save options action.
     *
     * @return void
     */
    function nortic_plugin_save_options()
    {
        // print_r($_POST);

        if (!current_user_can('edit_theme_options')) {
            wp_die(
                __("You are not allowed to be in this page.", "nortic-plugin"),
                __('Access Denied', "nortic-plugin")
            );
        }

        // Check if the user was referred from another admin page with the correct security nonce
        check_admin_referer('nortic_plugin_options_verify');

        $options = get_option('nortic_plugin_options');

        $page = isset($_POST['page'])
            ? sanitize_text_field($_POST['page'])
            : 'nortic-plugin-options';

        $options['np_google_analytics_ua_code'] =
            (isset($_POST['np_google_analytics_ua_code']) && !empty($_POST['np_google_analytics_ua_code']))
            ? sanitize_textarea_field($_POST['np_google_analytics_ua_code'])
            : $options['np_google_analytics_ua_code'];

        $selloNorticWeb = nortic_plugin_sanitize_iframe($_POST['np_sello_nortic_web']);

        $options['np_sello_nortic_web'] =
            (isset($_POST['np_sello_nortic_web']) && !empty($_POST['np_sello_nortic_web']))
            ? $selloNorticWeb
            : $options['np_sello_nortic_web'];

        $selloNorticMobile = nortic_plugin_sanitize_iframe($_POST['np_sello_nortic_mobile']);

        $options['np_sello_nortic_mobile'] =
            (isset($_POST['np_sello_nortic_mobile']) && !empty($_POST['np_sello_nortic_mobile']))
            ? $selloNorticMobile
            : $options['np_sello_nortic_mobile'];

        $options['np_theme_logo'] =
            (isset($_POST['np_theme_logo']) && !empty($_POST['np_theme_logo']))
            ? esc_url_raw($_POST['np_theme_logo'])
            : $options['np_theme_logo']; // sanitize_url()

        $options['np_theme_footer_logo'] =
            (isset($_POST['np_theme_footer_logo']) && !empty($_POST['np_theme_footer_logo']))
            ? esc_url_raw($_POST['np_theme_footer_logo'])
            : $options['np_theme_footer_logo'];

        $options['np_facebook_url'] =
            (isset($_POST['np_facebook_url']) && !empty($_POST['np_facebook_url']))
            ? esc_url_raw($_POST['np_facebook_url'])
            : $options['np_facebook_url'];

        $options['np_facebook_color'] =
            (isset($_POST['np_facebook_color']) && !empty($_POST['np_facebook_color']))
            ? sanitize_hex_color($_POST['np_facebook_color'])
            : $options['np_facebook_color'];

        $options['np_facebook_enable'] =
            (isset($_POST['np_facebook_enable']))
            ? absint($_POST['np_facebook_enable'])
            : 0;

        $options['np_instagram_url'] =
            (isset($_POST['np_instagram_url']) && !empty($_POST['np_instagram_url']))
            ? esc_url_raw($_POST['np_instagram_url'])
            : $options['np_instagram_url'];

        $options['np_instagram_color'] =
            (isset($_POST['np_instagram_color']) && !empty($_POST['np_instagram_color']))
            ? sanitize_hex_color($_POST['np_instagram_color'])
            : $options['np_instagram_color'];

        $options['np_instagram_enable'] =
            (isset($_POST['np_instagram_enable']))
            ? absint($_POST['np_instagram_enable'])
            : 0;

        $options['np_twitter_url'] =
            (isset($_POST['np_twitter_url']) && !empty($_POST['np_twitter_url']))
            ? esc_url_raw($_POST['np_twitter_url'])
            : $options['np_twitter_url'];

        $options['np_twitter_color'] =
            (isset($_POST['np_twitter_color']) && !empty($_POST['np_twitter_color']))
            ? sanitize_hex_color($_POST['np_twitter_color'])
            : $options['np_twitter_color'];

        $options['np_twitter_enable'] =
            (isset($_POST['np_twitter_enable']))
            ? absint($_POST['np_twitter_enable'])
            : 0;

        $options['np_youtube_url'] =
            (isset($_POST['np_youtube_url']) && !empty($_POST['np_youtube_url']))
            ? esc_url_raw($_POST['np_youtube_url'])
            : $options['np_youtube_url'];

        $options['np_youtube_color'] =
            (isset($_POST['np_youtube_color']) && !empty($_POST['np_youtube_color']))
            ? sanitize_hex_color($_POST['np_youtube_color'])
            : $options['np_youtube_color'];

        $options['np_youtube_enable'] =
            (isset($_POST['np_youtube_enable']))
            ? absint($_POST['np_youtube_enable'])
            : 0;

        $options['np_linkedin_url'] =
            (isset($_POST['np_linkedin_url']) && !empty($_POST['np_linkedin_url']))
            ? esc_url_raw($_POST['np_linkedin_url'])
            : $options['np_linkedin_url'];

        $options['np_linkedin_color'] =
            (isset($_POST['np_linkedin_color']) && !empty($_POST['np_linkedin_color']))
            ? sanitize_hex_color($_POST['np_linkedin_color'])
            : $options['np_linkedin_color'];

        $options['np_linkedin_enable'] =
            (isset($_POST['np_linkedin_enable']))
            ? absint($_POST['np_linkedin_enable'])
            : 0;

        $options['np_flickr_url'] =
            (isset($_POST['np_flickr_url']) && !empty($_POST['np_flickr_url']))
            ? esc_url_raw($_POST['np_flickr_url'])
            : $options['np_flickr_url'];

        $options['np_flickr_color'] =
            (isset($_POST['np_flickr_color']) && !empty($_POST['np_flickr_color']))
            ? sanitize_hex_color($_POST['np_flickr_color'])
            : $options['np_flickr_color'];

        $options['np_flickr_enable'] =
            (isset($_POST['np_flickr_enable']))
            ? absint($_POST['np_flickr_enable'])
            : 0;

        $options['np_pinterest_url'] =
            (isset($_POST['np_pinterest_url']) && !empty($_POST['np_pinterest_url']))
            ? esc_url_raw($_POST['np_pinterest_url'])
            : $options['np_pinterest_url'];

        $options['np_pinterest_color'] =
            (isset($_POST['np_pinterest_color']) && !empty($_POST['np_pinterest_color']))
            ? sanitize_hex_color($_POST['np_pinterest_color'])
            : $options['np_pinterest_color'];

        $options['np_pinterest_enable'] =
            (isset($_POST['np_pinterest_enable']))
            ? absint($_POST['np_pinterest_enable'])
            : 0;

        $options['np_whatsapp_url'] =
            (isset($_POST['np_whatsapp_url']) && !empty($_POST['np_whatsapp_url']))
            ? esc_url_raw($_POST['np_whatsapp_url'])
            : $options['np_whatsapp_url'];

        $options['np_whatsapp_color'] =
            (isset($_POST['np_whatsapp_color']) && !empty($_POST['np_whatsapp_color']))
            ? sanitize_hex_color($_POST['np_whatsapp_color'])
            : $options['np_whatsapp_color'];

        $options['np_whatsapp_enable'] =
            (isset($_POST['np_whatsapp_enable']))
            ? absint($_POST['np_whatsapp_enable'])
            : 0;

        update_option('nortic_plugin_options', $options);

        wp_redirect(admin_url('admin.php?page=' . $page . '&status=1'));
    }
}

if (!function_exists('nortic_plugin_opengraph_save_options')) {
    /**
     * Fires on an authenticated admin post request for the plugin save Open Graph options action.
     *
     * @return void
     */
    function nortic_plugin_opengraph_save_options()
    {
        // print_r($_POST);

        if (!current_user_can('edit_theme_options')) {
            wp_die(
                __("You are not allowed to be in this page.", "nortic-plugin"),
                __('Access Denied', "nortic-plugin")
            );
        }

        // Check if the user was referred from another admin page with the correct security nonce
        check_admin_referer('nortic_plugin_opengraph_options_verify');

        $options = get_option('nortic_plugin_opengraph_options');

        $page = 'nortic-plugin-opengraph-options';

        $options['np_og_title'] =
            (isset($_POST['np_og_title']) && !empty($_POST['np_og_title']))
            ? sanitize_text_field($_POST['np_og_title'])
            : $options['np_og_title'];

        $options['np_og_image'] =
            (isset($_POST['np_og_image']) && !empty($_POST['np_og_image']))
            ? esc_url_raw($_POST['np_og_image'])
            : $options['np_og_image'];

        $options['np_og_description'] =
            (isset($_POST['np_og_description']) && !empty($_POST['np_og_description']))
            ? sanitize_text_field($_POST['np_og_description'])
            : $options['np_og_description'];

        $options['np_enable_og'] =
            (isset($_POST['np_enable_og']))
            ? absint($_POST['np_enable_og'])
            : 0;

        update_option('nortic_plugin_opengraph_options', $options);

        wp_redirect(admin_url('admin.php?page=' . $page . '&status=1'));
    }
}

if (!function_exists('nortic_plugin_chatbot_save_options')) {
    /**
     * Fires on an authenticated admin post request for the plugin save OpenAI options action.
     *
     * @return void
     */
    function nortic_plugin_chatbot_save_options()
    {
        // print_r($_POST);

        if (!current_user_can('edit_theme_options')) {
            wp_die(
                __("You are not allowed to be in this page.", "nortic-plugin"),
                __('Access Denied', "nortic-plugin")
            );
        }

        // Check if the user was referred from another admin page with the correct security nonce
        check_admin_referer('nortic_plugin_chatbot_options_verify');

        $options = get_option('nortic_plugin_chatbot_options');

        $page = 'nortic-plugin-chatbot-options';

        $options['np_chatbot_openai_apikey'] =
            (isset($_POST['np_chatbot_openai_apikey']) && !empty($_POST['np_chatbot_openai_apikey']))
            ? sanitize_text_field($_POST['np_chatbot_openai_apikey'])
            : $options['np_chatbot_openai_apikey'];

        $options['np_chatbot_openai_model'] =
            (isset($_POST['np_chatbot_openai_model']) && !empty($_POST['np_chatbot_openai_model']))
            ? sanitize_text_field($_POST['np_chatbot_openai_model'])
            : $options['np_chatbot_openai_model'];

        $options['np_chatbot_openai_temperature'] =
            (isset($_POST['np_chatbot_openai_temperature']) && !empty($_POST['np_chatbot_openai_temperature']))
            ? (float) $_POST['np_chatbot_openai_temperature']
            : $options['np_chatbot_openai_temperature'];

        $options['np_chatbot_openai_top_p'] =
            (isset($_POST['np_chatbot_openai_top_p']) && !empty($_POST['np_chatbot_openai_top_p']))
            ? (float) $_POST['np_chatbot_openai_top_p']
            : $options['np_chatbot_openai_top_p'];

        $options['np_chatbot_openai_max_tokens'] =
            (isset($_POST['np_chatbot_openai_max_tokens']) && !empty($_POST['np_chatbot_openai_max_tokens']))
            ? absint($_POST['np_chatbot_openai_max_tokens'])
            : $options['np_chatbot_openai_max_tokens'];

        $options['np_enable_chatbot'] =
            (isset($_POST['np_enable_chatbot']))
            ? absint($_POST['np_enable_chatbot'])
            : 0;

        update_option('nortic_plugin_chatbot_options', $options);

        wp_redirect(admin_url('admin.php?page=' . $page . '&status=1'));
    }
}
