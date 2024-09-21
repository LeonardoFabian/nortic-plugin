<?php

if (!function_exists('nortic_plugin_wp_head')) {
    /**
     * Prints plugin scripts or data in the head tag on the front end
     *
     * @return void
     */
    function nortic_plugin_wp_head()
    {
        $url = site_url('/');

        $opengraph_options = get_option('nortic_plugin_opengraph_options');

        if ($opengraph_options['np_enable_og'] != 1) {
            return;
        }

        $og_title = $opengraph_options['np_og_title'];
        $og_description = $opengraph_options['np_og_description'];
        $og_image = $opengraph_options['np_og_image'];

        if (is_single()) {
            $postID = get_the_ID();

            $new_og_title = get_post_meta($postID, 'og_title', true);
            $new_og_description = get_post_meta($postID, 'og_description', true);
            $new_og_image = get_post_meta($postID, 'og_image', true);
            $og_override_image = get_post_meta($postID, 'og_override_image', true);

            $og_title = empty($new_og_title) ? $og_title : $new_og_title;
            $og_description = empty($new_og_description) ? $og_description : $new_og_description;
            $og_image = $og_override_image
                ? $new_og_image
                : get_the_post_thumbnail_url($postID, 'opengraph');

            $url = get_permalink($postID);
        }

?>
        <meta property="og:title" content="<?php echo esc_attr($og_title); ?>" />
        <meta property="og:description" content="<?php echo esc_attr($og_description); ?>" />
        <meta property="og:image" content="<?php echo esc_attr($og_image); ?>" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="<?php echo esc_attr($url); ?>" />
<?php
    }
}
