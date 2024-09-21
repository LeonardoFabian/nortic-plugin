<?php

if (!function_exists('nortic_plugin_information_field_render_cb')) {
    /**
     * Description block type render callback.
     *
     * @return void
     */
    function nortic_plugin_information_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Information', 'nortic-plugin');
        }

        $information = get_post_meta($postID, 'information', true);

        ob_start();
?>
        <?php if (!empty($information)) : ?>
            <div class="wp-block-nortic-plugin-information mb-12">
                <h5><?php echo $title; ?></h5>
                <?php nortic_plugin_sanitize_textarea_field($information); ?>
            </div>
        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
