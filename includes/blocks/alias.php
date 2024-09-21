<?php

if (!function_exists('nortic_plugin_alias_render_cb')) {
    function nortic_plugin_alias_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Common name', 'nortic-plugin');
        }

        $alias = get_post_meta($postID, 'alias', true);

        ob_start();
?>
        <?php if (!empty($alias)) : ?>
            <div class="wp-block-nortic-plugin-alias mb-12">
                <h5><?php echo $title; ?></h5>
                <p><?php echo esc_html($alias); ?></p>
            </div>
        <?php endif; ?>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
