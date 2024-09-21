<?php 
if (!function_exists('nortic_plugin_team_list_render_cb')) {
    function nortic_plugin_team_list_render_cb($atts, $content) {
        
        if (is_singular('team')) {
            $postID = get_the_ID();
            $args = [
                'post_type' => 'team', 
                'p' => $postID // get only the current post
            ];
        } else {
            $categories_Ids = array_map(function ($term) {
                return $term['id'];
            }, $atts['group_terms']);

            $postType = 'team';
    
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;  

            $args = [
                'post_type' => $postType,
                'posts_per_page' => $atts['numberOfItems'],
                'orderby' => $atts['orderBy'],
                'order' => $atts['order'],
                'paged' => $paged
            ];

            if (!empty($categories_Ids)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'group',
                        'field' => 'term_id',
                        'terms' => $categories_Ids
                    ]
                ];
            }
        }

        $query = new WP_Query($args);

        ob_start();
?>

        <div class="wp-block-nortic-plugin-nortic-team-list">
            <section class="posts-container">
                <div class="swiper-container mySwiper2 <?php echo $atts['show_navigation_thumbs'] ? '' : 'h-full'; ?>">
                    <div class="swiper-wrapper">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <?php
                                $postID = get_the_ID();
                                $team_title = get_the_title();
                                $terms = get_the_terms($postID, 'category');
                                $full_name = get_post_meta($postID, 'full_name', true);
                                ?>
                                <div class="swiper-slide" id="post-<?php echo $postID; ?>">
                                    <?php the_post_thumbnail('full'); ?>
                                    <div class="team-list__single_post--content">
                                        <h5>
                                            <?php if(!empty($full_name)) echo $full_name; ?>
                                        </h5>
                                        <a href="<?php the_permalink(); ?>" class="team-list__single_post--title">
                                            <?php echo $team_title; ?>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                        <?php wp_reset_postdata(); ?>
                    </div>
                </div>
                <?php if($atts['show_navigation_thumbs']) : ?>
                    <div class="swiper-container mySwiperThumbs <?php echo ($atts['show_navigation_thumbs'] && !is_singular('team')) ? '' : 'hidden'; ?>">
                    <div class="swiper-wrapper">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <div class="swiper-slide">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </div>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </section>
        </div>

<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}

