<?php

/**
 * @package Nortic_Plugin
 * @version 1.0.0
 * @see https://leonardofabian.com
 */
/*
Plugin Name:       Nortic Plugin
Plugin URI:        https://mt.gob.do
Description:       Extiende la funcionalidad de la plantilla Nortic.
Version:           1.0.0
Requires at least: 5.9
Requires PHP:      7.2
Author:            Leonardo Fabian
Author URI:        https://leonardofabian.com
License:           GPL v2 or later
License URI:       https://www.gnu.org/licenses/gpl-2.0.html
Update URI:        https://mt.gob.do
Text Domain:       nortic-plugin
Domain Path:       /languages
*/

/*
 * HOOKS
 * 
 * post_rated       when user rate a post
 */

if (!function_exists('add_action')) {
    echo 'Hi there! I\'m just a plugin';
    exit;
}

// Setup
define('NORTIC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('NORTIC_PLUGIN_URL', plugin_dir_url(__FILE__));
define('NORTIC_PLUGIN_FILE', __FILE__);
define('NORTIC_PLUGIN_VERSION', '1.0.0');

// Includes
$rootFiles = glob(NORTIC_PLUGIN_DIR . 'includes/*.php');
$subdirectoryFiles = glob(NORTIC_PLUGIN_DIR . 'includes/**/*.php');
$subdirectorySubdirectoriesFiles = glob(NORTIC_PLUGIN_DIR . 'includes/**/**/*.php');
$allFiles = array_merge($rootFiles, $subdirectoryFiles, $subdirectorySubdirectoriesFiles);

foreach ($allFiles as $filename) {
    include_once($filename);
}

// Hooks
register_activation_hook(__FILE__, 'nortic_plugin_activation');
register_deactivation_hook(__FILE__, 'nortic_plugin_deactivation');
// register_uninstall_hook(__FILE__, 'nortic_plugin_uninstall');
add_action('init', 'nortic_plugin_register_blocks');
# rest API
add_action('rest_api_init', 'nortic_plugin_rest_api_init');

function load_dashicons()
{
    wp_enqueue_style('dashicons');
}
add_action('wp_enqueue_scripts', 'load_dashicons');

function clear_block_theme_cache() {
    wp_cache_delete( 'global_styles', 'global_styles' );
}
add_action( 'init', 'clear_block_theme_cache' );

# content
add_action('init', 'nortic_plugin_content_post_type');
add_action('save_post_content', 'nortic_plugin_save_post_content');

# category form fields
add_action('category_add_form_fields', 'nortic_plugin_category_add_form_fields');
add_action('category_edit_form_fields', 'nortic_plugin_category_edit_form_fields');
add_action('create_category', 'nortic_plugin_save_category_meta');
add_action('edited_category', 'nortic_plugin_save_category_meta');

# dependency
add_action('init', 'nortic_plugin_dependency_post_type');
add_action('save_post_dependency', 'nortic_plugin_save_post_dependency');
add_action('init', 'nortic_plugin_area_taxonomy');
add_action('init', 'nortic_plugin_province_taxonomy');
add_action('init', 'nortic_plugin_dependency_category_taxonomy');
add_action('area_add_form_fields', 'nortic_plugin_area_add_form_fields');
add_action('area_edit_form_fields', 'nortic_plugin_area_edit_form_fields');
add_action('create_area', 'nortic_plugin_save_area_meta');
add_action('edited_area', 'nortic_plugin_save_area_meta');

add_action('province_add_form_fields', 'nortic_plugin_province_add_form_fields');
add_action('province_edit_form_fields', 'nortic_plugin_province_edit_form_fields');
add_action('create_province', 'nortic_plugin_save_province_meta');
add_action('edited_province', 'nortic_plugin_save_province_meta');

# system
add_action('init', 'nortic_plugin_system_post_type');
add_action('save_post_system', 'nortic_plugin_save_post_system');

# document
add_action('init', 'nortic_plugin_document_post_type');
add_action('save_post_document', 'nortic_plugin_save_post_document');
add_action('init', 'nortic_plugin_directory_taxonomy');
add_action('directory_add_form_fields', 'nortic_plugin_directory_add_form_fields');
add_action('directory_edit_form_fields', 'nortic_plugin_directory_edit_form_fields');
add_action('create_directory', 'nortic_plugin_save_directory_meta');
add_action('edited_directory', 'nortic_plugin_save_directory_meta');

#resource
add_action('init', 'nortic_plugin_resource_post_type');

# team
add_action('init', 'nortic_plugin_team_post_type');
add_action('save_post_team', 'nortic_plugin_save_post_team');
add_action('init', 'nortic_plugin_group_taxonomy');

# resolution
add_action('init', 'nortic_plugin_resolution_post_type');
add_action('save_post_resolution', 'nortic_plugin_save_post_resolution');
add_action('init', 'nortic_plugin_resolution_category_taxonomy');

# service
add_action('init', 'nortic_plugin_service_post_type');
add_action('save_post_service', 'nortic_plugin_save_post_service');
add_action('init', 'nortic_plugin_service_classification_taxonomy');
add_action('init', 'nortic_plugin_service_tag_taxonomy');

# event
add_action('init', 'nortic_plugin_event_post_type');
add_action('save_post_event', 'nortic_plugin_save_post_event');

# achievement
add_action('init', 'nortic_plugin_achievement_post_type');
add_action('save_post_achievement', 'nortic_plugin_save_post_achievement');

# awards
add_action('init', 'nortic_plugin_award_post_type');
add_action('save_post_award', 'nortic_plugin_save_post_award');
add_action('init', 'nortic_plugin_award_category_taxonomy');

# FAQ
add_action('init', 'nortic_plugin_faq_post_type');
add_action('save_post_faq', 'nortic_plugin_save_post_faq');
add_action('init', 'nortic_plugin_faq_category_taxonomy');

# newsletters 
add_action('init', 'nortic_plugin_newsletter_post_type');
add_action('save_post_newsletter', 'nortic_plugin_save_post_newsletter');
add_action('init', 'nortic_plugin_newsletter_category_taxonomy');

# gallery 
add_action('init', 'nortic_plugin_gallery_post_type');


// add_action('init', 'nortic_plugin_service_sidebar');
add_action('after_setup_theme', 'nortic_plugin_setup_theme');
// add_action('init', 'nortic_plugin_session_start');

#Menus
add_action('admin_menu', 'nortic_plugin_admin_menus');
add_action('admin_post_np_save_options', 'nortic_plugin_save_options');
add_action('admin_post_np_opengraph_save_options', 'nortic_plugin_opengraph_save_options');
add_action('admin_post_np_chatbot_save_options', 'nortic_plugin_chatbot_save_options');
// add_action('admin_init', 'nortic_plugin_settings_api');

#Scripts
add_action('admin_enqueue_scripts', 'nortic_plugin_admin_enqueue_scripts');
add_action('wp_enqueue_scripts', 'nortic_plugin_enqueue_scripts');

# Assets
add_action('init', 'nortic_plugin_register_assets');
add_action('enqueue_block_editor_assets', 'nortic_plugin_enqueue_block_editor_assets');

# Metaboxes
add_action('add_meta_boxes', 'nortic_plugin_add_meta_boxes');

# Head tags
add_action('wp_head', 'nortic_plugin_wp_head');



# Translations
add_action('init', 'nortic_plugin_load_php_translations');
add_action('wp_enqueue_scripts', 'nortic_plugin_block_translations', 100);

# emails

add_action('init', 'nortic_plugin_contact_form');

// rewrite rules
// add_action('init', 'nortic_plugin_add_rewrite_rules');

// edit custom post type templates
add_action('init', 'nortic_plugin_service_edit_template');

/* Filters */

add_filter('image_size_names_choose', 'nortic_plugin_image_size_names_choose');
add_filter('rest_service_query', 'nortic_plugin_rest_service_query', 10, 2);
add_filter('rest_document_query', 'nortic_plugin_rest_document_query', 10, 2);
add_filter('rest_dependency_query', 'nortic_plugin_rest_dependency_query', 10, 2);

// query vars 
add_filter('query_vars', 'nortic_plugin_add_query_vars');

// template include
add_filter('template_include', 'nortic_plugin_template_include');

// customize gutenberg blocks
add_filter('get_the_archive_title', 'nortic_plugin_custom_archive_title');

// create posts custom templates
add_filter('default_content', 'nortic_plugin_service_template', 10, 2);
add_filter('default_content', 'nortic_plugin_dependency_template', 10, 2);
add_filter('default_content', 'nortic_plugin_team_template', 10, 2);
add_filter('default_content', 'nortic_plugin_newsletter_template', 10, 2);
add_filter('default_content', 'nortic_plugin_award_template', 10, 2);
add_filter('default_content', 'nortic_plugin_system_template', 10, 2);

// add new posts apply custom templates
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_service', 10, 3);
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_dependency', 10, 3);
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_team', 10, 3);
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_newsletter', 10, 3);
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_award', 10, 3);
add_filter('rest_after_insert_post', 'nortic_plugin_rest_after_insert_new_system', 10, 3);

// MT CMS API ENDPOINTS 
add_action('rest_api_init', function () {
    register_rest_route('nortic/v1', '/departamentos', [
        'methods' => 'GET',
        'callback' => 'nortic_plugin_fetch_departamentos',
    ]);
});