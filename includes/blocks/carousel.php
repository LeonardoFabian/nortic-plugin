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
                'post_type' => ['post', 'slide'],
                'posts_per_page' => $atts['count'],
                'orderby' => $atts['orderBy'],
                'order' => $atts['order'],
                'tax_query' => [
                     'relation' => 'OR',
                    [
                        'taxonomy' => 'province',
                        'field' => 'term_id',
                        'terms' => $current_province_id
                    ],
                    [
                        'taxonomy' => 'province',
                        'operator' => 'NOT EXISTS', // Esto incluye a los CPTs como slide que no tienen provincia
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
                'post_type' => ['post', 'slide'],
                'posts_per_page' => $atts['count'],
                'orderby' => $atts['orderBy'],
                'order' => $atts['order']
            ];
    
            if (!empty($categoriesIDs)) {
                $args['tax_query'] = [
                    'relation' => 'OR',
                    [
                        'taxonomy' => 'category',
                        'field' => 'term_id',
                        'terms' => $categoriesIDs
                    ],
                    [
                        'taxonomy' => 'province',
                        'operator' => 'NOT EXISTS', // Esto incluye a los CPTs como slide que no tienen provincia
                    ]
                ];
            }
        }

        $query = new WP_Query($args);


        ob_start();
?>
        <?php if ($query->have_posts()) : ?>
        <div class="wp-block-nortic-plugin-carousel glide-carousel relative max-w-[1750px] mx-auto">
            <!-- Carousel wrapper -->
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides">
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                            $post_id = get_the_ID();
                            $post_title = get_the_title();
                            $post_excerpt = get_the_excerpt();
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
                            <li class="glide__slide relative grid h-[58vh] max-h-[680px]" >
                                 <!-- IMG CENTRADA + OPACIDAD EN HOVER -->
                                <div class="carousel_image_container absolute inset-0">
                                    <figure style="width: auto;">
                                        <img class="nortic-plugin-carousel-image" src="<?php echo $imageURL; ?>" alt="<?php the_title(); ?>" style="position: absolute; height: 100%; width: 100%; inset: 0px; color: transparent;" />
                                    </figure>
                                </div>
                                        
                                <!-- CONTENIDO -->
                                <div class="carousel_content z-0 ml-12 mr-48 flex max-w-lg flex-col justify-center md:mx-28 lg:mx-36" data-aos="fade-right" data-aos-duration="1000">
                                    <div class="flex flex-col gap-1">                                        
                                        <?php if(!empty($post_title)): ?>
                                            <h1 class="carousel-content-title p-2 text-2xl md:text-4xl"><?php echo esc_html($post_title); ?></h1>
                                        <?php endif; ?>
                                        <?php if (!empty($post_excerpt)): ?>
                                            <p><?php echo esc_html($post_excerpt); ?></p>
                                        <?php endif; ?>
                                    </div>
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
