<?php 

if(!function_exists('nortic_plugin_service_list_render_cb_old')) {
    function nortic_plugin_service_list_render_cb_old($atts, $content, $block) {
        $postId = $block->context['postId'];
        $post_type = get_post_type_object(get_post_type($postId));
        $paged = get_query_var('paged');
        $list_classes = "grid-cols-" . $atts['columns'] . "";
        $use_default_title = $atts['use_default_title'];
        $heading = isset($atts['heading']) ? $atts['heading'] : "";
        $sub_heading = isset($atts['subHeading']) ? $atts['subHeading'] : "";
        $number_of_items = $atts['numberOfItems'];
        $filter_by_tags = $atts['filter_by_tags'];
        $service_tags_IDs = isset($atts['service_tags']) ? array_map('intval', $atts['service_tags']) : [];

        if(is_tax('service_classification')) {
            $tax_term = get_queried_object();
            $args = array(
                'post_type' => 'service',
                'posts_per_page' => $number_of_items,
                'orderby' => 'post_title',
                'order' => 'asc',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'service_classification',
                        'field' => 'term_id',
                        'terms' => $tax_term->term_id
                    )
                )
            );
        } elseif (is_tax('service_tag')) {
            $current_service_tag = get_queried_object();
            if($current_service_tag && !is_wp_error($current_service_tag)) {
                $args = array(
                    'post_type' => 'service',
                    'posts_per_page' => $number_of_items,
                    'orderby' => 'post_title',
                    'order' => 'asc',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'service_tag',
                            'field' => 'term_id',
                            'terms' => $current_service_tag->term_id
                        )
                    )
                );
            }
           

        } else {
            switch ($post_type->name) {
                case 'dependency':
                    $args = array(
                        'post_type' => 'service',
                        'posts_per_page' => $number_of_items,
                        'orderby' => 'post_title',
                        'order' => 'asc',
                        'meta_query' => array(
                            array(
                                'key' => 'service_dependency_id',
                                'value' => $postId,
                                'compare' => '='
                            ),
                        )
                    );
                break;
                
                default:
                    $args = array(
                        'post_type' => 'service',
                        'posts_per_page' => $number_of_items,
                        'orderby' => 'post_title',
                        'order' => 'asc'
                    );
                break;
            }
        }

        

        if($filter_by_tags && !empty($service_tags_IDs)) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'service_tag',
                    'field' => 'term_id',
                    'terms' => $service_tags_IDs
                )
            );
        }

        $query = new WP_Query($args);

        ob_start();

        ?>

        <div class="wp-block-nortic-plugin-service-list">
            <h5 class="service-list-heading">
                <?php 
                if($use_default_title) {
                    echo esc_html__('Our Services', 'nortic-plugin');
                } else {
                    echo esc_html($heading);
                } 
                ?>
            </h5>
            <?php if($sub_heading): ?>
                <h6 class="service-list-subheading"><?php echo esc_html($sub_heading); ?></h6>
            <?php endif; ?>

            <?php if($filter_by_tags && !empty($service_tags_IDs) ): ?>
                <?php foreach($service_tags_IDs as $service_tag_ID) : ?>
                    <?php 
                    $term = get_term($service_tag_ID, 'service_tag');
                    $term_link = get_term_link($term->term_id, 'service_tag');
                    if(!$term || is_wp_error($term)) continue;
                    ?>
                    <h6 class="service-list-taxonomy-heading">
                        <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>
                    </h6>
                    <?php 
                    $args = array_merge($args, [
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'service_tag',
                                'field' => 'term_id',
                                'terms' => $term->term_id
                            )
                        )
                    ]);
                    $query = new WP_Query($args);
                    ?>

                    <ul class="service-list-wrapper <?php echo esc_attr($list_classes); ?>">
                        <?php if($query->have_posts()) : ?>
                            <?php while($query->have_posts()) : $query->the_post(); ?>
                                <?php 
                                    $post_id = get_the_ID();
                                    $post_title = get_the_title();
                                    $post_permalink = get_the_permalink();
                                    $icon = get_post_meta($post_id, 'icon', true);
                                    $rating = get_post_meta($post_id, 'rating', true);
                                
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
                                    // var_dump($post_id);
                                ?>
                                
                                <li class="service-list-item service-list-item-<?php echo esc_attr($post_id); ?>">
                                    <?php if($icon) : ?>
                                        <?php echo wp_kses($icon, array(
                                            'i' => array(
                                                'class' => array(),
                                            )
                                        )); ?>
                                    <?php else : ?>
                                        <i class="bi bi-briefcase"></i>
                                    <?php endif; ?>
                                    <span>
                                        <h6 class="service-list-item-title">
                                            <a href="<?php echo esc_url($post_permalink); ?>">
                                                <?php echo esc_html($post_title);  ?>
                                            </a>
                                        </h6>
                                        <span class="service-list-rating rounded-full ml-auto text-md font-medium">
                                        <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>
                                        
                                        <ul>                                    
                                                <?php foreach ($star_classes as $class) : ?>
                                                    <li><i class="bi <?php echo $class; ?>"></i></li>
                                                <?php endforeach; ?>                          
                                            </ul>
                                        </span>
                                    </span>
                                </li>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                <?php endforeach; ?>

                <!-- group service without tags -->
                 <?php 
                    $no_tag_args = array_merge($args, [
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'service_tag',
                                'operator' => 'NOT EXISTS'
                            ),
                        )
                    ]);
                    $no_tag_query = new WP_Query($no_tag_args);
                ?>
                <?php if($no_tag_query->have_posts()): ?>
                    <h6 class="service-list-taxonomy-heading">
                        <?php echo esc_html__('Others', 'nortic-plugin'); ?>
                    </h6>
                    <ul class="service-list-wrapper <?php echo esc_attr($list_classes); ?>">                 
                        <?php while($no_tag_query->have_posts()) : $no_tag_query->the_post(); ?>
                            <?php 
                                $post_id = get_the_ID();
                                $post_title = get_the_title();
                                $post_permalink = get_the_permalink();
                                $icon = get_post_meta($post_id, 'icon', true);
                                $rating = get_post_meta($post_id, 'rating', true);
                            
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
                                // var_dump($post_id);
                            ?>
                            
                            <li class="service-list-item service-list-item-<?php echo esc_attr($post_id); ?>">
                                <?php if($icon) : ?>
                                    <?php echo wp_kses($icon, array(
                                        'i' => array(
                                            'class' => array(),
                                        )
                                    )); ?>
                                <?php else : ?>
                                    <i class="bi bi-briefcase"></i>
                                <?php endif; ?>
                                <span>
                                    <h6 class="service-list-item-title">
                                        <a href="<?php echo esc_url($post_permalink); ?>">
                                            <?php echo esc_html($post_title);  ?>
                                        </a>
                                    </h6>
                                    <span class="service-list-rating rounded-full ml-auto text-md font-medium">
                                    <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>
                                    
                                    <ul>                                    
                                            <?php foreach ($star_classes as $class) : ?>
                                                <li><i class="bi <?php echo $class; ?>"></i></li>
                                            <?php endforeach; ?>                          
                                        </ul>
                                    </span>
                                </span>
                            </li>
                        <?php endwhile; ?>                       
                    </ul>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            <?php elseif($filter_by_tags && empty($service_tag_IDs)): ?>
                <?php 
                $all_service_tags = get_terms(array(
                    'taxonomy' => 'service_tag',
                    'hide_empty' => true
                ));
                ?>
                <?php if(!empty($all_service_tags) && !is_wp_error($all_service_tags)): ?>
                    <?php foreach($all_service_tags as $term) : ?> 
                        <?php 
                        // var_dump($term);
                        $term_link = get_term_link($term->term_id, 'service_tag');    
                        ?>                     
                        <h6 class="service-list-taxonomy-heading">
                        <a href="<?php echo esc_url($term_link); ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                        </h6>
                        <?php 
                        $args = array_merge($args, [
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'service_tag',
                                    'field' => 'term_id',
                                    'terms' => $term->term_id
                                )
                            )
                        ]);
                        $query = new WP_Query($args);
                        ?>

                        <ul class="service-list-wrapper <?php echo esc_attr($list_classes); ?>">
                            <?php if($query->have_posts()) : ?>
                                <?php while($query->have_posts()) : $query->the_post(); ?>
                                    <?php 
                                        $post_id = get_the_ID();
                                        $post_title = get_the_title();
                                        $post_permalink = get_the_permalink();
                                        $icon = get_post_meta($post_id, 'icon', true);
                                        $rating = get_post_meta($post_id, 'rating', true);
                                    
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
                                        // var_dump($post_id);
                                    ?>
                                    
                                    <li class="service-list-item service-list-item-<?php echo esc_attr($post_id); ?>">
                                        <?php if($icon) : ?>
                                            <?php echo wp_kses($icon, array(
                                                'i' => array(
                                                    'class' => array(),
                                                )
                                            )); ?>
                                        <?php else : ?>
                                            <i class="bi bi-briefcase"></i>
                                        <?php endif; ?>
                                        <span>
                                            <h6 class="service-list-item-title">
                                                <a href="<?php echo esc_url($post_permalink); ?>">
                                                    <?php echo esc_html($post_title);  ?>
                                                </a>
                                            </h6>
                                            <span class="service-list-rating rounded-full ml-auto text-md font-medium">
                                            <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>
                                            
                                            <ul>                                    
                                                    <?php foreach ($star_classes as $class) : ?>
                                                        <li><i class="bi <?php echo $class; ?>"></i></li>
                                                    <?php endforeach; ?>                          
                                                </ul>
                                            </span>
                                        </span>
                                    </li>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </ul>
                        <?php wp_reset_postdata(); ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <!-- group service without tags -->
                 <?php 
                    $no_tag_args = array_merge($args, [
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'service_tag',
                                'operator' => 'NOT EXISTS'
                            )
                        )
                    ]);
                    $no_tag_query = new WP_Query($no_tag_args);
                ?>
                <?php if($no_tag_query->have_posts()): ?>
                    <h6 class="service-list-taxonomy-heading">
                        <?php echo esc_html__('Others', 'nortic-plugin'); ?>
                    </h6>
                    <ul class="service-list-wrapper <?php echo esc_attr($list_classes); ?>">                 
                        <?php while($no_tag_query->have_posts()) : $no_tag_query->the_post(); ?>
                            <?php 
                                $post_id = get_the_ID();
                                $post_title = get_the_title();
                                $post_permalink = get_the_permalink();
                                $icon = get_post_meta($post_id, 'icon', true);
                                $rating = get_post_meta($post_id, 'rating', true);
                            
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
                                // var_dump($post_id);
                            ?>
                            
                            <li class="service-list-item service-list-item-<?php echo esc_attr($post_id); ?>">
                                <?php if($icon) : ?>
                                    <?php echo wp_kses($icon, array(
                                        'i' => array(
                                            'class' => array(),
                                        )
                                    )); ?>
                                <?php else : ?>
                                    <i class="bi bi-briefcase"></i>
                                <?php endif; ?>
                                <span>
                                    <h6 class="service-list-item-title">
                                        <a href="<?php echo esc_url($post_permalink); ?>">
                                            <?php echo esc_html($post_title);  ?>
                                        </a>
                                    </h6>
                                    <span class="service-list-rating rounded-full ml-auto text-md font-medium">
                                    <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>
                                    
                                    <ul>                                    
                                            <?php foreach ($star_classes as $class) : ?>
                                                <li><i class="bi <?php echo $class; ?>"></i></li>
                                            <?php endforeach; ?>                          
                                        </ul>
                                    </span>
                                </span>
                            </li>
                        <?php endwhile; ?>                       
                    </ul>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            <?php else : ?>
                <ul class="service-list-wrapper <?php echo esc_attr($list_classes); ?>">
                    <?php if($query->have_posts()) : ?>
                        <?php while($query->have_posts()) : $query->the_post(); ?>
                            <?php 
                                $post_id = get_the_ID();
                                $post_title = get_the_title();
                                $post_permalink = get_the_permalink();
                                $icon = get_post_meta($post_id, 'icon', true);
                                $rating = get_post_meta($post_id, 'rating', true);
                                
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
                            <li class="service-list-item service-list-item-<?php echo esc_attr($post_id); ?>">
                                <?php if($icon) : ?>
                                    <?php echo wp_kses($icon, array(
                                        'i' => array(
                                            'class' => array(),
                                        )
                                    )); ?>
                                <?php else : ?>
                                    <i class="bi bi-briefcase"></i>
                                <?php endif; ?>
                                <span>
                                    <h6 class="service-list-item-title">
                                        <a href="<?php echo esc_url($post_permalink); ?>">
                                            <?php echo esc_html($post_title);  ?>
                                        </a>
                                    </h6>
                                    <span class="service-list-rating rounded-full ml-auto text-md font-medium">
                                    <span><?php echo number_format((float)$rating, 1, '.', ''); ?></span>

                                            <ul>                                    
                                                <?php foreach ($star_classes as $class) : ?>
                                                    <li><i class="bi <?php echo $class; ?>"></i></li>
                                                <?php endforeach; ?>                          
                                            </ul>
                                        </span>
                                </span>
                            </li>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>

        <?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;

        
    }
}