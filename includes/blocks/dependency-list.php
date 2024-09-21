<?php 

if(!function_exists('nortic_plugin_dependency_list_render_cb')) {
    function nortic_plugin_dependency_list_render_cb($atts, $content, $block) {
        $postID = $block->context['postId'];
        $meta_key = 'parent_dependency_id';
        $meta_value = $postID;
        $paged = get_query_var('paged');
        $default_image_url = NORTIC_PLUGIN_URL . 'dist/public/images/placeholder.jpg';

        $args = array(
            'post_type' => 'dependency',
            'meta_query' => array(
                array(
                    'key' => $meta_key,
                    'value' => $meta_value,
                    'compare' => '='
                )
                ),
                'orderby' => 'post_title',
                'order' => 'asc',
                'posts_per_page' => -1,
            'paged' => $paged,
            'suppress_filters' => true  // Evita que otros filtros interfieran
            );

        $query = new WP_Query($args);

        // echo '<pre>';
        // var_dump($query);
        // echo '</pre>';

        ob_start();

?>
        <div class="wp-block-nortic-plugin-dependency-list">
            <div class="wp-block-nortic-plugin-dependency-list-header">
                <h5><?php echo esc_html__('Dependencies', 'nortic-plugin') ?></h5>
                <span>Total: <?php echo $query->post_count; ?></span>
            </div>
            <ul class="divide-y">
                <?php if($query->have_posts()) : ?>
                    <?php while($query->have_posts()) : $query->the_post(); ?>
                        <?php 
                            $post_id = get_the_ID();
                            $post_permalink = get_permalink();
                            $post_title = get_the_title();
                            $phone = get_post_meta($post_id, 'phone', true); 
                            
                            // count child dependencies
                            $count_args = array(
                                'post_type' => 'dependency',
                                'meta_query' => array(  
                                    array(
                                        'key' => 'parent_dependency_id',
                                        'value' => $post_id,
                                        'compare' => '='
                                    )
                                    ),
                                'posts_per_page' => -1,                               
                                'fields' => 'ids', // get only the IDs
                            );

                            $count_query = new WP_Query($count_args);
                            $dependency_childrens_count = $count_query->found_posts;
                         
                        ?>

                        <li id="dependency-<?php echo $post_id; ?>" class="dependency-list-item">
                            <span class="title">
                                <a href="<?php echo $post_permalink; ?>">
                                    <?php echo $post_title; ?>
                                </a>                                       
                            </span>
                            <?php if(!empty($phone)): ?> <span class="dependency-phone">Tel.: <?php echo esc_html($phone); ?> </span> <?php endif; ?>
                            
                        </li>
                    <?php endwhile; ?>
                    <?php
            if (function_exists('custom_pagination')) {
                custom_pagination($cat->max_num_pages, "", $paged);
            }
            ?>
                <?php else : ?>
                    <span>No se encontraron dependencias asociadas.</span>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
                <?php wp_reset_query(); ?>
            </ul>
        </div>

<?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;

    }
}