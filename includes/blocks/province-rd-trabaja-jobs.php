<?php 

if(!function_exists('nortic_plugin_province_rd_trabaja_jobs_render_cb')) {
    function nortic_plugin_province_rd_trabaja_jobs_render_cb($atts, $content) {

        $logo_url = NORTIC_PLUGIN_URL . 'dist/public/images/logos/rd-trabaja-logo.svg'; 
        $title = isset($atts['title']) ? $atts['title'] : null;
        $view_more_link = isset($atts['view_more_link']) ? $atts['view_more_link'] : null;

        if(is_front_page()) {
            $heading = isset($atts['landing_page_heading']) ? $atts['landing_page_heading'] : null;
            $subheading = isset($atts['landing_page_subheading']) ? $atts['landing_page_subheading'] : null;
        }

        if(is_tax('province')) {
            $term = get_queried_object();
            $rd_trabaja_province_id = get_term_meta($term->term_id, 'rd_trabaja_province_id', true);
            $heading = isset($atts['heading']) ? $atts['heading'] : null;
            if(!empty($heading)) {
                switch ($term->name) {
                    case 'Distrito Nacional':
                        $term_name = 'el Distrito Nacional';
                        break;
                    
                    default:
                        $term_name = $term->name;
                        break;
                }
                $heading = str_replace('esta provincia', $term_name, $heading);
            }
            $subheading = isset($atts['subheading']) ? $atts['subheading'] : null;

            if(!$rd_trabaja_province_id) {
                return null;
            }

            $api_url = "https://empleateya.mt.gob.do/api/puestos?filters=%7B%22idProvincia%22%3A{$rd_trabaja_province_id}%7D&pageIndex=1&pageSize=9";
            
        } else {
            $api_url = "https://empleateya.mt.gob.do/api/puestos?filters=%7B%7D&pageIndex=1&pageSize=9";
        }

        $response = wp_remote_get($api_url);

        if(is_wp_error($response)) {
            echo '<script>console.log("Request Error: ' . $response->get_error_message() . '");</script>';
            return null;
        }

        $jobs = json_decode(wp_remote_retrieve_body($response));

        if(empty($jobs)) {
            return "<p>" . __('No jobs found for this province', 'nortic-plugin') . "</p>";
        }

        // echo '<pre>';
        // var_dump($jobs);
        // echo '</pre>';

        ob_start();
        ?>
            <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs">
                <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-cta">
                    <?php if(!empty($logo_url)): ?>
                        <img src="<?php echo esc_url($logo_url); ?>" alt="RD-Trabaja Logo">
                    <?php endif; ?>
                    <h2><?php echo esc_html($heading); ?></h2>
                    <h4><?php echo esc_html($subheading); ?></h4>
                </div>
                <?php if(!empty($jobs->data)): ?>
                    <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-header">
                        <h5><?php echo esc_html($title); ?></h5>
                        <?php if(!empty($view_more_link)): ?>
                            <span class="jobs-platform-link">
                                <a href="<?php echo esc_url($view_more_link); ?>" target="_blank"><?php echo esc_html__('View more', 'nortic-plugin'); ?> <i class="bi bi-arrow-right"></i></a>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php if(!empty($jobs->data)): ?>
                    <ul class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list">
                        <?php foreach($jobs->data as $item): ?>
                            <?php 
                            if(isset($item->puesto)) {
                                $job = $item->puesto;
                                $job_id = $job->id;
                                $job_title = $job->titulo;
                                $job_general_requirements = $job->requisitosGenerales;
                                $job_description = $job->descripcion;
                                $job_published_at = $job->fechaPublicacion;
                                $job_end_date = $job->fechaVencimiento;
                                $iso_date = date('c', strtotime($job_published_at)); // 2021-10-19T17:00:00-05:00
                                $formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $job_published_at ) );
                                $formatted_end_date = date_i18n( get_option( 'date_format' ), strtotime( $job_end_date ) );
                            }    
                            ?>
                            <li id="job-<?php echo $job_id; ?>" class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item">
                                <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-header">
                                    <h5><?php echo esc_html($job_title); ?></h5>
                                    <time datetime="<?php echo esc_attr($iso_date); ?>">
                                        Publicado: <span><?php echo esc_html($formatted_date); ?></span>
                                    </time>
                                </div>
                                <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-list-item-body">
                                    <p><?php echo esc_html($job_description); ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php else : ?>
                    <div class="wp-block-nortic-plugin-province-rd-trabaja-jobs-footer">
                        <p><?php echo esc_html__('Go to', 'nortic-plugin'); ?></p>
                        <a href="<?php echo esc_url($view_more_link); ?>" target="_blank">rdtrabaja.mt.gob.do</a>
                    </div>
                <?php endif; ?>
            </div>
        <?php

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }
}