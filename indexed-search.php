<?php
/**
 * Plugin Name: Indexed Search
 * Plugin URI: https://github.com/wp-blocks/indexed-search
 * Description: An advanced WordPress indexed search.
 * Version: 0.1.0
 * Requires at least: 6.2
 * Requires PHP: 7.4
 * Author: codekraft, bitmachina
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: indexed-search
 * Domain Path: /languages
 */

 if ( version_compare( phpversion(), '7.4.0', '<' ) ) {

	/**
	 * @return void
	 */
	function indexed_search_minimum_php_version_notice() {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Indexed Search requires PHP 7.4 or higher.', 'indexed-search' ) . '</p></div>';
	}

	add_action( 'admin_notices', 'indexed_search_minimum_php_version_notice' );

	return;
}

if ( version_compare( $GLOBALS['wp_version'], '6.2', '<' ) ) {
	/**
	 * @return void
	 */
	function indexed_search_minimum_wp_version_notice() {
		echo '<div class="notice notice-error"><p>' . esc_html__( 'Indexed Search requires WordPress 6.2 or later.', 'indexed-search' ) . '</p></div>';
	}

	add_action( 'admin_notices', 'indexed_search_minimum_wp_version_notice' );

	return;
}

if ( file_exists( __DIR__ . '/vendor-prod/autoload.php' ) ) {
	require_once( __DIR__ . '/vendor-prod/autoload.php' );
}

// Defines the path to the main plugin file.
define( 'S_FILE', __FILE__ );

// Defines the path to be used for includes.
define( 'S_PATH', plugin_dir_path( S_FILE ) );

// Defines the URL to the plugin.
define( 'S_URL', plugin_dir_url( S_FILE ) );

/**
* The block variation
 */
include_once S_PATH . 'src/variation.php';

/**
* The modal window
 */
include_once S_PATH . 'src/modal.php';
add_action( 'wp_footer', 'live_search_modal_window' );

/**
* The rest api controller
 */
include_once S_PATH . 'src/rest.php';
add_action( 'rest_api_init', 'register_live_search_endpoint' );

/**
 * The rest api that will handle the search request
 */
include_once S_PATH . 'src/enqueue.php';
add_action( 'rest_api_init', 'register_live_search_endpoint' );
