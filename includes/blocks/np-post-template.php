<?php

if (!function_exists('nortic_plugin_post_template_render_cb')) {
    function nortic_plugin_post_template_render_cb($atts)
    {
        $title = esc_html($atts['title']);
        $description = esc_html($atts['description']);
        $categoryIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['categories']);
        $postType = nortic_plugin_get_archive_post_type();

        if (!$postType) {
            $postType = 'post';
        }


        $args = [
            'post_type' => $postType,
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order']
        ];


        // $args = [
        //     'posts_per_page' => $atts['count'],
        //     'post_status' => 'publish'
        // ];

        $latest_posts = get_posts($args);

        if (!empty($categoryIDs)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field' => 'term_id',
                    'terms' => $categoryIDs
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
?>

        <div <?php echo get_block_wrapper_attributes(); ?>>
            <!-- Blog Section Start -->
            <section class="pt-20 pb-10">
                <div class="container mx-auto">
                    <div class="flex flex-wrap justify-center">
                        <div class="w-full px-4">
                            <?php if ($title) : ?>
                                <div class="text-center mx-auto">
                                    <h2 class="font-bold text-3xl text-dark mb-4"><?php echo $title; ?></h2>
                                </div>
                            <?php endif; ?>
                            <?php if ($description) : ?>
                                <div class="text-center mx-auto">
                                    <?php echo $description; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="flex flex-wrap latest-post-container">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>
                                <?php
                                $post_id = get_the_ID();
                                $cats = get_the_category($post_id);
                                ?>
                                <article id="post-<?php echo $post_id; ?>" class="col-<?php echo $atts['columns'] ?> nortic-plugin__post shadow-md" data-aos="fade-up" data-aos-duration="3000">
                                    <div class="mx-auto mb-10">
                                        <?php if ($atts['displayFeaturedImage']) : ?>
                                            <div class="rounded overflow-hidden mb-4">

                                                <a class="nortic-plugin__single_post--image" href="<?php the_permalink(); ?>">
                                                    <?php the_post_thumbnail('landscape') ?>
                                                </a>

                                            </div>
                                        <?php endif; ?>
                                        <div class="latest-posts-content flex flex-col justify-between px-4">

                                            <div class="latest-posts-data">
                                                <h3 class="latest-posts-title">
                                                    <a href="<?php the_permalink(); ?>" class="font-semibold text-sm mb-2 inline-block <?php echo $postType != 'post' ? 'text-gray-900' : ''; ?>">
                                                        <?php the_title(); ?>
                                                    </a>
                                                </h3>
                                                <!-- <div class="flex items-center">
                                                    <?php foreach ($cats as $cat) : ?>
                                                        <?php $catPermalink = get_category_link($cat); ?>
                                                        <a class="latest-posts-cats mr-4 text-sm" href="<?php echo $catPermalink; ?>"><?php echo $cat->cat_name; ?></a>

                                                    <?php endforeach; ?>
                                                </div> -->
                                            </div>
                                            <?php if ($postType == 'post') : ?>
                                                <div class="latest-posts-footer flex items-center justify-between flex-1 mt-auto">
                                                    <time datetime="<?php esc_attr(get_the_date('c', $post_id)); ?>" class="latest-posts-date text-sm text-body-color">
                                                        <?php echo esc_html(get_the_date('', $post_id)); ?>
                                                    </time>
                                                    <span class="latest-posts-comments-number text-sm"><?php echo get_comments_number(); ?><i class="bi bi-chat ml-2"></i></span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </article>
                            <?php endwhile; ?>

                        <?php endif; ?>
                    </div>

                    <!-- view more link -->
                    <?php if (is_home() || is_front_page()) : ?>

                        <div class="text-center">
                            <h4 class="view-more"> <a href="<?php echo get_post_type_archive_link($postType); ?>"><?php esc_html_e('View more', 'nortic-plugin') ?></a></h4>
                        </div>
                    <?php endif; ?>
                    <!-- END view more link -->
                </div>
            </section>
            <!-- Blog Section End -->
        </div>

<?php
        wp_reset_postdata();

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
