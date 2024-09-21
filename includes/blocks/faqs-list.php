<?php

if (!function_exists('nortic_plugin_faqs_list_render_cb')) {
    function nortic_plugin_faqs_list_render_cb($atts, $content, $block)
    {
        $postID = $block->context['postId'];
        $use_default_title = $atts['use_default_title'];
        $title = $atts['title'];
        $post_type = get_post_type_object(get_post_type($postID));


        if($use_default_title) {
            $title = __('Frequently asked questions', 'nortic-plugin');
        }

        $categoriesID = array_map(function ($term) {
            return $term['id'];
        }, $atts['categories']);

        switch ($post_type->name) {
            case "service":
                $args = array(
                    'post_type' => 'faq',
                    'posts_per_page' => $atts['count'],
                    'orderby' => $atts['orderBy'],
                    'order' => $atts['order'],
                    'meta_query' => array(                  
                        array(
                            'key' => 'faq_service_id',
                            'value' => $postID,
                            'compare' => '='
                        ),
                    )
                );
                break;
            
            case 'dependency':
                $args = array(
                    'post_type' => 'faq',
                    'posts_per_page' => $atts['count'],
                    'orderby' => $atts['orderBy'],
                    'order' => $atts['order'],
                    'meta_query' => array(                  
                        array(
                            'key' => 'faq_dependency_id',
                            'value' => $postID,
                            'compare' => '='
                        ),
                    )
                );
                break;
            
            default:
                $args = [
                    'post_type' => 'faq',
                    'posts_per_page' => $atts['count'],
                    'orderby' => $atts['orderBy'],
                    'order' => $atts['order']
                ];
                break;
        }


        
        // var_dump($post_type->name);

        if (!empty($categoriesID)) {
            $args['tax_query'] = [
                'taxonomy' => 'faq_category',
                'field' => 'term_id',
                'terms' => $categoriesID
            ];
        }            

        $query = new WP_Query($args);

        ob_start();
?>
        <section class="wp-block-nortic-plugin-faqs-list">
       
                <h5 class="mb-4"><i class="bi bi-question-circle-fill text-2xl mr-2"></i> <?php echo esc_html($title); ?></h5>

                <div class="faqs-container">

                    <?php

                    if ($query->have_posts()) :

                        while ($query->have_posts()) :

                            $query->the_post();

                    ?>
                        <?php 
                            $post_id = get_the_ID();
                        ?>

                           
                                <article id="faq-<?php echo $post_id; ?>" class="accordion faq-item">
                                    <div class="faq-item-header accordion-header py-8 px-8 cursor-pointer <?php echo $query->current_post == 0 ? "active" : "";  ?>">
                                        <button class="flex items-center justify-between text-left w-full gap-6">
                                            <a class="faq-title">
                                                <?php echo strip_tags(get_the_title()); ?>
                                            </a>

                                            <span class="faq-icon-wrapper">
                                                <i class="accordion-icon faq-icon bi text-xl font-semibold"></i>
                                            </span>
                                        </button>
                                    </div>

                                    <div class="faq-item-body accordion-body overflow-hidden transition-all duration-200 ease-out" style="max-height: 0px;">
                                        <div class="px-8 pb-8 pt-0">
                                            <p class="color-dark-gray">
                                                <?php echo strip_tags(get_the_excerpt()); ?>
                                            </p>
                                        </div>

                                        <div class="pb-8 text-left">
                                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="button button-link"> <?php esc_html_e('Read More', 'nortic-plugin') ?></a>
                                        </div>
                                    </div>
                                </article>
                           
                    <?php

                        endwhile;
                    endif;

                    wp_reset_postdata();

                    ?>

                </div>
           
        </section>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
