<?php

if (!function_exists('nortic_plugin_contact_info_field_render_cb')) {
    /**
     * Service responsible info block type render callback.
     *
     * @return void
     */
    function nortic_plugin_contact_info_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Contact Information', 'nortic-plugin');
        }

        $location = get_post_meta($postID, 'location', true);
        $phone = get_post_meta($postID, 'phone', true);
        $email = get_post_meta($postID, 'email', true);
        $map_iframe = get_post_meta($postID, 'map_iframe', true);

        ob_start();
?>
        <?php if (!empty($location) || !empty($phone) || !empty($email)) : ?>
            <div class="wp-block-nortic-plugin-contact-info">
                <div class="contact-info-wrapper">
                    <div class="contact-info-content-wrapper">
                        <h5><?php echo $title; ?></h5>
            
                        <div class="contact-info-content-meta">                 
                            
                            <!-- email -->
                            <?php if (!empty($email)) : ?>
                                <div class="contact-info-content-meta-item">
                                    <div class="contact-info-icon-wrapper">
                                        <i class="bi bi-envelope-at"></i>
                                    </div>
                                    <div class="w-full">
                                        <?php nortic_plugin_sanitize_textarea_field($email); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- phone -->
                            <?php if (!empty($phone)) : ?>
                                <div class="contact-info-content-meta-item">
                                    <div class="contact-info-icon-wrapper">
                                        <i class="bi bi-telephone-inbound"></i>
                                    </div>
                                    <div class="w-full">
                                        <?php nortic_plugin_sanitize_textarea_field($phone); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- location -->
                            <?php if (!empty($location)) : ?>
                                <div class="contact-info-content-meta-item">
                                    <div class="contact-info-icon-wrapper">
                                    <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="w-full">
                                        <?php nortic_plugin_sanitize_textarea_field($location); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- map -->
                    <?php if (!empty($map_iframe)) : ?>
                        <div class="contact-info-map-wrapper"><?php echo $map_iframe; ?></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
