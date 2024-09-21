<?php

if (!function_exists('nortic_plugin_page_header_render_cb')) {
    function nortic_plugin_page_header_render_cb($atts)
    {
        $heading = esc_html($atts['content']);
        $color = esc_attr($atts['color']);
        $bgColor = esc_attr($atts['bgColor']);
        $style = "background-color:{$bgColor}; color: {$color};";

        if ($atts['showCategory']) {
            if (is_search() && isset($_GET['s'])) {
                $heading = __('Results for', 'nortic-plugin') . ': ' . get_search_query();
            }
            if (is_page() || is_singular()) {
                $heading = get_the_title();
            }
            if (is_archive()) {
                $heading = get_the_archive_title();

                // remove unwanted characters
                $heading = preg_replace('/^(Category|Directory|Tag|Author|Group|Archives|Archive|Archivos):\s*/', '', $heading);
            }
        }

        ob_start();
?>

        <div class="wp-block-nortic-plugin-page-header" style="<?php echo $style; ?>">
            <div class="inner-page-header">
                <h2 class="mr-auto"><?php echo strip_tags($heading); ?></h2>
            </div>
        </div>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
