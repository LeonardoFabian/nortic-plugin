<?php

if (!function_exists('nortic_plugin_admin_menus')) {
    /**
     * Load plugin high level menu in the admin.
     *
     * @return void
     */
    function nortic_plugin_admin_menus()
    {
        # Plugin menu page
        add_menu_page(
            __('Nortic Plugin', 'nortic-plugin'),
            __('Nortic Plugin', 'nortic-plugin'),
            'edit_theme_options',
            'nortic-plugin-options', // menu slug
            'nortic_plugin_options_page',
            plugins_url('includes/assets/images/domo20x20.svg', NORTIC_PLUGIN_FILE)
        );

        # Open Graph submenu page
        add_submenu_page(
            'nortic-plugin-options',
            __('Opengraph Settings', 'nortic-plugin'),
            __('Opengraph Settings', 'nortic-plugin'),
            'edit_theme_options',
            'nortic-plugin-opengraph-options', // submenu slug or load in existing page: edit.php?post_type=service
            'nortic_plugin_opengraph_options_page', // null if the content be loaded in existing page
            null
        );

        # Chatbot submenu page
        add_submenu_page(
            'nortic-plugin-options',
            __('Chatbot Settings', 'nortic-plugin'),
            __('Chatbot Settings', 'nortic-plugin'),
            'edit_theme_options',
            'nortic-plugin-chatbot-options',
            'nortic_plugin_chatbot_options_page',
            null
        );

        # Social Networks submenu page
        add_submenu_page(
            'nortic-plugin-options',
            __('Social Networks', 'nortic-plugin'),
            __('Social Networks', 'nortic-plugin'),
            'edit_theme_options',
            'nortic-plugin-social-networks-options',
            'nortic_plugin_social_networks_options_page',
            null
        );

        # Contact submenu page
        add_submenu_page(
            'nortic-plugin-options',
            __('Organization Data', 'nortic-plugin'),
            __('Organization Data', 'nortic-plugin'),
            'edit_theme_options',
            'nortic-plugin-organization-data-options',
            'nortic_plugin_organization_data_options_page',
            null
        );
    }
}
