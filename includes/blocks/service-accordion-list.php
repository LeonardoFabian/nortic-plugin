<?php

if (!function_exists('nortic_plugin_service_accordion_list_render_cb')) {
    function nortic_plugin_service_accordion_list_render_cb($atts)
    {
        $paged = get_query_var('paged');

        $serviceClassificationIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['terms']);

        $term_id = get_queried_object()->term_id;

        $args = [
            'post_type' => 'service',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => 'ASC',
            'paged' => $paged
        ];

        if (!empty($term_id)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => $atts['taxonomy'],
                    'field' => 'term_id',
                    'terms' => $term_id
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();

?>

        <div class="component-services-accordion-list">
            <section class="services-accordion-section">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="service-accordion py-2 border-b border-slate-300">
                            <!-- <i class="fa-solid fa-caret-right"></i> -->
                            <div class="service-accordion-toggle-button flex items-center py-2">
                                <!-- <span class="h-2.5 w-2.5 text-blue-900 flex items-center mr-3">
                                    <svg class="text-blue-900" fill="#003876" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512">
                                        <path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z" />
                                    </svg>
                                </span> -->
                                <!-- <i class="fa-solid fa-caret-down"></i> -->
                                <span class="service-accordion-toggle-icon dashicons dashicons-arrow-right"></span>
                                
                                <a href="<?php the_permalink(); ?>"><h6 class="service-accordion-title font-medium"><?php echo get_the_title(); ?></h6></a>
                            </div>
                         
                        </div>
                    <?php endwhile; ?>
                    <?php
            if (function_exists('custom_pagination')) {
                custom_pagination($cat->max_num_pages, "", $paged);
            }
            ?>
                <?php else : ?>
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                        <div class="flex">
                            <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                </svg></div>
                            <div>
                                <p class="font-bold"><?php esc_html_e('No posts found!') ?></p>
                                <p class="text-sm">Por el momento no existen publicaciones con esta categoría.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
                <?php wp_reset_query(); ?>
            </section>
        </div>

<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
