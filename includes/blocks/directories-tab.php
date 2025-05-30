<?php 

if(!function_exists('nortic_plugin_directories_tab_render_cb')) {
    function nortic_plugin_directories_tab_render_cb($attributes) {
        $selected_terms = isset($attributes['directories']) && is_array($attributes['directories']) ? $attributes['directories'] : array();
        $posts_per_page = isset($attributes['count']) && $attributes['count'] > 0 ? $attributes['count'] : -1;

        if (empty($selected_terms)) {
            return '<p>' . __('No terms selected.', 'nortic-plugin') . '</p>';
        }

        ob_start(); // Inicia la captura de salida 

        ?>

        <div class="wp-block-nortic-plugin-directories-tab flex flex-col">
            <!-- tabs -->
            <ul class="directories-tabs flex items-center gap-x-8 border-b">
                <?php foreach($selected_terms as $term_id): 
                    $term = get_term($term_id, 'directory'); 
                    if(!$term || is_wp_error($term)) {
                        continue;
                    }   
                ?>
                    <li title="<?php echo esc_attr($term->name); ?>" class="directories-tab-button text-sm py-2 text-center flex-1 truncate" data-term-id="<?php echo esc_attr($term_id); ?>">
                        <?php echo esc_html($term->name); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <!-- directories -->
            <div class="directories-tabs-content bg-blue-100 px-4">
                <?php foreach($selected_terms as $term_id): ?>
                    <?php
                        $current_term = get_term($term_id, 'directory');
                        $child_terms = get_terms(array(
                            'taxonomy' => 'directory',
                            'parent' => $term_id,
                            'hide_empty' => false
                        ));    
                        // var_dump($current_term);
                    ?>
                    <div class="directories-tabs-content-list py-4" data-term-id="<?php echo esc_attr($term_id); ?>">
                        <ul class="flex flex-col border-b gap-4">
                            <?php foreach($child_terms as $child): ?>
                            <a class="text-blue-900 hover:text-blue-500" href="<?php echo esc_url(get_term_link($child->term_id, 'directory')); ?>">
                                <span class="font-semibold flex items-center gap-2 border-b"><i class="bi bi-folder2-open"></i><?php echo esc_html($child->name); ?></span>
                            </a>
                                <?php 
                                    // var_dump($child); 
                                    $child_child_terms = get_terms(array(
                                        'taxonomy' => 'directory', 
                                        'parent' => $child->term_id, 
                                        'hide_empty' => false
                                    ));
                                    // var_dump($child_child_terms); 
                                ?>
                                <?php foreach($child_child_terms as $child_term): ?>
                                    <li class="flex items-center gap-4 bg-white py-4 px-6 transition-all duration-300 ease-in-out hover:shadow hover:cursor-pointer" id="<?php echo esc_attr($child_term->term_id); ?>">
                                        <img src="/wp-content/plugins/nortic-plugin/dist/public/images/directory.svg" class="w-20"/>
                                        <div class="flex-1">
                                            <a href="<?php echo esc_url(get_term_link($child_term->term_id, 'directory')); ?>" class="text-sm text-blue-700">
                                                <?php echo esc_html($child_term->name); ?>
                                            </a>
                                            <?php 
                                                $latest_docs = get_posts(array(
                                                    'post_type' => 'document', 
                                                    'posts_per_page' => 1, 
                                                    'tax_query' => array(
                                                        array(
                                                            'taxonomy' => 'directory',
                                                            'field' => 'term_id',
                                                            'terms' => $child_term->term_id,
                                                            'include_children' => false
                                                        )
                                                    ),
                                                    'orderby' => 'date',
                                                    'order' => 'DESC'
                                                ));
                                            ?>

                                            <?php if(!empty($latest_docs)): ?>
                                                <?php 
                                                    // var_dump($latest_docs); 
                                                    $file_url = get_post_meta($latest_docs[0]->ID, 'file_url', true);
                                                    $file_description = get_post_meta($latest_docs[0]->ID, 'description', true);
                                                    $file_size = get_post_meta($latest_docs[0]->ID, 'file_size_readable', true);
                                                ?>
                                                <h5 class="text-blue-900 font-semibold"><?php echo esc_html($latest_docs[0]->post_title); ?></h5>
                                                <p class="text-gray-700 text-md"><?php echo esc_html($file_description); ?></p>
                                                <span class="flex flex-col md:flex-row items-start md:items-center">
                                                    <?php if($file_url): ?>
                                                        <span class="text-xs text-gray-500">
                                                            <?php echo $file_size; ?> 
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if($file_size): ?>
                                                        <span class="hidden md:flex">-</span>
                                                    <?php endif; ?>
                                                    <span class="text-xs text-gray-500">
                                                        <?php echo get_the_date('d \d\e F \d\e Y', $latest_docs[0]->ID); ?>
                                                    </span>
                                                </span>
                                                <?php if($file_url): ?>
                                                    <a class="button button-accent text-sm self-end md:self-auto md:ml-auto" href="<?php echo esc_url($file_url); ?>" target="_blank">
                                                        <?php esc_html_e('Download', 'nortic-plugin'); ?>
                                                    </a>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>

                        <!-- 🔹 Nombre del tab con el enlace al final -->
                        <div class="flex items-center justify-end mt-4">
                            <a href="<?php echo esc_url(get_term_link($current_term->term_id)); ?>" class="text-blue-500 font-semibold flex  flex-nowrap items-center gap-2 hover:text-blue-900">
                                <?php printf(__('View more in %s', 'nortic-plugin'), esc_html($current_term->name)); ?><i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                
              
                <?php endforeach; ?>
            </div>            
        </div>

        <?php

        $output = ob_get_contents(); // Obtiene la salida capturada
        ob_end_clean(); // Finaliza la captura de salida

        return $output;
    }
}