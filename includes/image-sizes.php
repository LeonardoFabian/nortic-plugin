<?php

if (!function_exists('nortic_plugin_image_size_names_choose')) {
    /**
     * Filter the names and labels of the theme image sizes
     *
     * @return void
     */
    function nortic_plugin_image_size_names_choose($sizes)
    {
        return array_merge($sizes, [
            'logo'                  => __('Logo', 'nortic-plugin'),
            'logoFooter'            => __('Logo Footer', 'nortic-plugin'),
            'opengraph'             => __('Open Graph', 'nortic-plugin'),
            'cinema'                => __('Cinema', 'nortic-plugin'),
            'fullScreenHero'        => __('Full Screen Hero', 'nortic-plugin'),
            'bannerHero'            => __('Banner Hero', 'nortic-plugin'),
            'postHeader'            => __('Post Header', 'nortic-plugin'),
            'mobileHero'            => __('Mobile Hero', 'nortic-plugin'),
            'landscape'             => __('Landscape', 'nortic-plugin'),
            'portrait'              => __('Portrait', 'nortic-plugin'),
            'background'            => __('Background', 'nortic-plugin'),
            'horizontalMap'         => __('Horizontal Map Location', 'nortic-plugin'),
            'verticalMap'           => __('Vertical Map Location', 'nortic-plugin'),
            'teamMember'            => __('Team Member', 'nortic-plugin'),
            'avatar'                => __('Avatar', 'nortic-plugin'),
            'leaderboardBanner'     => __('Leaderboard Banner', 'nortic-plugin'),
            'largeLeaderboard'      => __('Large Leaderboard', 'nortic-plugin'),
            'mobileLeaderboard'     => __('Mobile Leaderboard', 'nortic-plugin'),
            'square'                => __('Square', 'nortic-plugin'),
            'smallSquare'           => __('Small Square', 'nortic-plugin'),
            'mediumRectangle'       => __('Medium Rectangle', 'nortic-plugin'),
            'largeRectangle'        => __('Large Rectangle', 'nortic-plugin'),
            'hero'                  => __('Hero', 'nortic-plugin'),
        ]);
    }
}
