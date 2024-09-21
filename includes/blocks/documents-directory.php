<?php 

if(!function_exists('nortic_plugin_documents_directory_render_cb')) {
    function nortic_plugin_documents_directory_render_cb($atts) {
        $current_term = get_queried_object();
        $heading = single_term_title('', false);

        // get child terms
        $child_terms = get_terms(array(
            'taxonomy' => 'directory',
            'parent' => $current_term->term_id,
            'hide_empty' => false
        ));

        // var_dump($child_terms);

        // get current term posts
        $args = array(
            'post_type' => 'document', 
            'tax_query' => array(
                array(
                    'taxonomy' => 'directory',
                    'field' => 'term_id',
                    'terms' => $current_term->term_id,
                    'include_children' => false // exclude child terms posts
                ),
            ),
            'posts_per_page' => -1
        );

        $documents_query = new WP_Query($args);

        ob_start();  

?>  

        <div class="wp-block-nortic-plugin-nortic-documents-directory">
            <ul class="directory-list <?php echo !empty($child_terms) ? 'no-empty' : ''; ?>">
                <?php if(!empty($child_terms)): ?>
                    <?php foreach($child_terms as $child_term): ?>
                        <?php 
                        $directory_img_src = $child_term->count > 0 ? NORTIC_PLUGIN_URL . 'dist/public/images/directory.svg' : NORTIC_PLUGIN_URL . 'dist/public/images/directory-empty.svg';    
                        ?>
                        <li class="directory-item">
                            <a href="<?php echo esc_url(get_term_link($child_term)); ?>">
                                <img src="<?php echo esc_url($directory_img_src); ?>" />
                                <div class="directory-item-meta">
                                    <p class="directory-item-name"><?php echo $child_term->name; ?></p>
                                    <span><?php echo esc_html__('Files: ', 'nortic-plugin'); ?> <?php echo esc_html($child_term->count); ?></span>
                                </div>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <!-- <ul class="documents-container">
                <?php if($documents_query->have_posts()): ?>
                    <?php while($documents_query->have_posts()): $documents_query->the_post(); ?>
                        <?php
                        $attachments = get_attached_media('', get_the_ID());                        
                        ?>
                        <?php if($attachments): ?>
                            <li>
                                <p><?php echo get_the_title(); ?></p>
                                <ul class="documents-directory__attachments_list">
                                    <?php foreach($attachments as $attachment): ?>
                                        <?php 
                                        // var_dump($attachment);
                                        $attachment_url = wp_get_attachment_url($attachment->ID);    
                                        $attachment_title = $attachment->post_title;
                                        $attachment_date = $attachment->post_date_gmt;
                                        $attachment_mime_type = $attachment->post_mime_type;
                                        ?>
                                        <li class="documents-directory__single_document attachment-<?php echo $attachment->ID; ?>">
                                            <a href="<?php echo esc_url($attachment_url); ?>" target="_blank">
                                                <?php echo esc_html($attachment->post_title); ?>
                                            </a>
                                            <span><?php echo $attachment_mime_type; ?></span>
                                            <time datetime="<?php esc_attr($attachment_date); ?>" class="documents-directory__single_document-date">
                                                    <?php echo esc_html($attachment_date); ?>
                                                </time>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endif; ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                 
                <?php else: ?>
                    <p><?php echo esc_html__('No documents found in this directory', 'nortic-plugin'); ?></p>
                <?php endif; ?>
                
            </ul> -->
        </div>
<?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}