<?php

if (!function_exists('nortic_plugin_setup_theme')) {
    /**
     * Fires after the Nortic theme is loaded
     *
     * @return void
     */
    function nortic_plugin_setup_theme()
    {
        add_image_size('logo', 200, 100, FALSE);
        add_image_size('logoFooter', 300, 118, FALSE);
        add_image_size('opengraph', 1200, 630, TRUE);
        add_image_size('cinema', 1900, 814, TRUE);
        add_image_size('fullScreenHero', 1200, 675, TRUE);
        add_image_size('bannerHero', 2880, 480, TRUE);
        add_image_size('postHeader', 1600, 350, TRUE);
        add_image_size('mobileHero', 800, 1200, TRUE);
        add_image_size('landscape', 1200, 900, TRUE);
        add_image_size('portrait', 900, 1200, TRUE);
        add_image_size('background', 1920, 1080, TRUE);
        add_image_size('horizontalMap', 135, 240, TRUE);
        add_image_size('verticalMap', 240, 135, TRUE);
        add_image_size('teamMember', 144, 144, TRUE);
        add_image_size('avatar', 56, 56, TRUE);
        add_image_size('leaderboardBanner', 728, 90, FALSE);
        add_image_size('largeLeaderboard', 970, 90, FALSE);
        add_image_size('mobileLeaderboard', 320, 50, FALSE);
        add_image_size('square', 250, 250, FALSE);
        add_image_size('smallSquare', 200, 200, FALSE);
        add_image_size('mediumRectangle', 300, 250, FALSE);
        add_image_size('largeRectangle', 336, 280, FALSE);
        add_image_size('hero', 1366, 768, FALSE);
    }
}
