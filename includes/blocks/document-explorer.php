<?php 

if (!function_exists('nortic_plugin_document_explorer_render_cb')) {
    function nortic_plugin_document_explorer_render_cb($attributes, $content, $block) {
        $root_id = isset($_GET['folder']) ? intval($_GET['folder']) : ($attributes['parentId'] ?? 0);
        $search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';

        $breadcrumbs = [];
        $current_id = $root_id;
        while ($current_id && $parent = get_post($current_id)) {
            array_unshift($breadcrumbs, [
                'id' => $parent->ID,
                'title' => get_the_title($parent),
            ]);
            $current_id = $parent->post_parent;
        }

        // obtener documentos principales parent = 0 
        $args = array(
            'post_type' => 'document',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_parent' => $root_id,
        );

        if (!empty($search_query)) {
            unset($args['post_parent']);
            // $args['orderby'] = 'title';
            // $args['order'] = 'ASC';
            $args['s'] = $search_query;
        }

        $documents = get_posts($args);

        ob_start();

        ?>

            <div class="wp-block-nortic-plugin-document-explorer">
                <!-- <?php if ($root_id > 0) : ?>
                    <a href="<?php echo esc_url(remove_query_arg('folder')) ?>" class="document-explorer-back-link">
                        <?php _e('Back', 'nortic-plugin'); ?>
                    </a>
                <?php endif; ?> -->
                <?php if (!empty($breadcrumbs)) : ?>
                <!-- <nav class="document-explorer-breadcrumbs">
                    <a href="?folder=0">Inicio</a>
                    <?php foreach ($breadcrumbs as $crumb) : ?>
                        &nbsp;&raquo;&nbsp;<a href="?folder=<?php echo $crumb['id']; ?>"><?php echo esc_html($crumb['title']); ?></a>
                    <?php endforeach; ?>
                </nav> -->
                <nav class="document-explorer-breadcrumbs">
                    <a href="?folder=0">Inicio</a>
                    <?php for ($i = 0; $i < count($breadcrumbs) - 1; $i++) : ?>
                        &nbsp;&raquo;&nbsp;<a href="?folder=<?php echo $breadcrumbs[$i]['id']; ?>"><?php echo esc_html($breadcrumbs[$i]['title']); ?></a>
                    <?php endfor; ?>
                </nav>

                <?php $last = end($breadcrumbs); ?>
                <h2 class="document-explorer-breadcrumbs-current-title mt-2 mb-4"><?php echo esc_html($last['title']); ?></h2>
            <?php endif; ?>

                <?php 
                    $document_formats = []; // almacena los formatos de archivos
                    $folders = []; // para validar que al menos se está mostrando un folder para cambiar el display a grid
                    $others = []; // almacena los otros tipos: file, note, link

                    foreach ($documents as $document) {
                        $meta = get_post_meta($document->ID); 
                        $type = $meta['document_type'][0] ?? 'file'; 

                        if($type === 'folder') {
                            $folders[] = $document;
                        } else if($type != 'folder') {
                            $others[] = $document;
                        }
                    }
                ?>

                <!-- Renderizar folders en grid -->
                <?php if(!empty($folders) && !is_search()): ?>
                    
                    <ul class="document-explorer-list folder-list grid grid-cols-1 md:grid-cols-2 " style="list-style: none; list-style-type: none !important; padding: 0; margin: 0; margin-top: 0 !important; padding-left: 0 !important; display: grid !important;">
                        <?php foreach ($folders as $document) { 
                            nortic_plugin_render_document_explorer_item($document, $document_formats);
                        } ?>
                    </ul>
                <?php endif; ?>

                <!-- Renderizar los otros tipos -->
                <ul class="document-explorer-list items-list " style="list-style: none; list-style-type: none !important; padding: 0; margin-top: 0 !important; padding-left: 0 !important;">
                    <?php foreach ($others as $document) { 
                        nortic_plugin_render_document_explorer_item($document, $document_formats);
                    } ?>
                </ul>

                <?php                     
                            $document_formats = array_unique($document_formats);                     
                            // var_dump($document_formats);                       
                        ?>

<?php if(!empty($document_formats)): ?>
                            <div class="document-explorer-viewers flex flex-col items-start">
                                <div class="flex flex-col items-start">
                                    <p><?php esc_html_e('If you can\'t view documents, you may need one of these viewers:', 'nortic-plugin'); ?></p>
                                    <ul class="flex flex-col gap-2 list-disc">
                                        <?php foreach($document_formats as $document_format): ?>

                                            
                                            <?php 
                                            // var_dump($document_format);

                                                switch ($document_format) {
                                                    case "pdf":
                                                        $format = "PDF";
                                                        $label = "Adobe Reader";
                                                        $url = "https://get.adobe.com/reader/";
                                                        break;
                                                    case "doc":
                                                    case "docx":            
                                                    case "vnd.oasis.opendocument.text":         
                                                    case "vnd.openxmlformats-officedocument.wordprocessingml.document":
                                                        $format = "Word";
                                                        $label = "Microsoft Word";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/word";
                                                        break;
                                                    case "xls": 
                                                    case "xlsx":                                                    
                                                    case "csv":  
                                                    case "vnd.oasis.opendocument.spreadsheet":                                          
                                                    case "vnd.ms-excel":
                                                    case "vnd.openxmlformats-officedocument.spreadsheetml.sheet":
                                                    case "vnd.ms-excel.sheet":
                                                    case "vnd.ms-excel.sheet.macroenabled.12":
                                                        $format = "Excel";
                                                        $label = "Microsoft Excel";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/excel";
                                                        break;                                       
                                                    case "ppt":
                                                    case "pptx":
                                                    case "vnd.oasis.opendocument.presentation":      
                                                    case "vnd.openxmlformats-officedocument.presentationml.presentation":
                                                        $format = "PowerPoint";
                                                        $label = "Microsoft PowerPoint";
                                                        $url = "https://www.microsoft.com/en-us/microsoft-365/powerpoint";
                                                        break;     
                                                    case "ods":
                                                    case "odt":
                                                    case "odp":
                                                    case "odg":
                                                    case "odf":
                                                    case "ott":
                                                    case "ots":
                                                    case "odm":                                                    
                                                        $format = "Open Document";
                                                        $label = "LibreOffice";
                                                        $url = "https://www.openoffice.org/es/descargar/";
                                                        break;                                
                                                    default:
                                                        $format = "";
                                                        $label = "";
                                                        $url = "";
                                                        break;
                                                }    


                                                
                                            ?>
                                            <li>
                                                <span class="text-md text-gray-500">
                                                    <?php printf(
                                                        __('To view %s files, download %s by clicking %s', 'nortic-plugin'), 
                                                        $format, 
                                                        '<strong>'.$label.'</strong>', 
                                                        '<a href="' . esc_url($url) . '" target="_blank" class="text-md">' . esc_html__('here', 'nortic-plugin') . '</a>'
                                                    ); ?> 
                                                </span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                
                                </div>
                            </div>
                        <?php endif; ?>
            </div>

        <?php 

        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }    
}

if (!function_exists('nortic_plugin_render_document_explorer_item')) {
    function nortic_plugin_render_document_explorer_item($doc, &$document_formats) {
        $meta = get_post_meta($doc->ID);
        $type = $meta['document_type'][0] ?? 'file';
        $title = get_the_title($doc); 
        $description = $meta['description'][0] ?? '';
        $file_url = $meta['file_url'][0] ?? ''; 
        $external_url = $meta['document_external_url'][0] ?? ''; 
        $external_url_label = $meta['document_external_url_label'][0] ?? '';
        $note = $meta['note'][0] ?? ''; 
        $file_size = $meta['file_size_readable'][0] ?? '';
        $format = $meta['file_format'][0] ?? '';
        if (!empty($format) && $type === 'file') {
            $document_formats[] = strtolower($format);
        }
        $icon_class = nortic_plugin_document_explorer_file_format_icon_class(get_post_meta($doc->ID, 'file_format', true));

        switch ($format) {
            case "pdf":
                $format = "PDF";
                break;
            case "doc":
            case "docx": 
                $format = "DOCX";
                break;
            case "xls":
            case "xlsx":
            case "vnd.openxmlformats-officedocument.spreadsheetml.sheet":
            case "vnd.ms-excel":
            case "vnd.ms-excel.sheet.macroEnabled.12":
                $format = "XLSX";
                break;   
            case "ppt":
            case "pptx":
                $format = "PPTX";
                break;
            default:
                $format = "FILE";
                break;
        }

        ?>
            <li class="document-explorer-item <?php echo $type; ?>">
                <?php if ($type === 'folder' && !is_search()) { ?>
                    <?php 
                        $count = count(get_posts([
                            'post_type'      => 'document',
                            'post_status'    => 'publish',
                            'post_parent'    => $doc->ID,
                            'posts_per_page' => -1,
                            'fields'         => 'ids', // mejora el rendimiento
                        ]));
                    ?>
                    <a href="?folder=<?php echo esc_attr($doc->ID); ?>" class="document-explorer-item-folder">
                        <!-- <i class="bi bi-folder-fill"></i> -->
                        <img src="/wp-content/plugins/nortic-plugin/dist/public/images/directory.svg" class="w-20"/>
                        <div class="document-explorer-item-folder-info">
                            <h6 class="document-explorer-item-folder-title"><?php echo esc_html($title); ?></h6>
                            <span class="text-sm text-gray-500"><?php echo $count; ?> <?php _e('items', 'nortic-plugin'); ?></span>
                        </div>
                    </a>

                    <!-- renderizar hijos -->
                     <?php 
                        // $children = get_posts(array(
                        //     'post_type' => 'document',
                        //     'post_status' => 'publish',
                        //     'posts_per_page' => -1,
                        //     'orderby' => 'date',
                        //     'order' => 'DESC',
                        //     'post_parent' => $doc->ID,
                        // ));
                        ?>

                       <!-- <?php if (!empty($children)) { ?>
                        <ul class="document-explorer-sublist">
                               <?php foreach ($children as $child) { nortic_plugin_render_document_explorer_item($child); 
                                 } ?>
                           </ul>
                        <?php } ?> -->
                <?php } elseif ($type === 'external_link') { ?>
                    <div class="document-explorer-item-external-link">
                        <div class="document-explorer-item-external-link-content">
                            <i class="bi bi-link-45deg"></i>
                            <div class="document-explorer-item-external-link-info">
                                <div>
                                    <h5 class="document-explorer-item-external-link-title"><?php echo esc_html($title); ?></h5>
                                    <p class="document-explorer-item-external-link-description"><?php echo esc_html($description); ?></p>
                                </div>
                                <div class="document-explorer-item-external-link-actions">
                                    <a href="<?php echo esc_url($external_url); ?>" target="_blank" rel="noopener noreferrer" class="document-explorer-item-external-link-link">
                                        <?php echo $external_url_label !== '' ?  esc_html($external_url_label) : _e('Open link', 'nortic-plugin'); ?>
                                    </a>
                                </div>                                
                            </div>                            
                        </div>
                    </div>
                <?php } elseif ($type === 'note') { ?>
                    <div class="document-explorer-item-note">
                        <div class="document-explorer-item-note-content">
                            <i class="bi bi-info-circle"></i>
                            <div class="document-explorer-item-note-info">
                                <h5 class="document-explorer-item-note-title"><?php echo esc_html($title); ?></h5>
                                <?php if (!empty($note)) : ?>
                                    <p class="document-explorer-item-note-description"><?php echo esc_html($note); ?></p>
                                <?php endif; ?>
                                <span class="document-explorer-item-note-meta"><?php _e('Published on', 'nortic-plugin'); ?>: <?php echo get_the_date(); ?></span>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="document-explorer-item-file">
                        <div class="document-explorer-item-file-content flex items-center gap-4">
                            <!-- <i class="<?php echo esc_attr($icon_class); ?>"></i> -->
                             <?php 
                             $str_format = strtolower($format);
                             ?>
                            <img src="/wp-content/plugins/nortic-plugin/dist/public/images/<?php echo $str_format; ?>.svg" class="w-12" />
                            <div class="document-explorer-item-file-info">
                                <h5 class="document-explorer-item-file-title"><?php echo esc_html($title); ?></h5> 
                                <?php if (!empty($description)) : ?>
                                    <p class="document-explorer-item-file-description"><?php echo esc_html($description); ?></p>
                                <?php endif; ?>
                                <span class="document-explorer-item-file-meta"><?php _e('File size', 'nortic-plugin'); ?>: <?php echo esc_html($file_size); ?> - <?php _e('Format', 'nortic-plugin') ?>: <?php echo esc_html($format); ?> - <?php _e('Published on', 'nortic-plugin'); ?>: <?php echo get_the_date('', $doc); ?></span>
                            </div>
                        </div>
                        <a href="<?php echo esc_url($file_url); ?>" download class="document-explorer-item-file-download-button">
                            <?php _e('Download', 'nortic-plugin'); ?>
                        </a>
                    </div>
                <?php } ?>
            </li>
        <?php 
    }
}

if (!function_exists('nortic_plugin_document_explorer_file_format_icon_class')) {
    function nortic_plugin_document_explorer_file_format_icon_class($format) {
        $map = [
            'pdf' => 'bi bi-file-earmark-pdf',
            'doc' => 'bi bi-file-earmark-word',
            'docx' => 'bi bi-file-earmark-word',
            'xls' => 'bi bi-file-earmark-excel',
            'xlsx' => 'bi bi-file-earmark-excel',
            'csv' => 'bi bi-file-earmark-spreadsheet',
            'jpg' => 'bi bi-file-earmark-image',
            'png' => 'bi bi-file-earmark-image',
            'zip' => 'bi bi-file-earmark-zip',
            'txt' => 'bi bi-file-earmark-text',
            'link' => 'bi bi-link-45deg',
            'default' => 'bi bi-file-earmark'
        ];

        return $map[strtolower($format)] ?? $map['default'];
    }
}
