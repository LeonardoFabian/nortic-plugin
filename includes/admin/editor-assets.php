<?php

if (!function_exists('nortic_plugin_enqueue_block_editor_assets')) {
    /**
     * Fires after block assets have been enqueued for editing interfaces in post type editing
     *
     * @return void
     */
    function nortic_plugin_enqueue_block_editor_assets()
    {

        $current_screen = get_current_screen();
        // print_r($current_screen);

        // Prevent runing script in Full site editing, and using only in edit post page
        if ($current_screen->base == "appearance_page_gutenberg-edit-site") {
            return;
        }

        // wp_enqueue_script('nortic_plugin_editor');

        if ($current_screen->post_type == "achievement") {
            wp_enqueue_script('nortic_plugin_achievement_editor');
        }

        if ($current_screen->post_type == "award") {
            wp_enqueue_script('nortic_plugin_award_editor');
        }

        if ($current_screen->post_type == "dependency") {
            wp_enqueue_script('nortic_plugin_dependency_editor');
        }

        if ($current_screen->post_type == "document") {
            wp_enqueue_script('nortic_plugin_document_editor');
        }

        if ($current_screen->post_type == "resource") {
            wp_enqueue_script('nortic_plugin_resource_editor');
        }

        if ($current_screen->post_type == "event") {
            wp_enqueue_script('nortic_plugin_event_editor');
        }

        if ($current_screen->post_type == "faq") {
            wp_enqueue_script('nortic_plugin_faq_editor');
        }

        if ($current_screen->post_type == "gallery") {
            wp_enqueue_script('nortic_plugin_gallery_editor');
        }

        if ($current_screen->post_type == "newsletter") {
            wp_enqueue_script('nortic_plugin_newsletter_editor');
        }

        if ($current_screen->post_type == "resolution") {
            wp_enqueue_script('nortic_plugin_resolution_editor');
        }

        if ($current_screen->post_type == "service") {
            wp_enqueue_script('nortic_plugin_service_editor');
        }

        if ($current_screen->post_type == "system") {
            wp_enqueue_script('nortic_plugin_system_editor');
        }

        if ($current_screen->post_type == "team") {
            wp_enqueue_script('nortic_plugin_team_editor');
        }
    }
}
