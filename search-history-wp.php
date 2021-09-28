<?php

/**
 * Plugin Name:       Search History
 * Plugin URI:        https://github.com/obuxim/search-history-wp
 * Description:       Saves all the search history in database and exposes endpoint to fetch search history
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Zubair Hasan
 * Author URI:        https://zubairhasan.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       zh
 */

// Use prefix "zh_" everywhere in the plugin for security and compatibility

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 */
define( 'SEARCH_HISTORY_VERSION', '1.0.0' );

// While plugin is activated
register_activation_hook( __FILE__, 'zh_activate_plugin' );

function zh_activate_plugin() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'search_history';
    $sql = "CREATE TABLE $table_name (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      search_time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      keyword tinytext NOT NULL,
      PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
}

// While Deactivating Plugin
register_deactivation_hook( __FILE__, 'zh_deactivate_plugin' );
function zh_deactivate_plugin() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'search_history';
    $sql = "DROP TABLE IF EXISTS $table_name";
    $wpdb->query($sql);
}


// Save Search
function zh_save_search( $query_object )
{
    if( $query_object->is_search() ) {
        $keyword = $query_object->query['s'];
        global $wpdb;
        $table_name = $wpdb->prefix . 'search_history';
        $wpdb->insert($table_name, array(
            'search_time' => date('Y-m-d H:i:s'),
            'keyword' => $keyword
        ));
    }
}

add_action( 'parse_query', 'zh_save_search' );


// Register an endpoint and give search history.
add_action('rest_api_init', 'zh_search_history_api');
function zh_search_history_api(){
    register_rest_route('zh/v1', '/search-history', array(
        'methods' => 'GET',
        'callback' => 'zh_search_history_callback',
        'permission_callback' => '__return_true'
    ));
}

function zh_search_history_callback(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'search_history';
    $results = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name", ARRAY_A));
    $response = new stdClass();
    $response->version = '1.0';
    $response->author = "Zubair Hasan";
    $response->author_url = "https://zubairhasan.com";
    $response->plugin_url = "https://github.com/obuxim/search-history-wp";
    $response->data = $results;

    $wpResponse = new WP_REST_Response($response, array('headers' => array('Content-Type' => 'application/json')));
    return $wpResponse;
}