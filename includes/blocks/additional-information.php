<?php

if (!function_exists('nortic_plugin_additional_information_field_render_cb')) {
    /**
     * Additional information block type render callback.
     *
     * @return void
     */
    function nortic_plugin_additional_information_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];
        $farewell = $atts['farewell'];

        /* AOS animation atts */

        $aos_animation = $atts['enable_aos_animation'] ? "data-aos='" . $atts['data_aos'] . "-" . $atts['data_aos_direction'] . "' data-aos-duration='" . $atts['data_aos_duration'] . "'" : "";

        if ($useDefaultTitle) {
            $title = __('Additional information', 'nortic-plugin');
        }

        $additionalInfo = get_post_meta($postID, 'additional_info', true);

        ob_start();
?>
        <?php if (!empty($additionalInfo)) : ?>
            <div class="wp-block-nortic-plugin-additional-information mb-12 mt-8 bg-blue-100 px-6 py-5 border-l-4 border-blue-700 text-base text-blue-700" role="alert">
                <i class="bi bi-info-circle-fill mr-6 text-4xl"></i>
                <div class="additional-information-content-container">
                    <h5><?php echo $title; ?></h5>
                    <?php nortic_plugin_sanitize_textarea_field($additionalInfo); ?>
                    <?php if (!empty($farewell)) : ?>
                        <hr class="border-blue-600 opacity-30" />
                        <p class="mb-0 mt-4">
                            <?php echo $farewell; ?>
                        </p>
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
