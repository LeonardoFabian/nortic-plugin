<?php 

if(!function_exists('nortic_plugin_document_manager_render_cb')) {
    function nortic_plugin_document_manager_render_cb($attributes) {
        $count = $attributes['count'];
        $directories = $attributes['directories'];
        $order = $attributes['order'];
        $orderBy = $attributes['orderBy'];

        $term = get_queried_object(); // obtiene la taxonomia actual
        $term_id = $term->term_id;
        $term_name = $term->name;
        $term_description = term_description($term_id);
        $more_info_url = get_term_meta($term_id, 'more_info_url', true);
        // var_dump($more_info_url);
        $term_slug = $term->slug;

        $child_terms = get_terms(array(
            'taxonomy' => 'directory', 
            'parent' => $term_id, // obtiene los terminos hijos
            'hide_empty' => false,
            'meta_key' => 'ordering', // ordena los terminos hijos por el campo ordering
            'orderby' => 'meta_value', // ordena por el valor numerico de ordering,
            'order' => 'ASC',
            'fields' => 'all'
        ));

        if (empty($child_terms)) {
            $child_terms = get_terms(array(
                'taxonomy' => 'directory',
                'parent' => $term_id,
                'hide_empty' => false,
                'orderby' => 'ID', // ordena por ID si no hay campo 'ordering'
                'order' => 'DESC', // orden descendente
                'fields' => 'all',
            ));
        }

        $documents = new WP_Query(array(
            'post_type' => 'document',
            'tax_query' => array(
                array(
                    'taxonomy' => 'directory',
                    'field' => 'term_id',
                    'terms' => $term_id,
                    'include_children' => false // solo documentos de la taxonomia actual
                )
            ),
            'posts_per_page' => -1, // $count
            'orderby' => 'date',
            'order' => 'DESC'
        ));

        ob_start();

        ?>

        <div class="wp-block-nortic-plugin-document-manager">
            <div class="flex flex-col">
                <div class="flex flex-col gap-2 border-b pb-4">
                    <h1 class="text-2xl font-bold"><?php echo esc_html($term_name); ?></h1>
                    <?php if(!empty($term_description)): ?>
                        <p class="text-sm text-gray-500"><?php echo $term_description; ?></p> 
                    <?php endif; ?>
                    <?php if (!empty($more_info_url) && $more_info_url !== "#"): ?>
                        <a href="<?php echo esc_url($more_info_url); ?>" class="text-blue-500"><?php esc_html_e('More info', 'nortic-plugin'); ?></a>
                    <?php endif; ?>
                </div>

                <div class="flex gap-4 mt-4 document-manager-tabs">
                    <?php if($documents->have_posts()): ?>
                        <button id="tab-content" class="tab-button active" data-tab="content">
                            <?php esc_html_e('Content', 'nortic-plugin'); ?> 
                        </button>
                    <?php endif; ?>  

                    <?php if(!empty($child_terms) || $documents->have_posts()): ?>
                        <button id="tab-documents" class="tab-button" data-tab="documents">
                            <?php esc_html_e('Documents', 'nortic-plugin'); ?>
                        </button>
                    <?php endif; ?>
                </div>


                <div id="tab-content-section" class="document-manager-tab-section flex flex-col gap-12 mt-12">
                    <?php while($documents->have_posts()): $documents->the_post(); ?>
                    <?php the_content(); ?>
                    <?php endwhile; ?>
                </div>

                <!-- tab documents -->
                <div id="tab-documents-section" class="document-manager-tab-section bg-blue-50 p-4 hidden">
                    <!-- carpetas -->
                    <?php if($child_terms): ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php foreach($child_terms as $child) : ?>
                                <a href="<?php echo get_term_link($child); ?>"  class="flex items-center gap-4 p-4 md:text-right bg-blue-100 bg-opacity-75 hover:bg-blue-100">
                                    <img src="/wp-content/plugins/nortic-plugin/dist/public/images/directory.svg" class="w-20"/>
                                    <p class="text-sm font-semibold md:text-right text-blue-900"><?php echo esc_html($child->name); ?></p>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>               

                    <!-- documentos -->
                    <div class="nortic-documents">
                        <?php 
                            $document_formats = [];
                        ?>
                        <?php if($documents->have_posts()): ?>
                            <?php while($documents->have_posts()): $documents->the_post(); ?>
                            <!-- variables -->
                                <?php 
                                    $file_url = get_post_meta(get_the_ID(), 'file_url', true);
                                    $file_size = filesize(get_attached_file(get_post_meta(get_the_ID(), '_wp_attached_file', true))) / 1024; // Tamaño en KB

                                    $file_description = get_post_meta(get_the_ID(), 'description', true);

                                    $file_format = get_post_meta(get_the_ID(), 'file_format', true);
                                    if($file_format) {
                                        $document_formats[] = $file_format;
                                    }
                                    $icon = $file_format ? $file_format : "file";

                                    $icon_url = get_post_meta(get_the_ID(), 'icon', true);
                                    $default_icon_url = get_post_meta(get_the_ID(), 'default_icon', true);
                                    $use_default_icon = get_post_meta(get_the_ID(), 'use_default_icon', true);

                                    // Define icon
                                    $selected_icon_url = $use_default_icon ? esc_url($default_icon_url) : esc_url($icon_url);
                                ?>

                                <div class="flex flex-col md:flex-row items-start md:items-center p-4 bg-white rounded-lg mt-2 gap-4 hover:shadow hover:cursor-pointer">
                                    <img src="/wp-content/plugins/nortic-plugin/dist/public/images/<?php echo $icon; ?>.svg" class="w-12" />
                                    <div class="flex-1">
                                        <h5 class="font-semibold"><?php the_title(); ?></h5>
                                        <?php if($file_description): ?>
                                            <p class="text-gray-700 text-md"><?php echo esc_html($file_description); ?></p>
                                        <?php endif; ?>
                                        <span class="flex flex-col md:flex-row items-start md:items-center">
                                            <span class="text-xs text-gray-500">
                                                <?php echo round($file_size, 2); ?> KB
                                            </span>
                                            <span class="hidden md:flex">-</span>
                                            <span class="text-xs text-gray-500 uppercase">
                                                <?php echo get_the_date('d \d\e F \d\e Y'); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <?php if($file_url): ?>
                                        <a class="button button-accent text-sm self-end md:self-auto md:ml-auto" href="<?php echo esc_url($file_url); ?>" target="_blank">
                                            <?php esc_html_e('Download', 'nortic-plugin'); ?>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; wp_reset_postdata(); ?>
                        <?php else: ?>
                            <p class="text-gray-500"><?php esc_html_e('There are no documents published in this category', 'nortic-plugin'); ?></p>
                        <?php endif; ?>

                        <?php                     
                            $document_formats = array_unique($document_formats);                     
                            // var_dump($document_formats);                       
                        ?>

                        <?php if(!empty($document_formats)): ?>
                            <div class="flex bg-blue-200 flex-col items-start p-4 border rounded-lg mt-8">
                                <div class="flex flex-col items-start">
                                    <p><?php esc_html_e('If you can\'t view documents, you may need one of these viewers:', 'nortic-plugin'); ?></p>
                                    <ul class="flex flex-col gap-2 p-4 list-disc">
                                        <?php foreach($document_formats as $document_format): ?>

                                            <?php 
                                                switch ($document_format) {
                                                    case "pdf":
                                                        $format = "PDF";
                                                        $label = "Adobe Reader";
                                                        $url = "https://get.adobe.com/reader/";
                                                        break;
                                                    case "doc":
                                                        $format = "Word";
                                                        $label = "Microsoft Word";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/word";
                                                        break;
                                                    case "docx":
                                                        $format = "Word";
                                                        $label = "Microsoft Word";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/word";
                                                        break;
                                                    case "xls":
                                                        $format = "Excel";
                                                        $label = "Microsoft Excel";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/excel";
                                                        break;
                                                    case "xlsx":
                                                        $format = "Excel";
                                                        $label = "Microsoft Excel";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/excel";
                                                        break;
                                                    case "ppt":
                                                        $format = "PowerPoint";
                                                        $label = "Microsoft PowerPoint";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/powerpoint";
                                                        break;
                                                    case "pptx":
                                                        $format = "PowerPoint";
                                                        $label = "Microsoft PowerPoint";    
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/powerpoint";
                                                        break;
                                                    default:
                                                        $format = "";
                                                        $label = "";
                                                        $url = "";
                                                        break;
                                                }    
                                            ?>
                                            <li>
                                                <span class="text-sm text-gray-500">
                                                    <?php printf(
                                                        __('To view %s files, download %s by clicking %s', 'nortic-plugin'), 
                                                        $format, 
                                                        '<strong>'.$label.'</strong>', 
                                                        '<a href="' . esc_url($url) . '" target="_blank" class="text-sm">here</a>'
                                                    ); ?> 
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }
}