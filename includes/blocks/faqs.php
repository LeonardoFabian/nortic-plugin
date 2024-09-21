<?php

if (!function_exists('nortic_plugin_faqs_render_cb')) {
    function nortic_plugin_faqs_render_cb($atts)
    {
        $title = esc_html($atts['title']);

        $args = [
            'post_type' => 'faq',
            'posts_per_page' => $atts['count'],
            'orderby' => 'title',
            'order' => 'asc'
        ];

        $query = new WP_Query($args);

        ob_start();
?>

        <div <?php echo get_block_wrapper_attributes(); ?>>
            <!-- FAQs Section Start -->
            <section class="relative py-20 overflow-hidden bg-gray-50">
                <img class="absolute top-0 left-0 mt-44" src="<?php the_post_thumbnail('landscape'); ?>" alt="" />
                <div class="relative container px-4 mx-auto">
                    <div class="max-w-5xl mx-auto">
                        <div class="mb-24">
                            <span class="inline-block py-1 px-3 mb-4 text-xs font-semibold text-orange-900 bg-orange-50 rounded-full">
                                FREQUENTLY ASK QUESTION
                            </span>
                            <h2 class="font-heading text-5xl font-bold text-gray-900"><?php echo $title; ?></h2>
                        </div>
                        <div class="pt-16 sm:pt-24 px-8 pb-16 bg-white rounded-4xl shadow-lg text-left faq-container">
                            <?php if ($query->have_posts()) : ?>
                                <?php while ($query->have_posts()) : $query->the_post(); ?>
                                    <button class="flex items-start mb-8 pb-8 group w-full items-start justify-between border-b border-gray-100 text-left">
                                        <div class="max-w-xl pr-5">
                                            <a href="<?php the_permalink(); ?>">
                                                <h3 class="text-xl font-semibold text-orange-900 mb-3 faq-question">
                                                    <?php echo get_the_title(); ?>
                                                </h3>
                                            </a>
                                            <p class="text-lg text-gray-500 faq-answer">
                                                <?php the_content(); ?>
                                            </p>
                                        </div>
                                        <div class="pt-1">
                                            <span>
                                                <i class="bi bi-dash"></i>
                                            </span>
                                        </div>
                                    </button>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- FAQs Section End -->
        </div>

<?php
        wp_reset_postdata();

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
