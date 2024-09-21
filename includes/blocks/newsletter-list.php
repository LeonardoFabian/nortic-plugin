<?php 

if(!function_exists('nortic_plugin_newsletter_list_render_cb')) {
    function nortic_plugin_newsletter_list_render_cb($atts) {        

        if(is_archive('newsletter')) {
            $title = isset($atts['title']) ? $atts['title'] : null;
            $columns = isset($atts['columns']) ? $atts['columns'] : 1;
            $items_per_page = isset($atts['itemsPerPage']) ? $atts['itemsPerPage'] : -1;
            $order_by = isset($atts['orderBy']) ? $atts['orderBy'] : 'date';
            $order = isset($atts['order']) ? $atts['order'] : 'desc';
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;

            
            $newsletter_categories = array_map( function ($term) {
                return $term['id'];
            }, $atts['newsletterCategories']);

            $args = [
                'post_type' => 'newsletter',
                'posts_per_page' => $items_per_page,
                'orderby' => $order_by,
                'order' => $order,
                'paged' => $paged
            ];

            if(!empty($newsletter_categories)) {
                $args['tax_query'] = [
                    [
                        'taxonomy' => 'newsletter_category',
                        'field' => 'term_id',
                        'terms' => $newsletter_categories
                    ]
                ];
            }

            $query = new WP_Query($args);

            ob_start();

            ?>

                <div class="wp-block-nortic-plugin-nortic-newsletter-list">
                    <div class="wp-block-nortic-plugin-nortic-newsletter-list-container">
                        <?php if(!empty($title)): ?>
                            <div class="wp-block-nortic-plugin-nortic-newsletter-list-header">
                                <h5><?php echo esc_html($title); ?></h5>
                            </div>
                        <?php endif; ?>
                        <ul class="wp-block-nortic-plugin-nortic-newsletter-list-wrapper">
                            <?php if($query->have_posts()) : ?>
                                <?php while($query->have_posts()) : $query->the_post(); ?>

                                    <?php 
                                        $newsletter_id = get_the_ID();
                                        $newsletter_title = get_the_title();
                                        $newsletter_cats = get_the_terms($newsletter_id, 'newsletter_category');
                                        $newsletter_cover_url = get_the_post_thumbnail_url($newsletter_id, 'full');
                                        $newsletter_permalink = get_the_permalink($newsletter_id);
                                        $dependency_id = get_post_meta($newsletter_id, 'dependency_id', true);

                                        $dependency_name = '';

                                        if(!empty($dependency_id)) {
                                            $dependency = get_post($dependency_id);
                                            if($dependency) {
                                                $dependency_name = get_the_title($dependency);
                                            }
                                        }

                                        // var_dump($newsletter_cats);
                                    ?>

                                    <li class="wp-block-nortic-plugin-nortic-newsletter-list-item newsletter-<?php echo esc_attr($newsletter_id); ?>">
                                        <div class="newsletter-list-item-img-container">
                                            <img src="<?php echo esc_url($newsletter_cover_url); ?>" alt="Cover image" />
                                        </div>
                                        <h6 class="newsletter-title">
                                            <a href="<?php echo esc_url($newsletter_permalink); ?>">
                                                <?php echo esc_html($newsletter_title); ?>
                                            </a>
                                        </h6>
                                        <div class="newsletter-meta">
                                            <?php foreach($newsletter_cats as $newsletter_cat) : ?>
                                                <span class="newsletter-category-name">
                                                    <?php echo esc_html($newsletter_cat->name); ?>
                                                </span>
                                            <?php endforeach; ?>                                         
                                            <?php if(!empty($dependency_name)): ?>
                                                <span class="newsletter-dependency-name">
                                                    <?php echo esc_html($dependency_name); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                
                                <?php  endwhile; ?>
                            <?php  endif; ?>
                        </ul>
                    </div>
                </div>

            <?php 

            $output = ob_get_contents();
            ob_get_clean();

            return $output;

        }
        
    }
}