<?php

if (!function_exists('nortic_plugin_admin_enqueue_scripts')) {
    /**
     * Enqueue plugin scripts for admin pages
     *
     * @param mixed $hook_suffix The current page
     * @return void
     */
    function nortic_plugin_admin_enqueue_scripts($hook_suffix)
    {
        // Current page
        echo $hook_suffix;

        if (
            $hook_suffix === "toplevel_page_nortic-plugin-options" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-opengraph-options" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-chatbot-options" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-social-networks-options" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-options-page" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-opengraph-options-page" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-chatbot-options-page" ||
            $hook_suffix === "nortic-plugin_page_nortic-plugin-social-networks-options-page"
        ) {
            // Enqueue media library
            wp_enqueue_media();

            wp_enqueue_style('nortic_plugin_admin_style');
            wp_enqueue_script('nortic_plugin_admin_script');
        }

        // localize admin scripts 

        if (
            $hook_suffix === "site-editor.php" ||
            $hook_suffix === "post.php" ||
            $hook_suffix === "post-new.php"
        ) {
            wp_enqueue_script('nortic_plugin_admin_script');

            wp_localize_script(
                'nortic_plugin_admin_script',
                'pluginPublicScripts',
                [
                    'pluginDirectoryUri' => NORTIC_PLUGIN_URL
                ]
            );

            // wp_localize_script(
            //     'nortic-plugin-attached-resource-editor-script-js',
            //     'pluginPublicScripts',
            //     [
            //         'pluginDirectoryUri' => NORTIC_PLUGIN_URL
            //     ]
            // );

            // localize editor script for attached resource
            wp_localize_script(
                'nortic-plugin-attached-resource-editor-script',
                'pluginPublicScripts',
                [
                    'pluginDirectoryUri' => NORTIC_PLUGIN_URL
                ]
            );
            
            // localize editor script for dependency responsible member
            wp_localize_script(
                'nortic-plugin-dependency-responsible-member-editor-script',
                'pluginPublicScripts',
                [
                    'pluginDirectoryUri' => NORTIC_PLUGIN_URL
                ]
            );          
            
        }
    }
}
