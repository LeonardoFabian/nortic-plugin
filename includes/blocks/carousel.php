<?php

if (!function_exists('nortic_plugin_carousel_render_cb')) {
    function nortic_plugin_carousel_render_cb($atts)
    {
        $categoriesIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['categories']);

        if(is_tax('province')) {
            $current_province_term = get_queried_object();
            $current_province_name = $current_province_term->name;
            $current_province_id = $current_province_term->term_id;

            $args = [
                'post_type' => 'post',
                'posts_per_page' => $atts['count'],
                'orderby' => $atts['orderBy'],
                'order' => $atts['order'],
                'tax_query' => [
                    [
                        'taxonomy' => 'province',
                        'field' => 'term_id',
                        'terms' => $current_province_id
                    ]
                ],
            ];
    
            if (!empty($categoriesIDs)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $categoriesIDs
                    ]
                ];
            }
        } else {
            $args = [
                'post_type' => 'post',
                'posts_per_page' => $atts['count'],
                'orderby' => $atts['orderBy'],
                'order' => $atts['order']
            ];
    
            if (!empty($categoriesIDs)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $categoriesIDs
                    ]
                ];
            }
        }

        $query = new WP_Query($args);


        ob_start();
?>
            <?php if ($query->have_posts()) : ?>
        <div class="wp-block-nortic-plugin-carousel glide-carousel relative overflow-hidden">
            <!-- Carousel wrapper -->
            <div class="glide__track" data-glide-el="track">
                <div class="glide__slides flex">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                            $post_id = get_the_ID();
                            $imageURL = wp_get_attachment_url(get_post_thumbnail_id($post_id, 'bannerHero'));
                            $cats = get_the_category($post_id);
                            // $post_date = get_the_date('Y-m-d', $post_id); // 1986-09-20
                            $post_date = get_the_date('l F j, Y', $post_id); // Thursday September 20, 1986
                            // $post_date = get_the_date('D M j', $post_id); // Thu Sep 20
                            $post_date_ISO_8601 = get_the_date('c', $post_id);
                            // var_dump($cats);

                            if(!empty($cats) && is_array($cats)) {
                                $first_cat = $cats[0];
                                $category_name = $first_cat->name;  
                                $category_permalink = get_category_link($first_cat);
                                $category_id = $first_cat->term_id;
                            }
                            ?>
                            <div class="glide__slide">
                                <div class="carousel_bg-image" style="background-image: url('<?php echo $imageURL; ?>'); background-repeat: no-repeat; background-position: center; background-size: cover;">
                                    <div class="carousel_content  flex flex-col justify-end w-screen cursor-pointer">
                                        <div class="container mx-auto">
                                            <div class="relative">
                                                <div class="nortic-plugin-carousel-content absolute" data-aos="fade-right" data-aos-duration="1000">
                                                    <div>
                                                        <!-- categories -->
                                                        <?php if(!empty($category_name)): ?>
                                                        <ul class="carousel-post-cats">                                                      
                                                            <li class="carousel-post-cat-item category-<?php echo $category_id; ?>">
                                                                <a class="text-sm" href="<?php echo $category_permalink; ?>"><?php echo $category_name; ?></a>
                                                            </li>
                                                            <?php if(is_tax('province')): ?>
                                                                <li class="carousel-post-cat-item carousel-post-cat-item-province province-<?php echo $current_province_id; ?>">
                                                                    <a class="text-sm" href="<?php echo $category_permalink; ?>"><?php echo $current_province_name; ?></a>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                        <?php endif; ?>
                                                        <!-- title -->
                                                        <h3 class="nortic-plugin-carousel-heading" ><a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a></h3>
                                                        <?php if ($atts['show_the_excerpt']) : ?>
                                                            <p class="carousel-content-excerpt"><?php echo get_the_excerpt(); ?></p>
                                                        <?php endif; ?>
                                                        <time datetime="<?php echo esc_attr($post_date_ISO_8601); ?>" itemprop="datePublished" class="text-sm text-body-color uppercase">
                                                            <?php echo esc_html($post_date); ?>
                                                        </time>
                                                    </div>
                                                    <!-- link -->
                                                    <div class="nortic-plugin-carousel-actions">
                                                    <!-- <i class="fa-solid fa-circle-arrow-right"></i> -->
                                                    
                                                        <a href="<?php the_permalink(); ?>" class="normic-plugin-carousel-read-more">
                                                            <span class="dashicons dashicons-arrow-right-alt"></span>
                                                            <?php esc_html_e('Read more', 'nortic-plugin'); ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>

                   
                </div>

                <!-- Slider indicators  -->
                <div class="glide__bullets slide-indicators absolute bottom-4 w-full z-30 flex items-center justify-center mx-auto space-x-3" data-glide-el="controls[nav]">
                    <?php for ($i = 0; $i < $atts['count']; $i++) { ?>
                        <button type="button" class="glide__bullet w-3 h-3 rounded-full" aria-label="Slide <?php echo $i + 1; ?>" data-glide-dir="=<?php echo $i; ?>"></button>
                    <?php } ?>
                </div>       
            </div>


        </div>
        <?php else : ?>
                        <?php return null; ?>
                    <?php endif; ?>
<?php
        wp_reset_postdata();

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
