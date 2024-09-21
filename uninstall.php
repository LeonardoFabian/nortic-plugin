<?php

// WordPress create this constant when uninstall a plugin
if (!defined("WP_UNINSTALL_PLUGIN")) {
    exit;
}

# delete options

delete_option('nortic_plugin_options');
delete_option('nortic_plugin_opengraph_options');
delete_option('nortic_plugin_chatbot_options');

# delete tables

global $wpdb;

// query dosn't return value
$wpdb->query(
    "DROP TABLE IF EXISTS {$wpdb->prefix}nortic_plugin_ratings"
);
$wpdb->query(
    "DROP TABLE IF EXISTS {$wpdb->prefix}nortic_plugin_documents"
);
$wpdb->query(
    "DROP TABLE IF EXISTS {$wpdb->prefix}nortic_plugin_locations"
);
$wpdb->query(
    "DROP TABLE IF EXISTS {$wpdb->prefix}nortic_plugin_contacts"
);
$wpdb->query(
    "DROP TABLE IF EXISTS {$wpdb->prefix}nortic_plugin_chatbot_messages"
);
