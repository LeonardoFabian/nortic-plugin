<?php 

if(!function_exists('nortic_plugin_service_edit_template')) {
    function nortic_plugin_service_edit_template() {
        $post_type = 'service';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
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
    }
}

if(!function_exists('nortic_plugin_dependency_edit_template')) {
    function nortic_plugin_dependency_edit_template() {
        $post_type = 'dependency';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
            ['nortic-plugin/description'],
                ['nortic-plugin/tick-items'],
                ['nortic-plugin/dependency-responsible-member'],
                ['nortic-plugin/dependency-list'],
                ['nortic-plugin/service-list'],
                ['nortic-plugin/contact-info'],
                ['nortic-plugin/faqs-list'],
        ];
    }
}

if(!function_exists('nortic_plugin_team_edit_template')) {
    function nortic_plugin_team_edit_template() {
        $post_type = 'team';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
            ['nortic-plugin/team-member-basic-info'],
            ['nortic-plugin/tick-items'],
        ];
    }
}

if(!function_exists('nortic_plugin_newsletter_edit_template')) {
    function nortic_plugin_newsletter_edit_template() {
        $post_type = 'newsletter';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
            ['nortic-plugin/attached-resource'],
        ];
    }
}

if(!function_exists('nortic_plugin_award_edit_template')) {
    function nortic_plugin_award_edit_template() {
        $post_type = 'award';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
            ['nortic-plugin/description'],
        ];
    }
}

if(!function_exists('nortic_plugin_system_edit_template')) {
    function nortic_plugin_system_edit_template() {
        $post_type = 'system';
        $post_type_object = get_post_type_object($post_type);
        $post_type_object->template = [
            ['nortic-plugin/alias'],
        ];
    }
}