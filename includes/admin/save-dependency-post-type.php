<?php

if (!function_exists('nortic_plugin_save_post_dependency')) {
    /**
     * Fires once a dependency has been saved/published
     *
     * @param int $postID Dependency ID
     * @return void
     */
    function nortic_plugin_save_post_dependency($postID)
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        /**
         * @var int $parent_dependency_id
         * @return int Dependency ID
         */
        $parent_dependency_id = get_post_meta($postID, 'parent_dependency_id', true);

        /**
         * @var int $reponsible_member_id
         * @return int Team member ID
         */
        $reponsible_member_id = get_post_meta($postID, 'reponsible_member_id', true);

        /**
         * @var string $iframe
         * @return string Embed content
         */
        $iframe = get_post_meta($postID, 'iframe', true);

        /**
         * @var float $rating Rating AVG
         */
        $rating = get_post_meta($postID, 'rating', true);

        /**
         * @var int $total_ratings Ratings count
         */
        $total_ratings = get_post_meta($postID, 'total_ratings', true);

        /**
         * @var string $general_objective Dependency general objective
         */
        $general_objective = get_post_meta($postID, 'general_objective', true);

        /**
         * @var string $specific_objective Dependency specific objective
         */
        $specific_objective = get_post_meta($postID, 'specific_objective', true);

        /**
         * @var string $mission
         * @return string Dependency mission.
         */
        $mission = get_post_meta($postID, 'mission', true);

        /**
         * @var string $vision
         * @return string Dependency vision.
         */
        $vision = get_post_meta($postID, 'vision', true);

        /**
         * @var string $values
         * @return string Dependency values.
         */
        $values = get_post_meta($postID, 'values', true);

        /**
         * @var string $main_functions 
         * @return string Dependency main functions
         */
        $main_functions = get_post_meta($postID, 'main_functions', true);

        /**
         * @var string $interests 
         * @return string Dependency interests.
         */
        $interests = get_post_meta($postID, 'interests', true);

        /**
         * @var string $map_link
         * @return string Map link
         */
        $map_link = get_post_meta($postID, 'map_link', true);

        /**
         * @var string $map_iframe
         * @return string Embed map
         */
        $map_iframe = get_post_meta($postID, 'map_iframe', true);

        $achievements = get_post_meta($postID, 'achievements', true);

        /**
         * @var string $description
         * @return string Description
         */
        $description = get_post_meta($postID, 'description', true);

        $schedule = get_post_meta($postID, 'schedule', true);

        $phone_service_available = get_post_meta($postID, 'phone_service_available', true);

        /**
         * @var string $phone
         * @return string Dependency phone number
         */
        $phone = get_post_meta($postID, 'phone', true);

        $email_service_available = get_post_meta($postID, 'email_service_available', true);

        /**
         * @var string $email
         * @return string Dependency email
         */
        $email = get_post_meta($postID, 'email', true);

        $in_person_service_available = get_post_meta($postID, 'in_person_service_available', true);

        /**
         * @var string $location
         * @return string Dependency location address
         */
        $location = get_post_meta($postID, 'location', true);

        /* validations */

        $iframe =
            empty($iframe)
            ? ''
            : nortic_plugin_sanitize_iframe($iframe);

        $location =
            empty($location)
            ? ''
            : sanitize_textarea_field($location);

        $in_person_service_available =
            empty($in_person_service_available)
            ? 0
            : absint($in_person_service_available);

        $email =
            empty($email)
            ? ''
            : sanitize_email($email);

        $email_service_available =
            empty($email_service_available)
            ? 0
            : absint($email_service_available);

        $phone =
            empty($phone)
            ? ''
            : sanitize_text_field($phone);

        $phone_service_available =
            empty($phone_service_available)
            ? 0
            : absint($phone_service_available);

        $schedule =
            empty($schedule)
            ? ''
            : sanitize_textarea_field($schedule);

        $description =
            empty($description)
            ? ''
            : sanitize_textarea_field($description);

        $achievements =
            empty($achievements)
            ? ''
            : sanitize_textarea_field($achievements);

        $rating =
            empty($rating)
            ? 0
            : floatval($rating);

        $total_ratings =
            empty($total_ratings)
            ? 0
            : absint($total_ratings);

        $general_objective =
            empty($general_objective)
            ? ''
            : sanitize_textarea_field($general_objective);

        $specific_objective =
            empty($specific_objective)
            ? ''
            : sanitize_textarea_field($specific_objective);

        $mission =
            empty($mission)
            ? ''
            : sanitize_textarea_field($mission);

        $vision =
            empty($vision)
            ? ''
            : sanitize_textarea_field($vision);

        $values =
            empty($values)
            ? ''
            : sanitize_textarea_field($values);

        $main_functions =
            empty($main_functions)
            ? ''
            : sanitize_textarea_field($main_functions);

        $interests =
            empty($interests)
            ? ''
            : sanitize_textarea_field($interests);

        $map_link =
            empty($map_link)
            ? ''
            : esc_url_raw($map_link);

        $map_iframe =
            empty($map_iframe)
            ? ''
            : nortic_plugin_sanitize_iframe($map_iframe);

        $reponsible_member_id =
            empty($reponsible_member_id)
            ? 0
            : intval($reponsible_member_id);

        $parent_dependency_id = empty($parent_dependency_id)
        ? 0
        : intval($parent_dependency_id);

        update_post_meta($postID, 'parent_dependency_id', $parent_dependency_id);

        update_post_meta($postID, 'reponsible_member_id', $reponsible_member_id);

        update_post_meta($postID, 'iframe', $iframe);

        update_post_meta($postID, 'location', $location);

        update_post_meta($postID, 'in_person_service_available', $in_person_service_available);

        update_post_meta($postID, 'email', $email);

        update_post_meta($postID, 'email_service_available', $email_service_available);

        update_post_meta($postID, 'phone', $phone);

        update_post_meta($postID, 'phone_service_available', $phone_service_available);

        update_post_meta($postID, 'schedule', $schedule);

        update_post_meta($postID, 'description', $description);

        update_post_meta($postID, 'achievements', $achievements);

        update_post_meta($postID, 'rating', $rating);

        update_post_meta($postID, 'total_ratings', $total_ratings);

        update_post_meta($postID, 'general_objective', $general_objective);

        update_post_meta($postID, 'specific_objective', $specific_objective);

        update_post_meta($postID, 'mission', $mission);

        update_post_meta($postID, 'vision', $vision);

        update_post_meta($postID, 'values', $values);

        update_post_meta($postID, 'main_functions', $main_functions);

        update_post_meta($postID, 'interests', $interests);

        update_post_meta($postID, 'map_link', $map_link);

        update_post_meta($postID, 'map_iframe', $map_iframe);
    }
}
