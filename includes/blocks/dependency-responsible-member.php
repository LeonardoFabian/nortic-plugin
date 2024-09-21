<?php

if (!function_exists('nortic_plugin_dependency_responsible_member_field_render_cb')) {
    /**
     * Service responsible info block type render callback.
     *
     * @return void
     */
    function nortic_plugin_dependency_responsible_member_field_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $useDefaultTitle = $atts['use_default_title'];
        $title = $atts['title'];

        if ($useDefaultTitle) {
            $title = __('Responsible member', 'nortic-plugin');
        }

        $reponsible_member_id = get_post_meta($postID, 'reponsible_member_id', true);

        $teamMember = get_post($reponsible_member_id);
        $team_member_position = get_the_title($teamMember->ID);
        $fullName = get_post_meta($teamMember->ID, 'full_name', true);
        $jobTitle = get_post_meta($teamMember->ID, 'job_title', true);
        $image_url = get_the_post_thumbnail_url($teamMember->ID, 'full') ? get_the_post_thumbnail_url($teamMember->ID, 'full') : NORTIC_PLUGIN_URL . 'dist/public/images/avatar.svg';
        $biography = get_post_meta($teamMember->ID, 'biography', true);
        $phoneNumber = get_post_meta($teamMember->ID, 'phone', true);
        $mobileNumber = get_post_meta($teamMember->ID, 'mobile', true);
        $email = get_post_meta($teamMember->ID, 'email', true);
        $facebook = get_post_meta($teamMember->ID, 'facebook', true);
        $instagram = get_post_meta($teamMember->ID, 'instagram', true);
        $twitter = get_post_meta($teamMember->ID, 'twitter', true);
        $linkedin = get_post_meta($teamMember->ID, 'linkedin', true);


        ob_start();
?>
        <?php if (!empty($reponsible_member_id)) : ?>
            <div class="wp-block-nortic-plugin-dependency-responsible-member">
                <!-- <h5><?php echo $title; ?></h5> -->

                <div class="dependency-responsible-member-wrapper">
                    <div class="dependency-responsible-member-avatar-wrapper">
                        <img src="<?php echo $image_url; ?>" class="dependency-responsible-member-avatar">
                    </div>
                    <div class="dependency-responsible-member-meta">
                        
                        <h6 class="dependency-responsible-member-name"><?php echo $fullName; ?></h6>
                        <span class="dependency-responsible-member-position">
                            <a href="<?php echo get_post_permalink($teamMember->ID); ?>" >
                                <?php echo $team_member_position; ?>
                            </a>
                        </span>
                    
           

                  
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
