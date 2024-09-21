<?php 

if (!function_exists('nortic_plugin_service_list_render_cb')) {
    function nortic_plugin_service_list_render_cb($atts, $content, $block) {
        $postId = $block->context['postId'];
        $post_type = get_post_type_object(get_post_type($postId));
        $paged = get_query_var('paged');
        $list_classes = "grid-cols-" . $atts['columns'];
        $use_default_title = $atts['use_default_title'];
        $heading = isset($atts['heading']) ? $atts['heading'] : "";
        $sub_heading = isset($atts['subHeading']) ? $atts['subHeading'] : "";
        $number_of_items = $atts['numberOfItems'];
        $filter_by_tags = $atts['filter_by_tags'];
        $service_tags_IDs = isset($atts['service_tags']) ? array_map('intval', $atts['service_tags']) : [];

        ob_start(); // Iniciamos la captura de salida

         if (is_tax('service_classification')) {
            
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
            if ($filter_by_tags && !empty($service_tags_IDs)) {
                $args['tax_query'][] = array(
                    array(
                        'taxonomy' => 'service_tag',
                        'field' => 'term_id',
                        'terms' => $service_tags_IDs
                    )
                );
            }

            $query = new WP_Query($args); 

            if($filter_by_tags && empty($service_tags_IDs)) {

             
                    $all_service_tags = get_terms(array(
                        'taxonomy' => 'service_tag',
                        'hide_empty' => true
                    ));
                    if(!empty($all_service_tags) && !is_wp_error($all_service_tags)) {
                        foreach($all_service_tags as $term) {
                            $term_link = get_term_link($term->term_id, 'service_tag'); 
                            ?>
                            <h5>
                                <a href="<?php echo esc_url($term_link); ?>">
                                    <?php echo esc_html($term->name); ?>
                                </a>
                            </h5>
                            <?php
                            render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags); 
                        }
                
                    }
                 
            
                
                // Servicios sin etiquetas
                $no_tag_args = array_merge($args, array(
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'service_tag',
                            'operator' => 'NOT EXISTS'
                        ),
                        array(
                            'taxonomy' => 'service_classification',
                            'field' => 'term_id',
                            'terms' => $tax_term->term_id
                        )
                    )
                ));
                $no_tag_query = new WP_Query($no_tag_args);

            }

            if ($no_tag_query->have_posts()) {
                ?>
                    <h6 class="service-list-taxonomy-heading"><?php echo esc_html__('Others', 'nortic-plugin'); ?></h6>
                    
                    <?php
                    render_service_list($no_tag_query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags); 

            } elseif(is_tax('service_tag')) {
                
                        $tax_term = get_queried_object();
                        if ($tax_term && !is_wp_error($tax_term)) {
                            $args = array(
                                'post_type' => 'service',
                                'posts_per_page' => $number_of_items,
                                'orderby' => 'post_title',
                                'order' => 'asc',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'service_tag',
                                        'field' => 'term_id',
                                        'terms' => $tax_term->term_id
                                    )
                                )
                            );
                            
                            $query = new WP_Query($args);
                            render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags);
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
                                    'order' => 'asc',
                                    
                                );
                    
                                break;
                        }

                        $query = new WP_Query($args);
                        render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags);
                    }

        } else if(is_tax('service_tag')) {
            $tax_term = get_queried_object();
            if ($tax_term && !is_wp_error($tax_term)) {
                $args = array(
                    'post_type' => 'service',
                    'posts_per_page' => $number_of_items,
                    'orderby' => 'post_title',
                    'order' => 'asc',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'service_tag',
                            'field' => 'term_id',
                            'terms' => $tax_term->term_id
                        )
                    )
                );
                $query = new WP_Query($args);
                render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags);
            }
        } else {
            switch($post_type->name) {
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
                    $query = new WP_Query($args);
                    render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags);
                break;
                case 'service':
                    $args = array(
                        'post_type' => 'service',
                        'posts_per_page' => $number_of_items,
                        'orderby' => 'post_title',
                        'order' => 'asc',
                    );
                    if($filter_by_tags) {
                        if(!empty($service_tags_IDs)) {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'service_tag',    
                                    'field' => 'term_id',
                                    'terms' => $service_tags_IDs
                                )
                            );
                        } else {
                            $args['tax_query'] = array(
                                array(
                                    'taxonomy' => 'service_tag',
                                    'operator' => 'NOT EXISTS'
                                )
                            );
                        }
                    }
                    $query = new WP_Query($args);
                    render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags);    
            
                break;  
                default:
                    $args = array(  
                        'post_type' => 'service',
                        'posts_per_page' => $number_of_items,   
                        'orderby' => 'post_title',
                        'order' => 'asc',
                    );
                break;
            }
           
        }  

        wp_reset_postdata(); // Restablecer los datos de la consulta
        return ob_get_clean(); // Retornamos la salida capturada
    }
    

    function render_service_list($query, $use_default_title, $heading, $sub_heading, $list_classes, $filter_by_tags) {
        if ($query->have_posts()) {
            echo '<div class="wp-block-nortic-plugin-service-list">';
            echo '<h5 class="service-list-heading">';
            if ($use_default_title && !$filter_by_tags) {
                echo esc_html__('Our Services', 'nortic-plugin');
            } else {
                echo esc_html($heading);
            }
            echo '</h5>';
            
            if ($sub_heading) {
                echo '<h6 class="service-list-subheading">' . esc_html($sub_heading) . '</h6>';
            }
            
            echo '<ul class="service-list-wrapper ' . esc_attr($list_classes) . '">';

            while ($query->have_posts()) {
                $query->the_post();
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

                echo '<li class="service-list-item service-list-item-' . esc_attr($post_id) . '">';
                if ($icon) {
                    echo wp_kses($icon, array('i' => array('class' => array())));
                } else {
                    echo '<i class="bi bi-briefcase"></i>';
                }
                echo '<span>';
                echo '<h6 class="service-list-item-title">';
                echo '<a href="' . esc_url($post_permalink) . '">' . esc_html($post_title) . '</a>';
                echo '</h6>';
                echo '<span class="service-list-rating rounded-full ml-auto text-md font-medium">';
                echo '<span>' . number_format((float)$rating, 1, '.', '') . '</span>';
                echo '<ul>';
                foreach ($star_classes as $class) {
                    echo '<li><i class="bi ' . esc_attr($class) . '"></i></li>';
                }
                echo '</ul>';
                echo '</span>';
                echo '</span>';
                echo '</li>';
            }

            echo '</ul>';
            echo '</div>';
        }
    }
}


