<?php

if (!function_exists('nortic_plugin_featured_services_render_cb')) {
    function nortic_plugin_featured_services_render_cb($atts)
    {
        $title = esc_html($atts['title']);
        $description = esc_html($atts['description']);
        $postType = 'service';
        $classificationIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['classifications']);

        $args = [
            'post_type' => $postType,
            'posts_per_page' => $atts['count'],
            'orderby' => 'meta_value_num',
            'meta_key' => 'rating',
            'order' => 'desc'
        ];

        // Filter query by terms
        if (!empty($classificationIDs)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'service_classification',
                    'field' => 'term_id',
                    'terms' => $classificationIDs
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
?>
        <div class="wp-block-nortic-plugin-featured-services">
         
                <div class="featured-services-header">
                    <?php if ($title) : ?>
                        <h5 class="font-semibold text-dark mb-4" style="color: <?php echo $atts['text_color']; ?>"><?php echo esc_html($title); ?></h5>
                    <?php endif; ?>
                    <?php if ($description) : ?>
                        <p><?php echo esc_html($description); ?></p>
                    <?php endif; ?>
                </div>
                <ul class="featured-services-wrapper">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                            $post_id = get_the_ID();
                            $terms = get_the_terms($post_id, 'service_classification');

                            $rating = get_post_meta($post_id, 'rating', true);
                            $serviceDescription = get_post_meta($post_id, 'description', true);

                            $star_classes = [];
                            for ($i = 1; $i <= 5; $i++) {
                                if ($rating >= $i) {
                                    $star_classes[] = "bi-star-fill";
                                } elseif ($rating >= $i - 0.5) {
                                    $star_classes[] = "bi-star-half";
                                } else {
                                    $star_classes[] = "bi-star";
                                }
                            }
                            ?>

                            <li class="featured-services-item service-<?php echo esc_attr($post_id); ?>">
                                <div>                        
                                    <a href="<?php echo get_the_permalink(); ?>"><?php echo get_the_title(); ?></a>
                                </div>

                                <span class="featured-service-rating rounded-full ml-auto text-md font-medium">
                                    <ul>                                    
                                        <?php foreach ($star_classes as $class) : ?>
                                            <li><i class="bi <?php echo $class; ?>"></i></li>
                                        <?php endforeach; ?>                          
                                    </ul>
                                    <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>
                                </span>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
                <?php if ($postType) : ?>
                    <?php $archiveLink = get_post_type_archive_link($postType); ?>
                    <div class="cotainer text-center my-4">
                        <a href="<?php echo $archiveLink; ?>" class="button button-secondary"> <?php esc_html_e('See more', 'nortic-plugin') ?> <i class="bi bi-arrow-right-circle"></i></a>
                    </div>
                <?php endif; ?>
           
        </div>
<?php
        wp_reset_postdata();

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
