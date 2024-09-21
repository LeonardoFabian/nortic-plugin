<?php

if (!function_exists('nortic_plugin_rating_render_cb')) {
    function nortic_plugin_rating_render_cb($atts, $content, $block)
    {
        $ratingMode = $atts['rating_mode'];
        $cookieTime = absint($atts['cookie_time']);
        $remoteIP = $_SERVER['REMOTE_ADDR'];

        $postID = $block->context['postId'];
        $rating = get_post_meta($postID, 'rating', true);
        $totalRatings = get_post_meta($postID, 'total_ratings', true);
        $oneStarRatings = get_post_meta($postID, 'one_star_ratings', true);
        $twoStarRatings = get_post_meta($postID, 'two_star_ratings', true);
        $threeStarRatings = get_post_meta($postID, 'three_star_ratings', true);
        $fourStarRatings = get_post_meta($postID, 'four_star_ratings', true);
        $fiveStarRatings = get_post_meta($postID, 'five_star_ratings', true);

        $postType = get_post_type_object(get_post_type($postID));

        $title = isset($postType) ? $postType->labels->singular_name  : '';

        global $wpdb;

        $userID = null;
        $cookie = nortic_plugin_rating_set_cookie($postID, $remoteIP, $cookieTime);
        $userPostRating = 0;
        $permission = false;

        // echo '<script>alert("' . $cookie . '")</script>';

        switch ($ratingMode) {
            case 'username':
                $userID = get_current_user_id();

                if ($userID) {
                    // prevent user more rating
                    $userPostRating = $wpdb->get_var($wpdb->prepare(
                        "SELECT COUNT(*) FROM {$wpdb->prefix}nortic_plugin_ratings
                    WHERE post_id=%d AND user_id=%d",
                        $postID,
                        $userID
                    ));
                }

                $permission = is_user_logged_in();

                break;

            case 'cookie':

                $userPostRating = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(*) FROM {$wpdb->prefix}nortic_plugin_ratings 
                            WHERE post_id=%d AND cookie=%s",
                        $postID,
                        $cookie
                    )
                );

                $permission = $userPostRating > 0 ? __return_false() : __return_true();

                break;

            default:

                $userPostRating = $wpdb->get_var(
                    $wpdb->prepare(
                        "SELECT COUNT(*) FROM {$wpdb->prefix}nortic_plugin_ratings 
                        WHERE post_id=%d AND cookie=%s",
                        $postID,
                        $cookie
                    )
                );

                $permission = $userPostRating > 0 ? false : true;

                break;
        }


        ob_start();
?>

        <div <?php echo get_block_wrapper_attributes(); ?> >
            <div class="nortic-plugin-rating-header">
                <h5><?php esc_html_e('Rate this service', 'nortic-plugin'); ?></h5>
                <p><?php esc_html_e('How would you rate this service?', 'nortic-plugin'); ?></p>
            </div>
            <div id="post-type-rating" class="post-type-rating-data" data-post-id="<?php echo $postID; ?>" data-avg-rating="<?php echo $rating; ?>" data-logged-in="<?php echo $permission; ?>" data-total-ratings="<?php echo $totalRatings; ?>" data-one-star-ratings="<?php echo $oneStarRatings; ?>" data-two-star-ratings="<?php echo $twoStarRatings; ?>" data-three-star-ratings="<?php echo $threeStarRatings; ?>" data-four-star-ratings="<?php echo $fourStarRatings; ?>" data-five-star-ratings="<?php echo $fiveStarRatings; ?>" data-user-post-rating="<?php echo $userPostRating; ?>" data-rating-mode="<?php echo $ratingMode; ?>" data-cookie-time="<?php echo $cookieTime; ?>"></div>

        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
