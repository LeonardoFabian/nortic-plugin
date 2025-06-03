<?php

/**
 * NOTE:
 * 
 * After adding and register a block type, go to includes->load-translations to set scripts translations for blocks
 */

if (!function_exists('nortic_plugin_register_blocks')) {
    /**
     * Register theme blocks
     *
     * @return void
     */
    function nortic_plugin_register_blocks()
    {
        if (!function_exists('register_block_type')) {
            return;
        }

        $blocks = [
            ["name" => "page-header", "options" => [
                "render_callback" => "nortic_plugin_page_header_render_cb"
            ]],
            ["name" => "search-bar", "options" => [
                "render_callback" => "nortic_plugin_search_bar_render_cb"
            ]],
            ["name" => "service-summary", 'options' => [
                'render_callback' => 'nortic_plugin_service_summary_render_cb'
            ]],
            ["name" => "title"],
            ["name" => "rating", 'options' => [
                'render_callback' => 'nortic_plugin_rating_render_cb'
            ]],
            ["name" => "hero"],
            ["name" => "hero-blank"],
            ["name" => "slideshow"],
            ["name" => "slide"],
            ["name" => "carousel", 'options' => [
                'render_callback' => 'nortic_plugin_carousel_render_cb'
            ]],
            ["name" => "banner"],
            ["name" => "grid-list"],
            ["name" => "team-member"],
            ["name" => "office-location"],
            ["name" => "file-manager"],
            ["name" => "featured-services", 'options' => [
                'render_callback' => 'nortic_plugin_featured_services_render_cb'
            ]],
            ["name" => "file-list", 'options' => [
                'render_callback' => 'nortic_plugin_file_list_render_cb'
            ]],
            ["name" => "latest-posts", 'options' => [
                'render_callback' => 'nortic_plugin_latest_posts_render_cb'
            ]],
            ["name" => "office-locations", 'options' => [
                'render_callback' => 'nortic_plugin_office_locations_render_cb'
            ]],
            ["name" => "faqs", 'options' => [
                'render_callback' => 'nortic_plugin_faqs_render_cb'
            ]],
            ['name' => 'chatbot', 'options' => [
                'render_callback' => 'nortic_plugin_chatbot_render_cb'
            ]],
            ["name" => "link"],
            ["name" => "image-gallery"],
            ["name" => "gallery-archive", "options" => [
                "render_callback" => "nortic_plugin_gallery_archive_render_cb"
            ]],
            ["name" => "follow-buttons"],
            ["name" => "np-query"],
            ["name" => "np-post-template", "options" => [
                "render_callback" => "nortic_plugin_post_template_render_cb"
            ]],
            ["name" => "description", "options" => [
                "render_callback" => "nortic_plugin_description_field_render_cb"
            ]],
            ["name" => "information", "options" => [
                "render_callback" => "nortic_plugin_information_field_render_cb"
            ]],
            ["name" => "target-audience", "options" => [
                "render_callback" => "nortic_plugin_target_audience_field_render_cb"
            ]],
            ["name" => "dependency-service-list"],
            ["name" => "additional-information", "options" => [
                "render_callback" => "nortic_plugin_additional_information_field_render_cb"
            ]],
            ["name" => "requirements", "options" => [
                "render_callback" => "nortic_plugin_requirements_field_render_cb"
            ]],
            ["name" => "service-responsible-info", "options" => [
                "render_callback" => "nortic_plugin_service_responsible_info_field_render_cb"
            ]],
            ["name" => "contact-info", "options" => [
                "render_callback" => "nortic_plugin_contact_info_field_render_cb"
            ]],
            ["name" => "dependency-responsible-member", "options" => [
                "render_callback" => "nortic_plugin_dependency_responsible_member_field_render_cb"
            ]],
            ["name" => "team-member-basic-info", "options" => [
                "render_callback" => "nortic_plugin_team_member_basic_info_field_render_cb"
            ]],
            ["name" => "contact-form", "options" => [
                "render_callback" => "nortic_plugin_contact_form_render_cb"
            ]],
            ["name" => "local-business", "options" => [
                "render_callback" => "nortic_plugin_local_business_render_cb"
            ]],
            ["name" => "breadcrumb", "options" => [
                "render_callback" => "nortic_plugin_breadcrumb_render_cb"
            ]],
            ["name" => "faqs-list", "options" => [
                "render_callback" => "nortic_plugin_faqs_list_render_cb"
            ]],
            ["name" => "awards", "options" => [
                "render_callback" => "nortic_plugin_awards_render_cb"
            ]],
            ["name" => "alias", "options" => [
                "render_callback" => "nortic_plugin_alias_render_cb"
            ]],
            ["name" => "page-options", "options" => [
                "render_callback" => "nortic_plugin_page_options_render_cb"
            ]],
            ["name" => "sharing-buttons", "options" => [
                "render_callback" => "nortic_plugin_sharing_buttons_render_cb"
            ]],
            ["name" => "dropdown-menu"],
            ["name" => "toggle-menu"],
            ["name" => "list"],
            ["name" => "link-cloud"],
            ["name" => "modal"],
            ["name" => "sheet"],
            ["name" => "cards"],
            ["name" => "card"],
            ["name" => "bootstrap-icon"],
            ["name" => "services-accordion-list", "options" => [
                "render_callback" => "nortic_plugin_service_accordion_list_render_cb"
            ]],
            ["name" => "services-section"],
            ["name" => "service-card"],
            ["name" => "attached-resource"],
            ["name" => "resources-section", "options" => [
                "render_callback" => "nortic_plugin_resources_section_render_cb"
            ]],
            ["name" => "newsletters-section", "options" => [
                "render_callback" => "nortic_plugin_newsletters_section_render_cb"
            ]],
            ["name" => "dependency-list", "options" => [
                "render_callback" => "nortic_plugin_dependency_list_render_cb"
            ]],
            ["name" => "system-list", "options" => [
                "render_callback" => "nortic_plugin_system_list_render_cb"
            ]],
            ["name" => "featured-posts", "options" => [
                "render_callback" => "nortic_plugin_featured_posts_render_cb"
            ]],
            ["name" => "posts-by-category", "options" => [
                "render_callback" => "nortic_plugin_posts_by_category_render_cb"
            ]],
            ["name" => "service-delivery-channels", "options" => [
                "render_callback" => "nortic_plugin_service_delivery_channels_render_cb"
            ]],
            ["name" => "tick-items"],
            ["name" => "tick-item", "options" => [
                "render_callback" => "nortic_plugin_tick_item_render_cb"
            ]],
            ["name" => "service-list", "options" => [
                "render_callback" => "nortic_plugin_service_list_render_cb"
            ]],
            ["name" => "team-list", "options" => [
                "render_callback" => "nortic_plugin_team_list_render_cb"
            ]],
            ["name" => "documents-directory", "options" => [
                "render_callback" => "nortic_plugin_documents_directory_render_cb"
            ]],
            ["name" => "dependency-interactive-map", "options" => [
                "render_callback" => "nortic_plugin_dependency_interactive_map_render_cb"
            ]],
            ["name" => "province-rd-trabaja-jobs", "options" => [
                "render_callback" => "nortic_plugin_province_rd_trabaja_jobs_render_cb"
            ]],
            ["name" => "province-cloud", "options" => [
                "render_callback" => "nortic_plugin_province_cloud_render_cb"
            ]],
            ["name" => "newsletter-list", "options" => [
                "render_callback" => "nortic_plugin_newsletter_list_render_cb"
            ]],
            ["name" => "mt-departamentos"],
            ["name" => "document-manager", "options" => [
                "render_callback" => "nortic_plugin_document_manager_render_cb"
            ]],
            ["name" => "directories-tab", "options" => [
                "render_callback" => "nortic_plugin_directories_tab_render_cb"
            ]],
            ["name" => "gob-do"],
            ["name" => "powerbi-embed"],
            ["name" => "document-explorer", "options" => [
                "render_callback" => "nortic_plugin_document_explorer_render_cb"
            ]],
            ["name" => "organizational-chart", "options" => [
                "render_callback" => "nortic_plugin_organizational_chart_render_cb"
            ]]
        ];


        foreach ($blocks as $block) {
            register_block_type(
                NORTIC_PLUGIN_DIR . 'build/blocks/' . $block['name'],
                isset($block['options']) ? $block['options'] : []
            );
        }
    }
}
