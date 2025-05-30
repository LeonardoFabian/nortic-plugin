<?php

if (!function_exists('nortic_plugin_enqueue_scripts')) {
    function nortic_plugin_enqueue_scripts()
    {
        // https://michalsnik.github.io/aos/
        // wp_register_style(
        //     'nortic_plugin_aos_css',
        //     'https://unpkg.com/aos@2.3.1/dist/aos.css',
        //     [],
        //     '2.3.1',
        //     'all'
        // );

        wp_register_style(
            'nortic_plugin_aos_css',
            NORTIC_PLUGIN_URL . 'dist/public/css/aos.css',
            [],
            '2.3.1',
            'all'
        );
        
        // https://swiperjs.com/get-started#use-swiper-from-cdn
        wp_register_style(
            'nortic_plugin_swiper_css',
            NORTIC_PLUGIN_URL . 'dist/public/css/swiper-bundle.min.css', // 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
            [],
            '11.2.8',
            'all'
        );

        // Font-awesome
        wp_register_style(
            'notic_plugin_fontawesome',
            NORTIC_PLUGIN_URL . 'dist/public/css/fontawesome.min.css', // 'https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.css', // NORTIC_PLUGIN_URL . 'lib/fontawesome/css/fontawesome.min.css', //'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css',
            [],
            null,
            'all'
        );

        /**
         * glide.core - Core styles, required for Glide.js to work
         */
        wp_register_style(
            'nortic_plugin_glidejs_core',
            NORTIC_PLUGIN_URL . 'dist/public/css/glide.core.min.css',
            [],
            null,
            'all'
        );

        /**
         * glide.theme - Visual styles. Optional styling for markup.
         */
        wp_register_style(
            'nortic_plugin_glidejs_theme',
            NORTIC_PLUGIN_URL . 'dist/public/css/glide.theme.min.css',
            [],
            null,
            'all'
        );

        // Tailwind 
        wp_register_style(
            'nortic_plugin_tailwind',
            NORTIC_PLUGIN_URL . 'dist/public/css/tailwind.css',
            [],
            null,
            'all'
        );


        // https://unpkg.com/aos@2.3.1/dist/aos.js
        wp_register_script(
            'aos-js',
            NORTIC_PLUGIN_URL . 'dist/public/js/aos-2-3-1.js', // 'https://unpkg.com/aos@2.3.1/dist/aos.js',
            [],
            '2.3.1',
            true
        );
        
        // https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js
        wp_register_script(
            'nortic_plugin_swiper_js',
            NORTIC_PLUGIN_URL . 'dist/public/js/swiper-bundle-11-2-8.min.js', // 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
            [],
            '11.2.8',
            true
        );

        wp_register_script(
            'nortic_plugin_aos_custom_js',
            NORTIC_PLUGIN_URL . 'dist/public/js/aos.js',
            ['aos-js'],
            null,
            true
        );

        wp_register_script(
            'nortic_plugin_glidejs',
            NORTIC_PLUGIN_URL . 'dist/public/js/glide.min.js',
            [],
            null,
            true
        );

        // font-awesome js
        /*
        wp_register_script(
            'norti-plugin-fontawesome',
            NORTIC_PLUGIN_URL . 'lib/fontawesome/js/fontawesome.min.js',
            ['jquery'],
            null,
            true
        );
        */

        wp_register_script(
            'nortic_plugin_public',
            NORTIC_PLUGIN_URL . 'dist/public/js/script.js',
            ['wp-blocks'],
            NORTIC_PLUGIN_VERSION,
            true
        );



        // enqueue public styles

        wp_enqueue_style('nortic_plugin_aos_css');
        wp_enqueue_style('notic_plugin_fontawesome');
        wp_enqueue_style('nortic_plugin_glidejs_core');
        wp_enqueue_style('nortic_plugin_glidejs_theme');
        wp_enqueue_style('nortic_plugin_swiper_css');
        wp_enqueue_style('nortic_plugin_tailwind');

        // enqueue public scripts

        if (!is_admin()) {
            wp_enqueue_script('jquery');
        }

        wp_enqueue_script('aos-js');
        wp_enqueue_script('nortic_plugin_aos_custom_js');
        wp_enqueue_script('nortic_plugin_glidejs');
        wp_enqueue_script('nortic_plugin_swiper_js');
        // wp_enqueue_script('norti-plugin-fontawesome');
        wp_enqueue_script('nortic_plugin_public');

        wp_localize_script(
            'nortic_plugin_public',
            'pluginData',  
            [
                'pluginUrl' => NORTIC_PLUGIN_URL,
                'nonce' => nortic_get_nonce(),
            ]
        );
    }
}
