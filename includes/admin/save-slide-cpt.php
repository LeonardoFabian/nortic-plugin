<?php 

/**
 * Fires once a slide has been saved/published 
 * 
 * @author Leonardo Fabian <ramon.fabian@mt.gob.do>
 * @since 1.0.0 2025-06-09
 */
if (!function_exists('nortic_plugin_save_post_slide')) {
    function nortic_plugin_save_post_slide() {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
    }
}