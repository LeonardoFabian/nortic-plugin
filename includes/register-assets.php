<?php

if (!function_exists('nortic_plugin_register_assets')) {
    /**
     * Enqueueing plugin block editor assets
     *
     * @return void
     */
    function nortic_plugin_register_assets()
    {
        wp_register_style(
            'nortic_plugin_admin_style',
            plugins_url('/build/admin/index.css', NORTIC_PLUGIN_FILE)
        );

        $adminAssets = include(NORTIC_PLUGIN_DIR . 'build/admin/index.asset.php');

        wp_register_script(
            'nortic_plugin_admin_script',
            plugins_url('/build/admin/index.js', NORTIC_PLUGIN_FILE),
            $adminAssets['dependencies'],
            $adminAssets['version'],
            true
        );

        $editorAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/index.asset.php');

        wp_register_script(
            'nortic_plugin_editor',
            plugins_url('/build/block-editor/index.js', NORTIC_PLUGIN_FILE),
            $editorAssets['dependencies'],
            $editorAssets['version'],
            true
        );

        $achievementAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/achievement/index.asset.php');

        wp_register_script(
            'nortic_plugin_achievement_editor',
            plugins_url('/build/block-editor/achievement/index.js', NORTIC_PLUGIN_FILE),
            $achievementAssets['dependencies'],
            $achievementAssets['version'],
            true
        );

        $awardAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/award/index.asset.php');

        wp_register_script(
            'nortic_plugin_award_editor',
            plugins_url('/build/block-editor/award/index.js', NORTIC_PLUGIN_FILE),
            $awardAssets['dependencies'],
            $awardAssets['version'],
            true
        );

        $dependencyAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/dependency/index.asset.php');

        wp_register_script(
            'nortic_plugin_dependency_editor',
            plugins_url('/build/block-editor/dependency/index.js', NORTIC_PLUGIN_FILE),
            $dependencyAssets['dependencies'],
            $dependencyAssets['version'],
            true
        );

        $documentAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/document/index.asset.php');

        wp_register_script(
            'nortic_plugin_document_editor',
            plugins_url('/build/block-editor/document/index.js', NORTIC_PLUGIN_FILE),
            $documentAssets['dependencies'],
            $documentAssets['version'],
            true
        );

        $resourceAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/resource/index.asset.php');

        wp_register_script(
            'nortic_plugin_resource_editor',
            plugins_url('/build/block-editor/resource/index.js', NORTIC_PLUGIN_FILE),
            $resourceAssets['dependencies'],
            $resourceAssets['version'],
            true
        );

        $eventAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/event/index.asset.php');

        wp_register_script(
            'nortic_plugin_event_editor',
            plugins_url('/build/block-editor/event/index.js', NORTIC_PLUGIN_FILE),
            $eventAssets['dependencies'],
            $eventAssets['version'],
            true
        );

        $faqAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/faq/index.asset.php');

        wp_register_script(
            'nortic_plugin_faq_editor',
            plugins_url('/build/block-editor/faq/index.js', NORTIC_PLUGIN_FILE),
            $faqAssets['dependencies'],
            $faqAssets['version'],
            true
        );

        $galleryAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/gallery/index.asset.php');

        wp_register_script(
            'nortic_plugin_gallery_editor',
            plugins_url('/build/block-editor/gallery/index.js', NORTIC_PLUGIN_FILE),
            $galleryAssets['dependencies'],
            $galleryAssets['version'],
            true
        );

        $newsletterAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/newsletter/index.asset.php');

        wp_register_script(
            'nortic_plugin_newsletter_editor',
            plugins_url('/build/block-editor/newsletter/index.js', NORTIC_PLUGIN_FILE),
            $newsletterAssets['dependencies'],
            $newsletterAssets['version'],
            true
        );

        $resolutionAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/resolution/index.asset.php');

        wp_register_script(
            'nortic_plugin_resolution_editor',
            plugins_url('/build/block-editor/resolution/index.js', NORTIC_PLUGIN_FILE),
            $resolutionAssets['dependencies'],
            $resolutionAssets['version'],
            true
        );

        $serviceAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/service/index.asset.php');

        wp_register_script(
            'nortic_plugin_service_editor',
            plugins_url('/build/block-editor/service/index.js', NORTIC_PLUGIN_FILE),
            $serviceAssets['dependencies'],
            $serviceAssets['version'],
            true
        );

        $systemAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/system/index.asset.php');

        wp_register_script(
            'nortic_plugin_system_editor',
            plugins_url('/build/block-editor/system/index.js', NORTIC_PLUGIN_FILE),
            $serviceAssets['dependencies'],
            $serviceAssets['version'],
            true
        );

        $teamAssets = include(NORTIC_PLUGIN_DIR . 'build/block-editor/team/index.asset.php');

        wp_register_script(
            'nortic_plugin_team_editor',
            plugins_url('/build/block-editor/team/index.js', NORTIC_PLUGIN_FILE),
            $teamAssets['dependencies'],
            $teamAssets['version'],
            true
        );
    }
}
