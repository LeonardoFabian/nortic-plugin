<?php

if (!function_exists('nortic_plugin_file_list_render_cb')) {
    function nortic_plugin_file_list_render_cb($atts)
    {
        $current_term = get_queried_object();
        $directoryIDs = array_map(function ($term) {
            return $term['id'];
        }, $atts['directories']);

        $args = [
            'post_type' => 'document',
            'posts_per_page' => $atts['count'],
            'orderby' => $atts['orderBy'],
            'order' => $atts['order'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'directory',
                    'field' => 'term_id',
                    'terms' => $current_term->term_id,
                    'include_children' => false
                ),
            ),
        ];

        if (!empty($directoryIDs)) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'directory',
                    'field' => 'term_id',
                    'terms' => $directoryIDs,
                    'include_children' => false // exclude child terms posts
                ]
            ];
        }

        $query = new WP_Query($args);

        ob_start();
?>
        <div <?php echo get_block_wrapper_attributes(); ?>>
            <!-- Service Section Start -->
            <section class="pb-12">
                <div class="mx-auto">
                    <div class="file-list-container">
                        <?php if ($query->have_posts()) : ?>
                            <?php while ($query->have_posts()) : $query->the_post(); ?>

                                <?php
                                $post_id = get_the_ID();

                                $fileSize = get_post_meta($post_id, 'file_size_readable', true);
                                $fileUrl = get_post_meta($post_id, 'file_url', true);
                                $fileName = get_post_meta($post_id, 'file_name', true);
                                $fileDescription = get_post_meta($post_id, 'description', true);
                                $fileFormat = get_post_meta($post_id, 'file_format', true);

                                $pluginIconUrl = get_post_meta($post_id, 'icon', true);
                                $defaultIconUrl = get_post_meta($post_id, 'default_icon', true);
                                $useDefaultIcon = get_post_meta($post_id, 'use_default_icon', true);

                                // Define icon
                                $iconUrl = $useDefaultIcon ? esc_url($defaultIconUrl) : esc_url($pluginIconUrl);


                                $fileSize = empty($fileSize) ? 0.00 : $fileSize;

                                $fileUrl = empty($fileUrl) ? '#' : $fileUrl;

                                $fileName = empty($fileName) ? '' : $fileName;

                                $fileDescription = empty($fileDescription) ? '' : $fileDescription;

                                ?>

                                <div id="document-<?php echo $post_id; ?>" class="file-list-item relative  bg-white  py-1 flex justify-between items-center" href="<?php the_permalink(); ?>">
                                    
                                   
                                    <div class="file-data py-2 text-gray-500 flex justify-start items-center">
                                       
                                        <img src="<?php echo $iconUrl; ?>" class="file-icon w-14" />

                                        <div class="file-list-info flex flex-col items-start px-4">
                                            <h6 class="text-md font-semibold">
                                                <a href="<?php the_permalink(); ?>">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h6>
                                            <div class="file-list-meta flex items-center justify-start gap-4">
                                                <span class="file-size text-sm"><?php echo $fileSize; ?></span>
                                                <span>
                                                  
                                                        <?php esc_html_e('Publication date', 'nortic-plugin'); ?>:
                                                   
                                                    <time datetime="<?php esc_attr(get_the_date('c', $post_id)); ?>" class="text-sm text-body-color uppercase">
                                                        <?php echo esc_html(get_the_date('', $post_id)); ?></time>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-options">                                        
                                        <!-- Modal toggle -->
                                        <button data-modal-target="file-info-modal-<?php echo $post_id; ?>" data-modal-toggle="file-info-modal-<?php echo $post_id; ?>" class="file-info modal-toggle  p-2" type="button">
                                            <i class="bi bi-info-circle !text-md "></i>
                                        </button>
                                        <a class="button button-accent" href="<?php echo $fileUrl; ?>" target="_blank"><?php esc_html_e('Download', 'nortic-plugin'); ?></a>
                                    </div>
                                </div>

                                <!-- content to print -->
                                <!-- <div id="file-preview-<?php echo $post_id; ?>">
                                    <iframe src="<?php echo $fileUrl; ?>" frameborder="0"></iframe>
                                </div> -->
                                <!-- end of content to print -->

                                <!-- Main modal -->
                                <div id="file-info-modal-<?php echo $post_id; ?>" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full modal">
                                    <div class="relative w-full max-w-2xl max-h-full">
                                        <!-- Modal content -->
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <!-- Modal header -->
                                            <div class="flex items-center justify-between p-2 border-b rounded-t bg-light-gray">
                                                <h6 class="text-sm font-semibold color-dark-gray">
                                                    <?php esc_html_e('Download File', 'nortic-plugin'); ?>
                                                </h6>
                                                <button type="button" class="bg-transparent rounded-lg text-md ml-auto inline-flex items-center font-semibold" data-modal-hide="file-info-modal-<?php echo $post_id; ?>">
                                                    <i class="bi bi-x-circle color-red"></i>
                                                    <span class="sr-only"><?php _x('Close modal', 'Screen reader content', 'nortic-plugin'); ?></span>
                                                </button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="p-6 space-y-6">
                                                <div class="file-modal-metadata text-center">
                                                    <div class="file-modal-metadata-info-icon text-center">
                                                        <img src="<?php echo $iconUrl; ?>" class="file-icon h-16 mx-auto" />
                                                    </div>
                                                    <h6 class="text-md font-semibold mb-4 color-black"><?php the_title(); ?></h6>
                                                    <p class="text-base leading-relaxed color-dark-gray">
                                                        <?php echo $fileDescription; ?>
                                                    </p>
                                                    <div class="file-modal-metadata-info text-sm block text-center mt-10 p-4 border border-ultimate-gray">

                                                        <div class="file-modal-metadata-info-details md:mt-0 flex items-center justify-around gap-10">

                                                            <div>
                                                                <span class="font-semibold color-dark-gray"><?php _e('Size', 'nortic-plugin'); ?></span>:
                                                                <p class="color-black text-sm">
                                                                    <?php echo $fileSize; ?>
                                                                </p>
                                                            </div>

                                                            <div>
                                                                <span class="font-semibold color-dark-gray">
                                                                    <?php esc_html_e('Publication date', 'nortic-plugin'); ?>:
                                                                </span>
                                                                <p class="color-black text-sm">

                                                                    <time datetime="<?php esc_attr(get_the_date('c', $post_id)); ?>" class="text-sm text-body-color uppercase">
                                                                        <?php echo esc_html(get_the_date('', $post_id)); ?></time>
                                                                </p>
                                                            </div>

                                                            <div>
                                                                <span class="font-semibold color-dark-gray"><?php _e('Format', 'nortic-plugin'); ?></span>:
                                                                <p class="color-black text-sm">
                                                                    <?php echo nortic_plugin_get_document_type_by_file_format($fileFormat); ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if (!empty($fileFormat)) : ?>
                                                        <div class="mt-4 bg-white px-6 py-5 border-l-4 border-azure-blue text-base text-blue-700 flex items-center text-left shadow-sm" role="alert">
                                                            <i class="bi bi-info-circle-fill mr-6 text-4xl"></i>
                                                            <div>
                                                                <p class="text-sm mb-2 leading-tight color-dark-gray"><?php esc_html_e('If you can\'t view your documents, you may need one of these viewers', 'nortic-plugin'); ?>:</p>
                                                                <?php echo nortic_plugin_get_document_viewer_url_by_file_format($fileFormat); ?>

                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <!-- Modal footer -->
                                            <div class="flex flex-col items-center p-6 divide-y space-y-6 border-t border-gray-200 rounded-b dark:border-gray-600">

                                                <a class="button button-primary" href="<?php echo $fileUrl; ?>" target="_blank"><?php esc_html_e('Download', 'nortic-plugin'); ?></a>

                                                <button data-modal-hide="file-info-modal-<?php echo $post_id; ?>" type="button" class="button button-link"><?php esc_html_e('Go back', 'nortic-plugin'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end modal -->

                            <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>

                        <?php endif; ?>
                    </div>
                </div>
            </section>
            <!-- Service Section End -->



        </div>
<?php

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
