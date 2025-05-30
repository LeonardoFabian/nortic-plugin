<?php

if (!function_exists('nortic_plugin_newsletters_section_render_cb')) {
    function nortic_plugin_newsletters_section_render_cb($atts)
    {
        $heading = $atts['heading'];
        $subheading = $atts['subheading'];
        $args = [
            'post_type' => 'newsletter',
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'paged' => get_query_var('paged')
        ];

        $query = new WP_Query($args);

        ob_start();

?>
        <!-- <section <?php echo get_block_wrapper_attributes(); ?>> -->
        <section class="wp-block-nortic-plugin-newsletters-section relative">

            <div class="newsletters-section-header">
                <h2 class="newsletters-section-heading">
                    <?php echo $heading; ?>
                </h2>
                <h4 class="newsletters-section-subheading">
                    <?php echo $subheading; ?>
                </h4>
            </div>

            <div class="newsletters-section-content-wrapper" data-glide-el="track">
                <ul class="glide__slides">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post(); ?>

                            <?php
                            $postId = get_the_ID();
                            $newsletter_image_url = get_the_post_thumbnail_url($postId, 'full');
                            $newsletter_title = get_the_title();
                            $newsletter_link = get_the_permalink();
                            ?>

                            <li class="max-w-sm bg-white flex flex-col justify-between">
                                <div class="text-center">
                                    <div class="newsletter-image-wrapper text-center mb-6">
                                        <img src="<?php echo $newsletter_image_url; ?>" alt="<?php echo esc_html__('newsletter cover', 'nortic-plugin'); ?>">
                                    </div>

                                    <p class="newsletters-section-title text-left font-semibold whitespace-normal tracking-tight">
                                        <a href="<?php echo esc_url($newsletter_link); ?>" title="<?php echo esc_attr($newsletter_title); ?>">
                                            <?php echo esc_html($newsletter_title); ?>
                                        </a>
                                    </p>
                                </div>                                
                            </li>

                        <?php endwhile; ?>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="flex items-center justify-center py-4">
                <a class="button button-primary inline-block gap-4" href="/publicaciones" target="_self">
                    <?php esc_html_e('View more', 'nortic-plugin'); ?> <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <!-- <div class="glide__arrows" data-glide-el="controls">
                <button class="glide__arrow glide__arrow--left" data-glide-dir="<">
                    prev
                </button>
                <button class="glide__arrow glide__arrow--right" data-glide-dir=">">
                    next
                </button>
            </div> -->
        </section>
<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
