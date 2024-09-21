<?php 

if(!function_exists('nortic_plugin_team_template')) {
    function nortic_plugin_team_template($post_content, $post) {
        if($post->post_type === 'team') {
            $template = [
                ['nortic-plugin/team-member-basic-info'],
                ['nortic-plugin/tick-items'],
            ];


            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}

if(!function_exists('nortic_plugin_service_template')) {
    function nortic_plugin_service_template($post_content, $post) {
        if($post->post_type === 'service') {
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


            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}

if(!function_exists('nortic_plugin_dependency_template')) {
    function nortic_plugin_dependency_template($post_content, $post) {
        if($post->post_type === 'dependency') {
            $template = [
                ['nortic-plugin/description'],
                ['nortic-plugin/tick-items'],
                ['nortic-plugin/dependency-responsible-member'],
                ['nortic-plugin/dependency-list'],
                ['nortic-plugin/service-list'],
                ['nortic-plugin/contact-info'],
                ['nortic-plugin/faqs-list'],
            ];


            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}

if(!function_exists('nortic_plugin_newsletter_template')) {
    function nortic_plugin_newsletter_template($post_content, $post) {
        if($post->post_type === 'newsletter') {
            $template = [
                ['nortic-plugin/attached-resource'],
            ];

            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}

if(!function_exists('nortic_plugin_award_template')) {
    function nortic_plugin_award_template($post_content, $post) {
        if($post->post_type === 'award') {
            $template = [
                ['nortic-plugin/description'],
            ];

            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}

if(!function_exists('nortic_plugin_system_template')) {
    function nortic_plugin_system_template($post_content, $post) {
        if($post->post_type === 'system') {
            $template = [
                ['nortic-plugin/alias'],
            ];

            $post_content = serialize_blocks( $template );
        }

        return $post_content;
    }
}