<?php

if (!function_exists('nortic_plugin_target_audience_field_render_cb')) {
    /**
     * Description block type render callback.
     *
     * @param array $atts
     * @param [type] $content
     * @param [type] $block
     * @return void
     */
    function nortic_plugin_target_audience_field_render_cb($atts, $content, $block)
    {
        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Target audience', 'nortic-plugin');
        }

        $targetAudience = get_post_meta($postID, 'target_audience', true);

        ob_start();
?>
        <?php if (!empty($targetAudience)) : ?>
            <div class="wp-block-nortic-plugin-target-audience mb-12">
                <h5 class="mb-4"><?php echo $title; ?></h5>
                <?php nortic_plugin_sanitize_textarea_field($targetAudience); ?>
            </div>
        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
