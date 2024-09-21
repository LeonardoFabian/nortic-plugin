<?php

if (!function_exists('nortic_plugin_save_post_team')) {
    /**
     * Fires a team member has been saved/published
     *
     * @return void
     */
    function nortic_plugin_save_post_team($postID)
    {
        // prevent save in post autosave doing
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $fullName = get_post_meta($postID, 'full_name', true);
        $fullName =
            empty($fullName)
            ? ''
            : sanitize_text_field($fullName);

        $jobTitle = get_post_meta($postID, 'job_title', true);
        $jobTitle =
            empty($jobTitle)
            ? ''
            : sanitize_text_field($jobTitle);

        $biography = get_post_meta($postID, 'biography', true);
        $biography =
            empty($biography)
            ? ''
            : sanitize_textarea_field($biography);

        update_post_meta($postID, 'full_name', $fullName);
        update_post_meta($postID, 'job_title', $jobTitle);
        update_post_meta($postID, 'biography', $biography);
    }
}
