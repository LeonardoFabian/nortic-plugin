<?php

if (!function_exists('nortic_plugin_rest_api_add_rating_handler')) {
    /**
     * Store a rating using a REST API
     *
     * @param [type] $request
     * @return void
     */
    function nortic_plugin_rest_api_add_rating_handler($request)
    {
        $response = ['status' => 1]; // failed response

        $remoteIP = $_SERVER['REMOTE_ADDR'];
        $date = date('Y-m-d H:i:s');

        $params = $request->get_json_params();

        if (
            !isset($params['rating'], $params['postID'], $params['ratingMode'], $params['cookieTime']) ||
            empty($params['rating']) ||
            empty($params['ratingMode']) ||
            empty($params['cookieTime']) ||
            empty($params['postID'])
        ) {
            return $response;
        }

        $rating = round(floatval($params['rating']), 1);
        $cookie_name = 'nortic_plugin_rating_cookie_' . $params['postID'];
        $postID = absint($params['postID']);
        $ratingMode = $params['ratingMode'];
        $cookieTime = $params['cookieTime'];

        global $wpdb;
        $tableName =  "{$wpdb->prefix}nortic_plugin_ratings";

        $userID = null;
        $cookie = nortic_plugin_rating_set_cookie($postID, $remoteIP, $cookieTime);;


        // echo '<script>alert("' . $cookie . '");</script>';


        switch ($ratingMode) {
            case 'username':
                $userID = get_current_user_id();

                // retrieve post rating by logged user
                $wpdb->get_results($wpdb->prepare(
                    "SELECT * FROM {$tableName}
                    WHERE post_id=%d AND user_id=%d",
                    $postID,
                    $userID
                ));

                // check if the user has already made a rating
                if ($wpdb->num_rows > 0) {
                    return $response;
                }
                break;

            case 'cookie':

                // retrieve post rating by not logged user
                if ($cookie) {
                    $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$tableName}
                            WHERE post_id=%d AND cookie=%s",
                            $postID,
                            $cookie
                        )
                    );

                    // check if the user has already made a rating
                    if ($wpdb->num_rows > 0) {
                        return $response;
                    }
                }

                break;

            default:

                // retrieve post rating by not logged user
                if ($cookie) {
                    $wpdb->get_results(
                        $wpdb->prepare(
                            "SELECT * FROM {$tableName}
                        WHERE post_id=%d AND cookie=%s",
                            $postID,
                            $cookie
                        )
                    );

                    // check if the user has already made a rating
                    if ($wpdb->num_rows > 0) {
                        return $response;
                    }
                }
                break;
        }

        // insert the rating into the database
        if (!is_null($cookie) || !empty($cookie)) {
            $wpdb->insert(
                "{$tableName}",
                [
                    'post_id'   => $postID,
                    'user_id'   => $userID,
                    'cookie' => $cookie,
                    'rating_date' => $date,
                    'rating'    => $rating,
                ],
                ['%d', '%d', '%s', '%s', '%f']
            );
        }

        // get avg rating
        $avgRating = round($wpdb->get_var($wpdb->prepare(
            "SELECT AVG(`rating`) FROM {$tableName}
            WHERE post_id=%d",
            $postID
        )), 1);

        // get total rating
        $countRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(`rating`) FROM {$tableName}
            WHERE post_id=%d",
            $postID
        ));

        // count ratings with 5 stars 
        $fiveStarRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT count(`rating`)
            FROM {$tableName}
            WHERE `rating` > 4.99
            AND post_id=%d",
            $postID
        ));
        $fiveStarRatings = ($fiveStarRatings / $countRatings) * 100;

        // count ratings with 4 stars 
        $fourStarRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT count(`rating`)
            FROM {$tableName}
            WHERE `rating` BETWEEN 4.00 AND 4.99
            AND post_id=%d",
            $postID
        ));
        $fourStarRatings = ($fourStarRatings / $countRatings) * 100;

        // count ratings with 3 stars 
        $threeStarRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT count(`rating`)
            FROM {$tableName}
            WHERE `rating` BETWEEN 3.00 AND 3.99
            AND post_id=%d",
            $postID
        ));
        $threeStarRatings = ($threeStarRatings / $countRatings) * 100;

        // count ratings with 2 stars 
        $twoStarRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT count(`rating`)
            FROM {$tableName}
            WHERE `rating` BETWEEN 2.00 AND 2.99
            AND post_id=%d",
            $postID
        ));
        $twoStarRatings = ($twoStarRatings / $countRatings) * 100;

        // count ratings with 1 stars 
        $oneStarRatings = $wpdb->get_var($wpdb->prepare(
            "SELECT count(`rating`)
            FROM {$tableName}
            WHERE `rating` BETWEEN 1.00 AND 1.99
            AND post_id=%d",
            $postID
        ));
        $oneStarRatings = ($oneStarRatings / $countRatings) * 100;

        update_post_meta($postID, 'rating', $avgRating);
        update_post_meta($postID, 'total_ratings', $countRatings);
        update_post_meta($postID, 'one_star_ratings', $oneStarRatings);
        update_post_meta($postID, 'two_star_ratings', $twoStarRatings);
        update_post_meta($postID, 'three_star_ratings', $threeStarRatings);
        update_post_meta($postID, 'four_star_ratings', $fourStarRatings);
        update_post_meta($postID, 'five_star_ratings', $fiveStarRatings);

        do_action('post_rated', [
            'postID'    => $postID,
            'rating'    => $rating,
            'userID'    => $userID,
            'cookie'    => $cookie,
            'date'      => $date
        ]);

        $response['status'] = 2; // OK response
        $response['rating'] = $avgRating;
        $response['total'] = $countRatings;
        $response['oneStarRatings'] = $oneStarRatings;
        $response['twoStarRatings'] = $twoStarRatings;
        $response['threeStarRatings'] = $threeStarRatings;
        $response['fourStarRatings'] = $fourStarRatings;
        $response['fiveStarRatings'] = $fiveStarRatings;

        return $response;
    }
}
