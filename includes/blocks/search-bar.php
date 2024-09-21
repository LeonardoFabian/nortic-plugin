<?php

if (!function_exists('nortic_plugin_search_bar_render_cb')) {
    function nortic_plugin_search_bar_render_cb($atts)
    {
        $bgColor = esc_attr($atts['bgColor']);
        $color = esc_attr($atts['color']);

        ob_start();
?>
        <div <?php echo get_block_wrapper_attributes(); ?>>
            <form action="<?php echo esc_url(home_url('/')); ?>">
                <input class="search-bar-input bg-white px-4 text-sm" type="search" name="s" placeholder="<?php echo esc_html__('What do you want to look for?', 'nortic-plugin'); ?>" style="color: <?php echo $color; ?>; background-color: <?php echo $bgColor; ?>;" value="<?php the_search_query(); ?>" />
                <button type="submit" class="w-10 h-10 rounded-full overflow-hidden">
                    <i class="bi bi-search color-white text-white"></i>
                </button>
                <button type="button" class="toggle-mobile-search-button w-10 h-10 rounded-full overflow-hidden">
                    <i class="bi bi-search color-white text-white"></i>
                </button>
            </form>
        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
