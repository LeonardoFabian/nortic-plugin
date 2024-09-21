<?php

if (!function_exists('nortic_plugin_awards_render_cb')) {
    function nortic_plugin_awards_render_cb($atts)
    {
        $categoriesID = array_map(function ($term) {
            return $term['id'];
        }, $atts['categories']);

        $args = [
            'post_type' => 'award',
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order']
        ];

        if (!empty($categoriesID)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'award_category',
                    'field' => 'term_id',
                    'terms' => $categoriesID
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
?>
        <!-- Sellos NORTIC -->
        <div class="wp-block-nortic-plugin-awards">
            <div class="stamp-container flex items-center">

                <?php

                if ($query->have_posts()) :

                    while ($query->have_posts()) :

                        $query->the_post();

                        $post_id = get_the_ID();
                        $iframe = get_post_meta($post_id, 'iframe', true);
                        $url = get_post_meta($post_id, 'url', true);
                        $description = get_post_meta($post_id, 'description', true);

                ?>

                        <div id="award-<?php echo $post_id; ?>" class="stamp-box flex justify-center">
                            <div class="stamp w-24 h-24">
                                <a href="<?php echo esc_url_raw($url); ?>" target="_blank" class="stamp stack-top" title="<?php echo esc_attr($description); ?>" rel="noopener">

                                    <?php

                                    if (!has_post_thumbnail()) {
                                        echo $iframe;
                                    } else {
                                        the_post_thumbnail();
                                    }

                                    ?>

                                </a>
                            </div>
                        </div>

                <?php

                    endwhile;
                endif;

                wp_reset_postdata();

                ?>


            </div>
        </div>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
