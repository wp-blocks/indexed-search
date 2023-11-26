<?php
/**
 * Plugin Name: Search Block
 * Plugin URI: https://github.com/wp-blocks/search
 * Description: An advanced WordPress block search
 * Version: 0.1.0
 * Author: codekraft, johnhooks
 */
// Defines the path to the main plugin file.
define( 'S_FILE', __FILE__ );

// Defines the path to be used for includes.
define( 'S_PATH', plugin_dir_path( S_FILE ) );

// Defines the URL to the plugin.
define( 'S_URL', plugin_dir_url( S_FILE ) );

/**
* The block variation
 */
include_once S_PATH . 'inc/variation.php';

/**
* The modal window
 */
include_once S_PATH . 'inc/modal.php';
add_action( 'wp_footer', 'live_search_modal_window' );

/**
* The rest api controller
 */
include_once S_PATH . 'inc/rest.php';
add_action( 'rest_api_init', 'register_live_search_endpoint' );

/**
 * The rest api that will handle the search request
 */
include_once S_PATH . 'inc/enqueue.php';
add_action( 'rest_api_init', 'register_live_search_endpoint' );
