<?php
/**
 * Plugin Name: I'm a Plugin Developer
 * Plugin URI: https://www.bowlhat.net/
 * Description: Showcase the plugins you have in the WordPress.org Plugin Directory
 * Version: 2.2.0
 * Author: Daniel Llewellyn
 * Author URI: https://www.bowlhat.net
 * License: GPLv2
 * Text Domain: ima-plugdev
 * @package  ima-plugdev
 */

if ( ! defined( 'IMAPLUGDEVLOG' ) ) {
	define( 'IMAPLUGDEVLOG', false );
}

/**
 * Called on plugin activation. Includes activation files in ./activate/.
 */
function ima_plugdev_listing_activate() {
	require join( DIRECTORY_SEPARATOR, array( __DIR__, 'activate', 'post-type.php' ) );
}
register_activation_hook( __FILE__, 'ima_plugdev_listing_activate' );

require join( DIRECTORY_SEPARATOR, array( __DIR__, 'functions', 'plugin-api.php' ) );
require join( DIRECTORY_SEPARATOR, array( __DIR__, 'functions', 'plugin-post-meta.php' ) );
require join( DIRECTORY_SEPARATOR, array( __DIR__, 'functions', 'post-type.php' ) );

require join( DIRECTORY_SEPARATOR, array( __DIR__, 'partials', 'plugin-content.php' ) );

function ima_plugdev_enqueue_styles() {
	wp_enqueue_style( 'ima-plugdev', plugins_url( 'ima-plugdev.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'ima_plugdev_enqueue_styles' );
