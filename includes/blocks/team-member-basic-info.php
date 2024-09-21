<?php

if (!function_exists('nortic_plugin_team_member_basic_info_field_render_cb')) {
    /**
     * Service responsible info block type render callback.
     *
     * @return void
     */
    function nortic_plugin_team_member_basic_info_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $showFeaturedImage = $atts['show_featured_image'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = get_the_title($postID);
        }

        $fullName = get_post_meta($postID, 'full_name', true);
        $jobTitle = get_post_meta($postID, 'job_title', true);

        ob_start();
?>
        <?php if (!empty($fullName)) : ?>
            <div class="wp-block-nortic-plugin-team-member-basic-info">
                <?php if ($useDefaultTitle) : ?>
                    <h3><?php echo $title; ?></h3>
                <?php endif; ?>

                <!-- ====== Contact Section Start -->
                <div class="flex flex-col text-left">
                    <?php if($showFeaturedImage) : ?>
                        <img src="<?php echo get_the_post_thumbnail_url($postID, 'full'); ?>" class="w-32 h-32 bg-gray-300 rounded-full mb-4 shrink-0">
                        <?php endif; ?>
                    </img>
                    <h1 class="text-xl font-bold"><?php echo $fullName; ?></h1>
                    <p class="text-gray-600"><?php echo $jobTitle; ?></p>
                </div>
                <!-- ====== Contact Section End -->
            </div>
        <?php endif; ?>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
