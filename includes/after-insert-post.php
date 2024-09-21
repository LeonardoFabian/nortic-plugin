<?php 

if(!function_exists('nortic_plugin_rest_after_insert_new_service')) {
    function nortic_plugin_rest_after_insert_new_service($post, $request, $creating) {
        if($creating && $post->post_type === 'service') {
            $template = [
                ['nortic-plugin/service-delivery-channels'],
                ['nortic-plugin/alias'],
                ['nortic-plugin/description'],
                ['nortic-plugin/information'],
                ['nortic-plugin/tick-items'],
                ['nortic-plugin/target-audience'],
                ['nortic-plugin/service-responsible-info'],
                ['nortic-plugin/service-summary'],
                ['nortic-plugin/additional-information'],
                ['nortic-plugin/faqs-list']
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}

if(!function_exists('nortic_plugin_rest_after_insert_new_dependency')) {
    function nortic_plugin_rest_after_insert_new_dependency($post, $request, $creating) {
        if($creating && $post->post_type === 'dependency') {
            $template = [
                ['nortic-plugin/description'],
                ['nortic-plugin/tick-items'],
                ['nortic-plugin/dependency-responsible-member'],
                ['nortic-plugin/dependency-list'],
                ['nortic-plugin/service-list'],
                ['nortic-plugin/contact-info'],
                ['nortic-plugin/faqs-list'],
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}

if(!function_exists('nortic_plugin_rest_after_insert_new_team')) {
    function nortic_plugin_rest_after_insert_new_team($post, $request, $creating) {
        if($creating && $post->post_type === 'team') {
            $template = [
                ['nortic-plugin/team-member-basic-info'],
                ['nortic-plugin/tick-items'],
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}

if(!function_exists('nortic_plugin_rest_after_insert_new_newsletter')) {
    function nortic_plugin_rest_after_insert_new_newsletter($post, $request, $creating) {
        if($creating && $post->post_type === 'newsletter') {
            $template = [
                ['nortic-plugin/attached-resource'],
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}

if(!function_exists('nortic_plugin_rest_after_insert_new_award')) {
    function nortic_plugin_rest_after_insert_new_award($post, $request, $creating) {
        if($creating && $post->post_type === 'award') {
            $template = [
                ['nortic-plugin/description'],
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}

if(!function_exists('nortic_plugin_rest_after_insert_new_system')) {
    function nortic_plugin_rest_after_insert_new_system($post, $request, $creating) {
        if($creating && $post->post_type === 'system') {
            $template = [
                ['nortic-plugin/alias'],
            ];

            $post->post_content = serialize_blocks($template);
            wp_update_post($post);
        }
    }
}