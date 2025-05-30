<?php

if (!function_exists('nortic_plugin_activation')) {
    /**
     * Set the nortic plugin activation
     *
     * @return void
     */
    function nortic_plugin_activation()
    {
        // Prevent the user from using a compatible version of WordPress
        if (version_compare(get_bloginfo('version'), '5.9', '<')) {
            wp_die(__('You must updated WordPress to use this plugin', 'nortic-plugin'));
        }

        // Register plugin post types
        nortic_plugin_achievement_post_type();
        nortic_plugin_award_post_type();
        nortic_plugin_content_post_type();
        nortic_plugin_dependency_post_type();
        nortic_plugin_document_post_type();
        nortic_plugin_event_post_type();
        nortic_plugin_faq_post_type();
        nortic_plugin_gallery_post_type();
        nortic_plugin_newsletter_post_type();
        nortic_plugin_service_post_type();
        nortic_plugin_system_post_type();
        nortic_plugin_team_post_type();
        // nortic_plugin_certificate_post_type();
        
        nortic_plugin_resolution_post_type();
        nortic_plugin_resource_post_type();

        // rewrite the rules so that WordPress stores the path of the custom post types
        flush_rewrite_rules();

        global $wpdb;

        $ratings_table = "{$wpdb->prefix}nortic_plugin_ratings";
        $documents_table = "{$wpdb->prefix}nortic_plugin_documents";
        $locations_table = "{$wpdb->prefix}nortic_plugin_locations";
        $contacts_table = "{$wpdb->prefix}nortic_plugin_contacts";
        $chatbot_messages_table = "{$wpdb->prefix}nortic_plugin_chatbot_messages";
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "
        CREATE TABLE {$ratings_table} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            post_id bigint(20) unsigned NOT NULL,
            user_id bigint(20) unsigned NULL,
            cookie longtext NULL,
            rating_date timestamp,
            rating float(3,2) unsigned NOT NULL
        ) ENGINE='InnoDB' {$charset_collate};
        ";

        $sql .= "
        CREATE TABLE {$documents_table} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            post_id bigint(20) unsigned NOT NULL,
            file longtext NULL,
            hits bigint(20) unsigned NOT NULL,
            size int unsigned NOT NULL
        ) ENGINE='InnoDB' {$charset_collate};
        ";

        $sql .= " 
        CREATE TABLE {$locations_table} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            post_id bigint(20) unsigned NOT NULL,
            address longtext NOT NULL,
            coordinate point NOT NULL
        ) ENGINE='InnoDB' {$charset_collate};
        ";

        $sql .= "
        CREATE TABLE {$contacts_table} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            post_id bigint(20) unsigned NOT NULL,
            name varchar(200) NULL,
            job varchar(200) NULL,
            phone varchar(255) NULL,
            mobile varchar(255) NULL,
            email varchar(255) NULL
        ) ENGINE='InnoDB' {$charset_collate};
        ";

        $sql .= "
        CREATE TABLE {$chatbot_messages_table} (
            ID bigint(20) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
            session_id varchar(255) NOT NULL,
            text longtext NOT NULL,
            message_date timestamp,
            parent_id int unsigned NULL,
            ip_address varchar(30) NULL
        ) ENGINE='InnoDB' {$charset_collate};
        ";

        require_once(ABSPATH . '/wp-admin/includes/upgrade.php');

        dbDelta($sql);

        # Plugin options

        $pluginOptions = get_option('nortic_plugin_options');

        if (!$pluginOptions) {
            add_option('nortic_plugin_options', [
                'np_google_analytics_ua_code' => '',
                'np_sello_nortic_web' => '',
                'np_sello_nortic_mobile' => '',
                'np_theme_logo' => '',
                'np_theme_footer_logo' => '',

                'np_facebook_url' => '',
                'np_facebook_color' => '#3b5998',
                'np_facebook_enable' => 1,
                'np_instagram_url' => '',
                'np_instagram_color' => '#e1306c',
                'np_instagram_enable' => 1,
                'np_twitter_url' => '',
                'np_twitter_color' => '#00acee',
                'np_twitter_enable' => 1,
                'np_youtube_url' => '',
                'np_youtube_color' => '#c4302b',
                'np_youtube_enable' => 1,
                'np_linkedin_url' => '',
                'np_linkedin_color' => '#0072b1',
                'np_linkedin_enable' => 1,
                'np_flickr_url' => '',
                'np_flickr_color' => '#0063dc',
                'np_flickr_enable' => 1,
                'np_pinterest_url' => '',
                'np_pinterest_color' => '#c8232c',
                'np_pinterest_enable' => 1,
                'np_whatsapp_url' => '',
                'np_whatsapp_color' => '#25d366',
                'np_whatsapp_enable' => 1,

                'np_website_release_date' => '',

                'np_organization_name' => get_bloginfo('name'),
                'np_street_address' => '',
                'np_city' => '',
                'np_address_locality' => '',
                'np_postal_code' => '',
                'np_email' => '',
                'np_phone' => '',
                'np_fax_number' => '',
                'np_latitude' => '',
                'np_longitude' => '',

                'np_regulation_type' => '',
                'np_regulation_number' => '',
                'np_foundation_date' => '',
                'np_organization_holder' => ''
            ]);
        }

        $openGraphOptions = get_option('nortic_plugin_opengraph_options');

        if (!$openGraphOptions) {
            add_option('nortic_plugin_opengraph_options', [
                'np_og_title' => get_bloginfo('name'),
                'np_og_image' => '',
                'np_og_description' => get_option('blogdescription'),
                'np_enable_og' => 1
            ]);
        }

        $chatbotOptions = get_option('nortic_plugin_chatbot_options');

        if (!$chatbotOptions) {
            add_option('nortic_plugin_chatbot_options', [
                'np_chatbot_openai_apikey' => '',
                'np_chatbot_openai_model' => 'text-davinci-003',
                'np_chatbot_openai_temperature' => 0.7,
                'np_chatbot_openai_top_p' => 0.4,
                'np_chatbot_openai_max_tokens' => 1024,
                'np_enable_chatbot' => 1
            ]);
        }
    }
}
