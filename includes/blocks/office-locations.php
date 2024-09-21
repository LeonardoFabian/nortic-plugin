<?php

if (!function_exists('nortic_plugin_office_locations_render_cb')) {
    /**
     * Office locations server side rendering
     *
     * @return void
     */
    function nortic_plugin_office_locations_render_cb($atts)
    {
        $paged = get_query_var('paged');

        $areaIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['areas']);

        $args = [
            'post_type' => 'dependency',
            'posts_per_page' => $atts['count'],
            'orderby' => 'title',
            'order' => 'ASC',
            'paged' => $paged
        ];

        if (!empty($areaIDs)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'area',
                    'field' => 'term_id',
                    'terms' => $areaIDs
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
?>

        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <?php
                $postID = get_the_ID();

                $location = get_post_meta($postID, 'location', true);
                $phone = get_post_meta($postID, 'phone', true);
                $email = get_post_meta($postID, 'email', true);
                $image = get_the_post_thumbnail($postID, 'full', array('class' => 'h-full object-cover'));

                ?>
                <div <?php echo get_block_wrapper_attributes(); ?>>
                    <!-- Blog Section Start -->

                    <div id="dependency-<?php echo $postID; ?>" class="border <?php echo ($atts['shadow'] == true) ? "has-shadow" : ""; ?>">
                        <div class="bg-white rounded shadow-md flex flex-col text-grey-darkest office-location-meta">
                            <a href="#" class="office-location-meta-img-wrap block h-44 overflow-hidden bg-gray-100">
                                <?php if (!empty($image)) {
                                    echo  $image;
                                } else {
                                ?>
                                    <div class="w-full h-full bg-[url('https://mt.gob.do/cache/com_zoo/images/fachada2023_7c50f543d08c6778cd51cc50d994d7f9.jpg')] bg-cover bg-center">
                                        <div class="w-full h-full flex  justify-center items-center 
             bg-blue-600/30 backdrop-brightness-75">
                                            <i class="bi bi-card-image text-gray-300 text-5xl"></i>
                                        </div>
                                    </div>
                                <?php
                                }
                                // the_post_thumbnail(); 

                                ?>
                                <!-- <div class="office-location-meta-img h-full rounded-l-sm bg-cover bg-center" style="<?php echo get_the_post_thumbnail($postID, 'thumbnail', array('class' => 'object-cover')); ?>"></div> -->
                            </a>


                            <div class="h-28 px-6 py-4 text-left office-location-metadata">
                                <a href="<?php the_permalink(); ?>">
                                    <span class="font-medium office-location-name">

                                        <?php echo get_the_title(); ?>

                                    </span>
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- Blog Section End  -->
                </div>

            <?php endwhile; ?>
            <?php
            if (function_exists('custom_pagination')) {
                custom_pagination($cat->max_num_pages, "", $paged);
            }
            ?>
        <?php endif; ?>



        <?php wp_reset_postdata(); ?>
        <?php wp_reset_query(); ?>
<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
