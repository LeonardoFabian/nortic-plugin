<?php

if (!function_exists('nortic_plugin_service_summary_render_cb')) {
    /**
     * Output the service summary block in the frontend
     *
     * @return void
     */
    function nortic_plugin_service_summary_render_cb($atts, $content, $block)
    {
        $hours = isset($atts['hours']) ? esc_html($atts['hours']) : '';
        $cost = isset($atts['cost']) ? esc_html($atts['cost']) : '';
        $completionTime = isset($atts['completion_time']) ? esc_html($atts['completion_time']) : '';
        $onlineServiceUrl = isset($atts['online_service_url']) ? esc_url($atts['online_service_url']) : '';
        $iconColor = esc_attr($atts['icon_color']);

        $postID = $block->context['postId'];
        $postTerms = get_the_terms($postID, 'service_classification');
        $postTerms = is_array($postTerms) ? $postTerms : [];
        $classifications = '';
        $lastKey = array_key_last($postTerms);

        foreach ($postTerms as $key => $term) {
            $url = home_url('/') . 'servicios/' . $term->slug;
            $comma = $key === $lastKey ? '' : ',';

            $classifications .= "<a href='{$url}'>{$term->name}</a>{$comma} ";
        }

        ob_start();
?>
        <div class="wp-block-nortic-plugin-service-summary">
            <div class="service-summary-card mb-4 flex-1 cursor-pointer" >
                <div class="service-summary-card-content relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
                    <i class="bi bi-calendar4-week" style="color: <?php echo $iconColor; ?>"></i>
                    <h4 class="service-summary-title">
                        <?php esc_html_e("Schedule", "nortic-plugin"); ?>
                    </h4>
                    <div class="nortic-plugin-service-summary-data w-full">
                        <span><?php echo $hours; ?></span>
                    </div>
                </div>
            </div>
            <div class="service-summary-card mb-4 flex-1 px-4 py-8 cursor-pointer ">
                <div class="service-summary-card-content relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
                    <i class="bi bi-clock-history" style="color: <?php echo $iconColor; ?>"></i>
                    <h4 class="service-summary-title">
                        <?php esc_html_e("Completion time", "nortic-plugin"); ?>
                    </h4>
                    <div class="nortic-plugin-service-summary-data w-full">
                        <span><?php echo $completionTime; ?></span>
                    </div>
                </div>
            </div>
            <div class="service-summary-card mb-4 flex-1 px-4 py-8 cursor-pointer ">
                <div class="service-summary-card-content relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
                    <i class="bi bi-currency-dollar" style=" color: <?php echo $iconColor; ?>"></i>
                    <h4 class="service-summary-title">
                        <?php esc_html_e("Cost", "nortic-plugin"); ?>
                    </h4>
                    <div class="nortic-plugin-service-summary-data w-full">
                        <span><?php echo $cost; ?></span>
                    </div>
                </div>
            </div>
            <!-- <div class="service-summary-card mb-4 flex-1 px-4 py-16 cursor-pointer " data-aos="fade-up" data-aos-duration="3000">
                <div class="service-summary-card-content relative text-center max-w-xs overflow-hidden  bg-cover bg-no-repeat h-full">
                    <i class="bi bi-link-45deg" style="color: <?php echo $iconColor; ?>"></i>
                    <h4 class="service-summary-title">
                        <?php esc_html_e("Link", "nortic-plugin"); ?>
                    </h4>
                    <div class="nortic-plugin-service-summary-data w-full">
                        <div class="nortic-plugin-service-summary-data w-full">
                            <a href="<?php echo $onlineServiceUrl; ?>" target="_blank"><?php echo $onlineServiceUrl; ?></a>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
        <?php if ($onlineServiceUrl != '') : ?>
            <div class="container text-center py-8">
                <a href="<?php echo $onlineServiceUrl; ?>" target="_blank" class="button button-accent gap-4"><?php esc_html_e('Go to Service', 'nortic-plugin') ?> <i class="bi bi-arrow-right-circle"></i></a>
            </div>
        <?php endif; ?>

        <?php if ($postTerms) : ?>
            <div class="container text-center py-4">
                <h4 class="service-summary-view-more">
                    <?php 
                    // Translators: %s is the url for the classifications.
                    echo sprintf(__('View more information about this and other services in %s', 'nortic-plugin'), $classifications);
                    ?>
                </h4>
            </div>
        <?php endif; ?>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
