<?php

if (!function_exists('nortic_plugin_latest_posts_render_cb')) {
    function nortic_plugin_latest_posts_render_cb($atts)
    {
        if($atts['useTemplateQuery']) {
            $current_category = get_queried_object();
            $categories_Ids = [$current_category->term_id];
        } else {
            $categories_Ids = array_map(function ($term) {
                return $term['id'];
            }, $atts['categories']);
        }

        $postType = nortic_plugin_get_archive_post_type();
        $title = esc_html($atts['title']);
        $description = esc_html($atts['description']);
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;

        if (!$postType) {
            $postType = 'post';
        }

        $args = [
            'post_type' => $postType,
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'paged' => $paged
        ];


        // $args = [
        //     'posts_per_page' => $atts['count'],
        //     'post_status' => 'publish'
        // ];

        // $latest_posts = get_posts($args);

        if (!empty($categories_Ids)) {
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

        <div class="wp-block-nortic-plugin-nortic-latest-posts">
            <!-- Blog Section Start -->
            <section class="posts-container">


                <div class="flex flex-wrap latest-post-container">
                    <?php if ($query->have_posts()) : ?>
                        <?php while ($query->have_posts()) : $query->the_post(); ?>
                            <?php
                            $postID = get_the_ID();
                            $cats = get_the_category($postID);
                            $terms = get_the_terms($postID, 'category');

                            // var_dump($terms);

                            $categoryColor = get_term_meta($terms[0]->term_id, 'taxonomy_color', true);
                            ?>
                            <!-- <article id="post-<?php echo $postID; ?>" class="col-<?php echo $atts['columns']; ?> nortic-plugin__post shadow-md relative" data-aos="fade-up" data-aos-duration="3000" style="border-top: 5px solid <?php echo (!empty($categoryColor)) ? $categoryColor : "#707070"; ?>;"> -->
                            <article id="post-<?php echo $postID; ?>" class="col-<?php echo $atts['columns']; ?> nortic-plugin__post relative" style="border-top: 5px solid <?php echo (!empty($categoryColor)) ? $categoryColor : "#707070"; ?>;">


                                <?php foreach ($cats as $cat) : ?>
                                    <?php $catPermalink = get_category_link($cat); ?>
                                    <a class="latest-posts-cats text-sm -top-4 z-20 flex items-center justify-center" href="<?php echo $catPermalink; ?>">
                                        <span class="text-white color-white text-xs font-medium mr-2 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300 absolute -top-4 z-20 whitespace-nowrap" style="background-color: <?php echo (!empty($categoryColor)) ? $categoryColor : "#707070"; ?>;">
                                            <?php echo $cats[0]->name; ?>
                                        </span>
                                    </a>

                                <?php endforeach; ?>

                                <div class="mx-auto">
                                    <?php if ($atts['displayFeaturedImage']) : ?>
                                        <div class="overflow-hidden">

                                            <a class="nortic-plugin__single_post--image" href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('landscape') ?>
                                            </a>

                                        </div>
                                    <?php endif; ?>
                                    <div class="latest-posts-content my-4 flex flex-col justify-between">

                                        <div class="latest-posts-data">
                                            <h3 class="latest-posts-title">
                                                <a href="<?php the_permalink(); ?>" class="font-semibold text-sm mb-2 inline-block <?php echo $postType != 'post' ? 'text-gray-900' : ''; ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h3>

                                        </div>
                                        <?php if ($postType == 'post') : ?>
                                            <div class="latest-posts-footer flex items-center justify-between flex-1 mt-auto">
                                                <time datetime="<?php esc_attr(get_the_date('c', $postID)); ?>" class="latest-posts-date text-sm text-body-color">
                                                    <?php echo esc_html(get_the_date('', $postID)); ?>
                                                </time>
                                                <span class="latest-posts-comments-number text-sm"><?php echo get_comments_number(); ?><i class="bi bi-chat ml-2"></i></span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </article>
                        <?php endwhile; ?>

                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                    <?php wp_reset_query(); ?>
                </div>

                <!-- view more link -->
                <?php if ($atts['displayViewMoreButton']) : ?>
                    <div class="text-center my-8">
                        <h4 class="view-more flex items-center justify-center"> <a href="<?php echo get_post_type_archive_link($postType); ?>"><?php esc_html_e('View more', 'nortic-plugin') ?></a></h4>
                    </div>
                <?php endif; ?>



            </section>
            <!-- Blog Section End -->
        </div>

<?php


        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
