<?php

if (!function_exists('nortic_plugin_requirements_field_render_cb')) {
    /**
     * Requirements block type render callback.
     *
     * @return void
     */
    function nortic_plugin_requirements_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Requirements', 'nortic-plugin');
        }

        $requirements = get_post_meta($postID, 'requirements', true);

        ob_start();
?>
        <?php if (!empty($requirements)) : ?>
            <div class="wp-block-nortic-plugin-requirements mt-8 mb-12">
                <h3><?php echo $title; ?></h3>
                <?php nortic_plugin_sanitize_textarea_field($requirements); ?>
            </div>
        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
