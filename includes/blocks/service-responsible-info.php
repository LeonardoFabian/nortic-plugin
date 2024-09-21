<?php

if (!function_exists('nortic_plugin_service_responsible_info_field_render_cb')) {
    /**
     * Service responsible info block type render callback.
     *
     * @return void
     */
    function nortic_plugin_service_responsible_info_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Responsible Unit', 'nortic-plugin');
        }

        $service_dependency_id = get_post_meta($postID, 'service_dependency_id', true);

        $dependency = get_post($service_dependency_id);
        $dependency_permalink = get_post_permalink($dependency->ID);
        $dependencyDescription = get_post_meta($dependency->ID, 'description', true);
        $dependencyLocation = get_post_meta($dependency->ID, 'location', true);
        $dependencyPhoneNumber = get_post_meta($dependency->ID, 'phone', true);
        $dependencyEmail = get_post_meta($dependency->ID, 'email', true);

        ob_start();
?>
        <?php if (!empty($service_dependency_id)) : ?>
            <section class="wp-block-nortic-plugin-service-responsible-info">
                <!-- <h5><?php echo $title; ?></h5> -->

                <!-- ====== Contact Section Start -->
                <div class="service-responsible-info-wrapper relative z-10  ">
                            <h5>
                                        <?php echo $title; ?>
                                    </h5>
                            <div class="service-responsible-info-data">
                           
                                <div class="service-responsible-info-metadata">
                                   
                                    <h6>
                                        <?php echo $dependency->post_title; ?>
                                    </h6>
                                    <!-- <p class="text-body-color mb-9 text-sm">
                                        <?php echo nortic_plugin_sanitize_textarea_field($dependencyDescription, 'text-sm'); ?>
                                    </p>  -->
                                </div>
                                <div class="service-responsible-contact-info">
                                    <!-- location -->
                                    <div class="service-responsible-contact-info-item flex w-full">
                                        <div class="  flex items-center justify-center  rounded bg-opacity-5 ">
                                            <i class="bi bi-house text-xl"></i>
                                        </div>
                                        <div class="w-full">
                                            <?php nortic_plugin_sanitize_textarea_field($dependencyLocation, 'text-sm'); ?>
                                        </div>
                                    </div>
                                    <!-- phone -->
                                    <div class="service-responsible-contact-info-item flex w-full ">
                                        <div class="  flex items-center justify-center  rounded bg-opacity-5 ">
                                            <i class="bi bi-telephone-inbound text-xl"></i>
                                        </div>
                                        <div class="w-full">
                                            <p class="text-body-color text-sm"><?php nortic_plugin_sanitize_textarea_field($dependencyPhoneNumber, 'text-sm'); ?></p>
                                        </div>
                                    </div>
                                    <!-- email -->
                                    <div class="service-responsible-contact-info-item flex w-full ">
                                        <div class="  flex items-center justify-center  rounded bg-opacity-5 ">
                                            <i class="bi bi-envelope-at text-xl"></i>
                                        </div>
                                        <div class="w-full">
                                            <p class="text-body-color text-sm"><?php nortic_plugin_sanitize_textarea_field($dependencyEmail, 'text-sm'); ?></p>
                                        </div>
                                    </div>
                                </div>   
                                <div class="service-responsible-contact-info-actions">
                                    <a href="<?php echo esc_url($dependency_permalink); ?>"><?php echo esc_html__('More details', 'nortic-plugin') ?> <i class="bi bi-arrow-right-circle"></i></a>
                                </div>                            
                            </div>
                     
                </div>
                <!-- ====== Contact Section End -->
            </section>



        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
