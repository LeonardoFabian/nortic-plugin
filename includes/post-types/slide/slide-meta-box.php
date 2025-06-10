<?php

if (!function_exists('nortic_register_slide_metabox')) {
    function nortic_register_slide_metabox() {
        add_meta_box(
            'nortic_slide_metabox',                        
            __('Slide settings', 'nortic-plugin'),            
            'nortic_render_slide_metabox_callback',        
            'slide',                               
            'side',                            
            'default'                                  
        );
    }    
};

if (!function_exists('nortic_render_slide_metabox_callback')) {
    function nortic_render_slide_metabox_callback($post) {
        wp_nonce_field('nortic_save_slide_metabox_data', 'nortic_slide_metabox_nonce');

        $description = get_post_meta($post->ID, 'description', true); 
        $url = get_post_meta($post->ID, 'url', true); 
        $url_label = get_post_meta($post->ID, 'url_label', true); 
        $template_style = get_post_meta($post->ID, 'template_style', true);
        $template_image_url = NORTIC_PLUGIN_URL . '/dist/public/images/templates/' . $template_style . '.png';


        ?>

        <div style="display: flex; flex-direction: column; gap: 4px;">
            <label for="description"><?php echo __('Description', 'nortic-plugin'); ?></label>
            <textarea name="description" rows="3"><?php  echo esc_attr($description); ?></textarea>

            <label for="url"><?php echo __('URL', 'nortic-plugin'); ?></label>
            <input type="text" name="url" value="<?php echo esc_attr($url); ?>" />

            <label for="url_label"><?php echo __('URL label', 'nortic-plugin'); ?></label>
            <input type="text" name="url_label" value="<?php echo esc_attr($url_label); ?>" />

            <label for="template_style"><?php echo __('Template', 'nortic-plugin') ?></label>
            <select name="template_style" value="<?php echo esc_attr($template_style); ?>">
                <option value=""><?php echo __('Select template', 'nortic-plugin'); ?></option>
                <option value="image-full-width"><?php echo __('Full width image', 'nortic-plugin'); ?></option>
                <option value="image-with-blocks"><?php echo __('Image with blocks', 'nortic-plugin'); ?></option>
            </select>

            <?php if ($template_style) { ?>
                <div>
                    <figure>
                        <img src="<?php echo esc_attr($template_image_url); ?>" alt="<?php echo esc_attr($template_style); ?>" style="width: 100%;" />
                        <caption><?php echo __('Template preview', 'nortic-plugin'); ?></caption>
                    </figure>
                </div>
            <?php } ?>
        </div>

        <?php 
    }
}

if (!function_exists('nortic_save_slide_metabox_data')) {
    function nortic_save_slide_metabox_data($post_id) {

        $post_type = get_post_type($post_id);
        if ($post_type !== 'slide') {
            return;
        }

        if (
            !isset($_POST['description']) || 
            !isset($_POST['url']) || 
            !isset($_POST['url_label']) ||
            !wp_verify_nonce($_POST['nortic_slide_metabox_nonce'], 'nortic_save_slide_metabox_data')
        ) {
            return;
        }

        if (defined('DOING_AUTOSAVE') &&  DOING_AUTOSAVE ) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        if (
            isset($_POST['description'])
      
        ) {
            update_post_meta($post_id, 'description', sanitize_textarea_field( $_POST['description'] ));
           
        }

        if ( isset($_POST['url']) ) {
            update_post_meta($post_id, 'url', esc_url_raw( $_POST['url'] ));
            
        }

        if ( isset($_POST['url_label']) ) {
            update_post_meta($post_id, 'url_label', sanitize_text_field( $_POST['url_label'] ));
            
        }

        if ( isset($_POST['template_style']) ) {
            update_post_meta($post_id, 'template_style', sanitize_text_field( $_POST['template_style'] ));            
        }
    }
}