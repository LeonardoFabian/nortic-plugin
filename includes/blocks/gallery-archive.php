<?php

if (!function_exists('nortic_plugin_gallery_archive_render_cb')) {
    function nortic_plugin_gallery_archive_render_cb($atts)
    {
        $postType = 'gallery';

        $args = [
            'post_type'     => $postType,
            'posts_per_page'    => $atts['count'],
            'orderby'           => 'date',
            'order'             => 'desc'
        ];

        $query = new WP_Query($args);

        ob_start();
?>
        <div class="wp-block-nortic-plugin-gallery-archive">
            <div class="nortic-plugin-gallery-archive-wrapper container mx-auto mb-8 grid-cols-4 md:grid-cols-3 gap-4">
                <?php if ($query->have_posts()) : ?>
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <?php $post_id = get_the_ID(); ?>
                        <div id="nortic-gallery-<?php echo $post_id; ?>" class="nortic-plugin-gallery-archive-item rounded-lg overflow-hidden mb-4 <?php echo $query->current_post % 3 == 0 ? 'col-span-2 row-span-2' : ''; ?>" data-aos="zoom-in" data-aos-duration="3000">
                            <figure>
                                <?php the_post_thumbnail('full'); ?>
                                <figcaption>
                                    <div class="flex flex-col items-center justify-center">

                                        <h3 class="text-center">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_title(); ?>
                                            </a>
                                        </h3>

                                        <time datetime="<?php esc_attr(get_the_date('c', $post_id)); ?>">
                                            <?php echo esc_html(get_the_date('', $post_id)); ?>
                                        </time>
                                    </div>
                                </figcaption>
                            </figure>
                        </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
<?php
        wp_reset_postdata();

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
