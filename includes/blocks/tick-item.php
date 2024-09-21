<?php 

if(!function_exists('nortic_plugin_tick_item_render_cb')) {
    function nortic_plugin_tick_item_render_cb($atts) {
        $title = $atts['title'];
        $use_page_title = $atts['use_page_title'];
        $page_id = $atts['pageId'];
        $wp_kses_array = array(
            'a' => array(
                'href' => array(),
                'title' => array(),
                'target' => array()
            ),
            'br' => array(),
            'em' => array(),
            'strong' => array(),
        );

        if($use_page_title && $page_id > 0) {
            $page = get_post($page_id);
            if($page) {
                $title = $page->post_title;
            }
        }

        if($page_id > 0) {
            $page = get_post($page_id);
            if($page) {
                $page_link = get_permalink($page_id);
            }
        }

        ob_start();

        ?>
            <li class="wp-block-nortic-plugin-tick-item">
                <!-- <i class="bi bi-check-lg"></i> -->
                <!-- <i class="bi bi-check2-square"></i> -->
                <i class="bi bi-check2-circle"></i>
                <span>
                    <p><?php echo wp_kses($title, $wp_kses_array); ?></p>
                    <?php if(!empty($page_link)) : ?>
                        <a href="<?php echo esc_url($page_link); ?>">
                            <?php _e('Read More...', 'nortic-plugin'); ?>
                        </a>
                    <?php endif; ?>
                </span>
            </li>
        <?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}