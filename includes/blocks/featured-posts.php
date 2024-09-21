<?php 

if(!function_exists('nortic_plugin_featured_posts_render_cb')) {

    function nortic_plugin_featured_posts_render_cb($atts) {
        $category_Ids = array_map(function ($term) {
            return $term['id'];
        }, $atts['categories']);
        $post_type = 'post';
        $paged = get_query_var('paged');
        $item = 0;

        $args = [
            'post_type' => $post_type,
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'paged' => $paged
        ];

        if(!empty($category_Ids)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $category_Ids
                ]
                ];
        }

        $query = new WP_Query($args);

        ob_start();

        ?>

        <div class="wp-block-nortic-plugin-nortic-featured-posts">
            <div class="featured-posts-wrapper">
                <?php if($query->have_posts()) : ?>
                    <?php while($query->have_posts()) : $query->the_post(); ?>
                        <?php 
                            
                            $post_id = get_the_ID();
                            $post_permalink = get_the_permalink();
                            $post_title = get_the_title();
                            $formatted_date = get_the_date();
                            $iso_date = get_post_time('c', true);
                            $post_thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');
                            $categories = get_the_category();

                            // var_dump($categories);

                            $background_style = '';

                            if($item < 1) {
                                $truncated_title = nortic_truncate_string($post_title, 120);
                            } else {
                                $truncated_title = nortic_truncate_string($post_title, 60);
                            }
                     
                            if($post_thumbnail_url) {
                                $background_style = "background: linear-gradient(180deg, rgba(0, 56, 118, 0.1) 0%, rgba(0, 56, 118, 0.3) 25%, rgba(0, 56, 118, 0.5) 75%, rgba(0, 56, 118, 1) 100% ), url('$post_thumbnail_url') no-repeat center center/cover;";
                            }
                        ?>
                        <article id="featured-post-<?php echo $post_id; ?>" class="featured-posts-item featured-post-item-<?php echo $item; ?>" style="<?php echo $background_style; ?>">
                            <div class="featured-post-data">
                                <?php if(!empty($categories)) : ?>
                                    <ul class="featured-post-categories">
                                        <?php foreach($categories as $category) : ?>
                                            <?php 
                                                $category_link = get_category_link($category->term_id);    
                                            ?>
                                            <li class="featured-post-category category-<?php echo $category->term_id; ?>">
                                                <a href="<?php echo esc_url($category_link); ?>" role="link">
                                                    <span><?php echo esc_html($category->name); ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                                <h5>
                                    <a href="<?php echo $post_permalink ?>" role="link">
                                        <?php echo esc_html($truncated_title); ?>
                                    </a>
                                </h5>
                                <div class="featured-post-metadata">
                                    <time datetime="<?php echo esc_attr($iso_date); ?>">
                                    <i class="bi bi-calendar4-week"></i> <span><?php echo esc_html($formatted_date); ?></span>
                                    </time>
                                </div>
                            </div>
                        </article>

                        <?php $item++; ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php wp_reset_query(); ?>
                <?php endif; ?>
                
            </div>
        </div>

<?php 

        $output = ob_get_contents();
        ob_clean();

        return $output;
    }
}