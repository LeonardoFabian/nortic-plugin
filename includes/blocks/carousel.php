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
        <div class="wp-block-nortic-plugin-carousel glide-carousel relative ">
            <!-- Carousel wrapper -->
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
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
                            <li class="glide__slide relative" >
                                 <!-- IMG CENTRADA + OPACIDAD EN HOVER -->
                                <div class="carousel_image_container">
                                <img class="nortic-plugin-carousel-image" src="<?php echo $imageURL; ?>" alt="<?php the_title(); ?>" />
                                </div>
                                        
                                <!-- CONTENIDO -->
                                <div class="carousel_content" data-aos="fade-right" data-aos-duration="1000">
                                    <h2 class="carousel-content-title"><?php echo get_the_title(); ?></h2>
                                </div>                   
                            </li>
                        <?php endwhile; ?>                   
                </ul>                 
            </div>
            <!-- end .glide__track -->
                    
            <!-- Slider indicators  -->
            <div class="glide__bullets " data-glide-el="controls[nav]">
                <?php for ($i = 0; $i < $atts['count']; $i++) { ?>
                    <button type="button" class="glide__bullet w-4 h-4 rounded-full" aria-label="Slide <?php echo $i + 1; ?>" data-glide-dir="=<?php echo $i; ?>"></button>
                <?php } ?>
            </div>  

            <!-- Carousel controls -->  
            <div class="glide__arrows " data-glide-el="controls[nav]">
                <button class="glide__arrow glide__arrow--prev" data-glide-dir="<">
                <i class="bi bi-chevron-left"></i>
                </button>
                <button class="glide__arrow glide__arrow--next" data-glide-dir=">">
                <i class="bi bi-chevron-right"></i>
                </button>
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
