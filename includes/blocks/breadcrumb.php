<?php

if (!function_exists('nortic_plugin_breadcrumb_render_cb')) {
    function nortic_plugin_breadcrumb_render_cb($atts)
    {
        ob_start();
?>
        <?php if (!is_front_page() && !is_home() && !is_404() && !is_search()) : ?>
            <div class="wp-block-nortic-plugin-breadcrumb shadow-sm">
                <div class="py-4">
                    <div class="w-full px-4 flex flex-wrap items-center justify-between">
                        <?php if ($atts['showSectionName']) : ?>
                            <h6 class="text-md color-blue font-semibold"><?php echo get_the_title(); ?></h6>
                        <?php endif; ?>
                        <div class="breadcrumb-nav flex items-center gap-2 flex-wrap">
                            <?php the_breadcrumb(); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
