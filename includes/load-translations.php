<?php

/**
 * NOTE:
 * 
 * Locate the blocks script IDs enqueue before the body close tag.
 * 
 * After adding new translations, uses WP-CLI and run the following command to regenerate the plugin POT file in /languages/{plugin-name}.pot...
 * 
 */

// COMMAND TO GENERATE PLUGIN POT FILE:

// wp i18n make-pot . languages/nortic-plugin.pot --exclude=node_modules,vendor,src/*.js,src/**/*.js,dist,build

if (!function_exists('nortic_plugin_load_php_translations')) {
    /**
     * Load plugin translations from the server
     *
     * @return void
     */
    function nortic_plugin_load_php_translations()
    {
        load_plugin_textdomain(
            'nortic-plugin',
            false,
            "nortic-plugin/languages"
        );
    }
}

if (!function_exists('nortic_plugin_block_translations')) {
    /**
     * Load plugin blocks translations
     *
     * @return void
     */
    function nortic_plugin_block_translations()
    {
        // Blocks scripts IDs loaded in footer

        $blocks = [
            "nortic-plugin-page-header-editor-script",
            "nortic-plugin-search-bar-editor-script",
            "nortic-plugin-service-summary-editor-script",
            "nortic-plugin-title-editor-script",
            "nortic-plugin-rating-editor-script",
            "nortic-plugin-hero-editor-script",
            "nortic-plugin-hero-blank-editor-script",
            "nortic-plugin-slideshow-editor-script",
            "nortic-plugin-slide-editor-script",
            "nortic-plugin-carousel-editor-script",
            "nortic-plugin-banner-editor-script",
            "nortic-plugin-grid-list-editor-script",
            "nortic-plugin-team-member-editor-script",
            "nortic-plugin-office-location-editor-script",
            "nortic-plugin-file-manager-editor-script",
            "nortic-plugin-featured-services-editor-script",
            "nortic-plugin-file-list-editor-script",
            "nortic-plugin-latest-posts-editor-script",
            "nortic-plugin-office-locations-editor-script",
            "nortic-plugin-faqs-editor-script",
            "nortic-plugin-faqs-list-editor-script",
            'nortic-plugin-chatbot',
            "nortic-plugin-link-editor-script",
            "nortic-plugin-image-gallery-editor-script",
            "nortic-plugin-gallery-archive-editor-script",
            "nortic-plugin-follow-buttons-editor-script",
            "nortic-plugin-np-query-editor-script",
            "nortic-plugin-description-editor-script",
            "nortic-plugin-information-editor-script",
            "nortic-plugin-target-audience-editor-script",
            "nortic-plugin-dependency-service-list-editor-script",
            "nortic-plugin-additional-information-editor-script",
            "nortic-plugin-requirements-editor-script",
            "nortic-plugin-service-responsible-info-editor-script",
            "nortic-plugin-contact-info-editor-script",
            "nortic-plugin-dependency-responsible-member-editor-script",
            "nortic-plugin-team-member-basic-info-editor-script",
            "nortic-plugin-np-post-template-editor-script",
            "nortic-plugin-contact-form-editor-script",
            "nortic-plugin-local-business-editor-script",
            "nortic-plugin-breadcrumb-editor-script",
            "nortic-plugin-alias-editor-script",
            "nortic-plugin-page-options-editor-script",
            "nortic-plugin-sharing-buttons-editor-script",
            "nortic-plugin-dropdown-menu-editor-script",
            "nortic-plugin-toggle-menu-editor-script",
            "nortic-plugin-list-editor-script",
            "nortic-plugin-link-cloud-editor-script",
            "nortic-plugin-modal-editor-script",
            "nortic-plugin-sheet-editor-script",
            "nortic-plugin-cards-editor-script",
            "nortic-plugin-card-editor-script",
            "nortic-plugin-bootstrap-icon-editor-script",
            "nortic-plugin-services-accordion-list-editor-script",
            "nortic-plugin-services-section-editor-script",
            "nortic-plugin-service-card-editor-script",
            "nortic-plugin-resource-editor-script",
            "nortic-plugin-resources-section-editor-script",
            "nortic-plugin-newsletters-section-editor-script",
            "nortic-plugin-dependency-list-editor-script",
            "nortic-plugin-system-list-editor-script",
            "nortic-plugin-featured-posts-editor-script",
            "nortic-plugin-posts-by-category-editor-script",
            "nortic-plugin-service-delivery-channels-editor-script",
            "nortic-plugin-tick-items-editor-script",
            "nortic-plugin-tick-item-editor-script",
            "nortic-plugin-service-list-editor-script",
            "nortic-plugin-team-list-editor-script",
            "nortic-plugin-documents-directory-editor-script",
            "nortic-plugin-dependency-interactive-map-editor-script",
            "nortic-plugin-province-rd-trabaja-jobs-editor-script",
            "nortic-plugin-province-cloud-editor-script",
            "nortic-plugin-newsletter-list-editor-script",
            "nortic-plugin-mt-departamentos-editor-script",
            "nortic-plugin-document-manager-editor-script",
            "nortic-plugin-directories-tab-editor-script",
            "nortic-plugin-gob-do-editor-script",
            "nortic-plugin-powerbi-embed-editor-script",
            "nortic-plugin-document-explorer-editor-script",
            "nortic-plugin-organizational-chart-editor-script",
        ];

        // Loaded translations for all blocks

        foreach ($blocks as $block) {

            // add translations for specific script
            wp_set_script_translations(
                $block,
                'nortic-plugin',
                NORTIC_PLUGIN_DIR . "languages"
            );
        }
    }
}
