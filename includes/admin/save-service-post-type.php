<?php

if (!function_exists('nortic_plugin_save_post_service')) {
    /**
     * Fires once a service has been saved/published
     *
     * @param int $postID Post ID
     * @return void
     */
    function nortic_plugin_save_post_service($postID)
    {

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        $service_dependency_id = get_post_meta($postID, 'service_dependency_id', true);

        $rating = get_post_meta($postID, 'rating', true); // retrieve rating value if exists
        $rating = empty($rating) ? 0 : floatval($rating);

        $totalRatings = get_post_meta($postID, 'total_ratings', true);
        $totalRatings = empty($totalRatings) ? 0 : absint($totalRatings);

        $oneStarRatings = get_post_meta($postID, 'one_star_ratings', true);
        $oneStarRatings = empty($oneStarRatings) ? 0 : absint($oneStarRatings);

        $twoStarRatings = get_post_meta($postID, 'two_star_ratings', true);
        $twoStarRatings = empty($twoStarRatings) ? 0 : absint($twoStarRatings);

        $threeStarRatings = get_post_meta($postID, 'three_star_ratings', true);
        $threeStarRatings = empty($threeStarRatings) ? 0 : absint($threeStarRatings);

        $fourStarRatings = get_post_meta($postID, 'four_star_ratings', true);
        $fourStarRatings = empty($fourStarRatings) ? 0 : absint($fourStarRatings);

        $fiveStarRatings = get_post_meta($postID, 'five_star_ratings', true);
        $fiveStarRatings = empty($fiveStarRatings) ? 0 : absint($fiveStarRatings);


        $service_dependency_id =
            empty($service_dependency_id)
            ? 0
            : intval($service_dependency_id);

        update_post_meta($postID, 'service_dependency_id', $service_dependency_id);

        update_post_meta($postID, 'rating', $rating);
        update_post_meta($postID, 'total_ratings', $totalRatings);
        update_post_meta($postID, 'one_star_ratings', $oneStarRatings);
        update_post_meta($postID, 'two_star_ratings', $twoStarRatings);
        update_post_meta($postID, 'three_star_ratings', $threeStarRatings);
        update_post_meta($postID, 'four_star_ratings', $fourStarRatings);
        update_post_meta($postID, 'five_star_ratings', $fiveStarRatings);
    }
}
