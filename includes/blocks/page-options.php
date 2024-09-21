<?php

if (!function_exists('nortic_plugin_page_options_render_cb')) {
    function nortic_plugin_page_options_render_cb($atts, $content, $block)
    {

        $postID = $block->context['postId'];
        $title = get_the_title($postID);
        $url = get_permalink($postID);


        ob_start();
?>
        <?php if (!is_home() && !is_front_page()) : ?>
            <div class="wp-block-nortic-plugin-page-options py-4">
                <div class="mx-auto">
                    <div class="page-options-wrapper w-full flex flex-nowrap items-center text-md" style="justify-content: <?php echo $atts['justify_content']; ?>;">

                        <?php if ($atts['show_print_option']) : ?>
                            <!-- print  -->
                            <a href="javascript:if(window.print)window.print()" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" aria-label="<?php esc_html_e("Print", "nortic-plugin"); ?>">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                    {" "}
                                    <title><?php esc_html_e("Print", "nortic-plugin"); ?></title>
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />{" "}
                                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />{" "}
                                </svg>
                                <span class="sr-only">
                                    <?php esc_html_e("Print", "nortic-plugin"); ?>
                                </span>
                            </a>
                            <!-- END print -->
                        <?php endif; ?>

                        <?php if ($atts['show_export_option']) : ?>
                            <!-- export  -->
                            <button type="button" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" aria-label="<?php esc_html_e("Convert to PDF", "nortic-plugin"); ?>">
                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">

                                    <title><?php esc_html_e("Export", "nortic-plugin"); ?></title>
                                    <path fill-rule="evenodd" d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5z" />
                                    <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0v-5z" />
                                </svg>
                                <span class="sr-only">
                                    <?php esc_html_e("Export", "nortic-plugin") ?>
                                </span>
                            </button>
                            <!-- END export -->
                        <?php endif; ?>

                        <?php if ($atts['show_send_option']) : ?>
                            <!-- send -->
                            <a href="mailto:?subject=<?php echo strip_tags($title); ?>&amp;body=<?php 
                            // Translators: %s is the URL of the post.
                            echo sprintf(__('See the post in %s', 'nortic-plugin'), $url); ?>" 
                            title="<?php esc_html_e('Share by email', 'nortic-plugin'); ?>" 
                            class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center mr-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 dark:hover:bg-blue-500" 
                            aria-label="<?php esc_html_e('Share by email', 'nortic-plugin'); ?>">

                                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                    <title><?php esc_html_e('Send by email', 'nortic-plugin'); ?></title>
                                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                                </svg>
                                <span class="sr-only">
                                    <?php esc_html_e('Send', 'nortic-plugin'); ?>
                                </span>
                            </a>
                            <!-- END send -->
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        <?php endif; ?>
<?php
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}
