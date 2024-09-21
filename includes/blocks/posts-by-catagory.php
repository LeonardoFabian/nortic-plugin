<?php 

if(!function_exists('nortic_plugin_posts_by_category_render_cb')) {
    function nortic_plugin_posts_by_category_render_cb($atts) {

        if($atts['useTemplateQuery']) {
            $current_category = get_queried_object();
            $categories_Ids = [$current_category->term_id];
        } else {
            $categories_Ids = array_map(function ($term) {
                return $term['id'];
            }, $atts['categories']);
        }
        
        $post_type = 'post';
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        $item = 0;

        $args = [
            'post_type' => $post_type,
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'paged' => $paged
        ];

        if(!empty($categories_Ids)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $categories_Ids
                ]
                ];
        }

        $query = new WP_Query($args);

    ob_start();
?>

    <div class="wp-block-nortic-plugin-nortic-posts-by-category">
        <?php if($categories_Ids) : ?>
            <!-- <?php var_dump("Categories: ", $categories_Ids) ?> -->
            <div class="posts-by-category-header">
                <ul>
                    <?php foreach($categories_Ids as $category_Id): ?>
                        <?php 
                            $category = get_category($category_Id); 

                            if($category) {
                                $category_permalink = get_category_link($category_Id);   
                            }
                            // var_dump($category->name);
                        ?>
                        <li>
                            <span>
                                <a href="<?php echo esc_url($category_permalink); ?>" role="link"><?php echo esc_html($category->name); ?></a>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="posts-by-category-wrapper">
                <?php if($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                    <?php 
                            
                            $post_id = get_the_ID();
                            $post_permalink = get_the_permalink();
                            $post_title = get_the_title();
                            $formatted_date = get_the_date();
                            $iso_date = get_post_time('c', true);
                            $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');                      
                            $post_thumbnail_alt = esc_html__('Post featured media', 'nortic-plugin');
                       
                            if($item < 1) {
                                $truncated_title = nortic_truncate_string($post_title, 120);
                                $truncated_excerpt = nortic_truncate_string(get_the_excerpt(), 230);
                            } else {
                                $truncated_title = nortic_truncate_string($post_title, 75);
                                $truncated_excerpt = nortic_truncate_string(get_the_excerpt(), 80);
                            }                            
                        ?>
                        <article id="post-by-category-<?php echo $post_id; ?>" class="post-by-category-item post-by-category-item-<?php echo $item; ?>">
                            <div class="post-by-category-image-wrapper">
                                <img src="<?php echo esc_url($post_thumbnail_url); ?>" alt="<?php echo $post_thumbnail_alt; ?>" />
                            </div>
                            <div class="post-by-category-data">
                                <h6>
                                    <a href="<?php echo esc_url($post_permalink); ?>">
                                        <?php echo esc_html($truncated_title); ?>
                                    </a>
                                </h6>
                                <div class="post-by-category-metadata">
                                    <time datetime="<?php echo esc_attr($iso_date); ?>">
                                        <i class="bi bi-calendar4-week"></i> <span><?php echo esc_html($formatted_date); ?></span>
                                    </time>
                                </div>
                                <div class="post-by-category-excerpt">
                                    <p><?php esc_html($truncated_excerpt); ?></p>
                                </div>

                            </div>
                        </article>
                        <?php $item++; ?>

                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

<?php 
    $output = ob_get_contents();
    ob_end_clean();

    return $output;

    }
}