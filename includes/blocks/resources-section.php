<?php

if (!function_exists('nortic_plugin_resources_section_render_cb')) {
    function nortic_plugin_resources_section_render_cb($atts)
    {
        $heading = $atts['heading'];
        $subheading = $atts['subheading'];
        $args = [
            'post_type' => 'resource',
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'paged' => get_query_var('paged')
        ];

        $query = new WP_Query($args);

        ob_start();

?>
        <!-- <section <?php echo get_block_wrapper_attributes(); ?>> -->
        <section class="wp-block-nortic-plugin-resources-section relative">

            <div class="resources-section-header">
                <h2 class="resources-section-heading">
                    <?php echo $heading; ?>
                </h2>
                <h4 class="resources-section-subheading">
                    <?php echo $subheading; ?>
                </h4>
            </div>

            <div class="resources-section-content-wrapper" data-glide-el="track">
                <ul class="glide__slides">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post(); ?>

                            <?php
                            $postId = get_the_ID();
                            ?>

                            <li class="max-w-sm bg-white flex flex-col justify-between">
                                <div class="text-center mb-6">
                                    <div class="service-card-image-wrapper text-center mb-6 h-72 overflow-hidden">
                                        <?php the_post_thumbnail('full', array('class' => '!w-full h-72 object-cover')); ?>
                                    </div>

                                    <p class="resources-section-title mb-2 text-left font-semibold whitespace-normal tracking-tight">
                                        <?php echo get_the_title(); ?>
                                    </p>
                                </div>
                                <div class="flex items-center justify-center">
                                    <a href="<?php the_permalink(); ?>" class="inline-flex font-medium items-center text-blue-600 hover:underline">
                                        <?php esc_html_e('View publication', 'nortic-plugin') ?>
                                        <svg class="w-3 h-3 ms-2.5 rtl:rotate-[270deg]" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11v4.833A1.166 1.166 0 0 1 13.833 17H2.167A1.167 1.167 0 0 1 1 15.833V4.167A1.166 1.166 0 0 1 2.167 3h4.618m4.447-2H17v5.768M9.111 8.889l7.778-7.778" />
                                        </svg>
                                    </a>
                                </div>
                            </li>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="flex items-center justify-center py-4">
                <a class="button button-primary inline-block gap-4" href="/recursos" target="_self">
                    <?php esc_html_e('View more', 'nortic-plugin'); ?> <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                    prev
                </button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                    next
                </button>
            </div>
        </section>
<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
