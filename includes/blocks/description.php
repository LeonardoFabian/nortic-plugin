<?php

if (!function_exists('nortic_plugin_description_field_render_cb')) {
    /**
     * Description block type render callback.
     *
     * @return void
     */
    function nortic_plugin_description_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Description', 'nortic-plugin');
        }

        $description = get_post_meta($postID, 'description', true);

        ob_start();
?>
        <?php if (!empty($description)) : ?>
            <div class="wp-block-nortic-plugin-description mb-12">
                <h5><?php echo esc_html($title); ?></h5>
                <p><?php echo esc_html($description); ?></p>
            </div>
        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
