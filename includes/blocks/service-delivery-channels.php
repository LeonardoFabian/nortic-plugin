<?php 

if(!function_exists('nortic_plugin_service_delivery_channels_render_cb')) {
    function nortic_plugin_service_delivery_channels_render_cb($atts, $content, $block) {
        $post_id = $block->context['postId'];
        $use_default_title = $atts['use_default_title'];
        $title = $atts['title'];

        if($use_default_title) {
            $title = __('Available in:', 'nortic-plugin');
        }

        $phone_service_available = get_post_meta($post_id, 'phone_service_available', true);
        $email_service_available = get_post_meta($post_id, 'email_service_available', true);
        $in_person_service_available = get_post_meta($post_id, 'in_person_service_available', true);
        $online_service_available = get_post_meta($post_id, 'online_service_available', true);
        $app_service_available = get_post_meta($post_id, 'app_service_available', true);

        ob_start();

        ?> 

        <div class="wp-block-nortic-plugin-service-delivery-channels">
            <h5><?php echo esc_html($title); ?></h5>
            <ul class="service-delivery-channels-wrapper">
             
                    <li class="service-delivery-channels-item <?php echo $phone_service_available ? "service-delivery-channels-item-available" : ""; ?>" title="<?php echo esc_html__("Phone", 'nortic-plugin'); ?>">
                        <i class="bi bi-telephone-inbound"></i>
                        <span class="screen-reader-text"><?php echo $phone_service_available ? esc_html__('Telephone support available', 'nortic-plugin') : esc_html__('Telephone support not available', 'nortic-plugin'); ?></span>
                    </li>

                    <li class="service-delivery-channels-item <?php echo $email_service_available ? "service-delivery-channels-item-available" : ""; ?>" title="<?php echo esc_html__("Email", 'nortic-plugin'); ?>">
                        <i class="bi bi-envelope-at"></i>
                        <span class="screen-reader-text"><?php echo $email_service_available ? esc_html__('Email support available', 'nortic-plugin') : esc_html__('Email support not available', 'nortic-plugin'); ?></span>
                    </li>

                    <li class="service-delivery-channels-item <?php echo $in_person_service_available ? "service-delivery-channels-item-available" : ""; ?>" title="<?php echo esc_html__("In-Person", 'nortic-plugin'); ?>">
                        <i class="bi bi-pin"></i>
                        <span class="screen-reader-text"><?php echo $in_person_service_available ? esc_html__('In-Person support available', 'nortic-plugin') : esc_html__('In-Person support not available', 'nortic-plugin'); ?></span>
                    </li>

                    <li class="service-delivery-channels-item <?php echo $online_service_available ? "service-delivery-channels-item-available" : ""; ?>" title="<?php echo esc_html__("Online", 'nortic-plugin'); ?>">
                        <i class="bi bi-laptop"></i>
                        <span class="screen-reader-text"><?php echo $online_service_available ? esc_html__('Online support available', 'nortic-plugin') : esc_html__('Online support not available', 'nortic-plugin'); ?></span>
                    </li>


                    <li class="service-delivery-channels-item <?php echo $app_service_available ? "service-delivery-channels-item-available" : ""; ?>" title="<?php echo esc_html__("App", 'nortic-plugin'); ?>">
                        <i class="bi bi-phone"></i>
                        <span class="screen-reader-text"><?php echo $app_service_available ? esc_html__('Service available on our mobile app', 'nortic-plugin') : esc_html__('Service not available on our mobile app', 'nortic-plugin'); ?></span>
                    </li>

            </ul>
        </div>

<?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}