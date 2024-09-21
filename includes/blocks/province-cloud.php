<?php 

if(!function_exists('nortic_plugin_province_cloud_render_cb')) {
    function nortic_plugin_province_cloud_render_cb($atts) {

        $heading = isset($atts['heading']) ? $atts['heading'] : null;
        $subheading = isset($atts['subheading']) ? $atts['subheading'] : null;

        $provinces = get_terms([
            'taxonomy' => 'province',
            'hide_empty' => false
        ]);
        
        if(!empty($provinces) && !is_wp_error($provinces)) {

            ob_start(); 
?>

        <div class="wp-block-nortic-plugin-province-cloud">
            <div class="wp-block-nortic-plugin-province-cloud-header">
                <h2><?php echo esc_html($heading); ?></h2>
                <h4><?php echo esc_html($subheading); ?></h4>
            </div>
            <ul class="wp-block-nortic-plugin-province-cloud-list">
                <?php foreach($provinces as $province): ?>
                    <?php 
                        $province_name = $province->name;
                        $province_link = get_term_link($province); 
                        $rd_trabaja_province_id = get_term_meta($province->term_id, 'rd_trabaja_province_id', true); 
                    ?>
                    <li class="wp-block-nortic-plugin-province-cloud-item rd-trabaja-province-<?php echo esc_attr($rd_trabaja_province_id); ?>">
                        <a href="<?php echo esc_url($province_link); ?>">
                            <?php echo esc_html($province->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
<?php 
    $output = ob_get_contents();
    ob_end_clean();
    return $output;


        }
    }
}