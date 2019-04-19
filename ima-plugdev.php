<?php
/**
 * Plugin Name: I'm a Plugin Developer
 * Plugin URI: https://www.bowlhat.net/
 * Description: Showcase the plugins you have in the WordPress.org Plugin Directory
 * Version: 1.0.0
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
 * Called on plugin activation. Includes any php files in ./activate/.
 */
function ima_plugdev_listing_activate() {
	ima_plugdev_listing_init();

	$dir = dirname( __FILE__ ) . '/';
	foreach ( glob( $dir . 'activate/*.php' ) as $filename ) {
		/** @noinspection PhpIncludeInspection */
		require_once( $filename );
	}

	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'ima_plugdev_listing_activate' );

/**
 * Initialises the plugin's functions, partials, javascript and css.
 */
function ima_plugdev_listing_init() {
	$dir = dirname( __FILE__ ) . '/';

	// Common functions.
	foreach ( glob( $dir . 'functions/common/*.php' ) as $filename ) {
		/** @noinspection PhpIncludeInspection */
		require_once( $filename );
	}

	// Functions: always present.
	foreach ( glob( $dir . 'functions/*.php' ) as $filename ) {
		/** @noinspection PhpIncludeInspection */
		require_once( $filename );
	}

	// Partials: only visible outside of admin.
	if ( ! is_admin() && 'wp-login.php' !== $GLOBALS['pagenow'] ) {
		foreach ( glob( $dir . 'partials/*.php' ) as $filename ) {
			/** @noinspection PhpIncludeInspection */
			require_once( $filename );
		}
	}

	// Locale.
	// $locale = get_locale();
	// $lang = substr( $locale, 0, 2 );
	// $country = substr( $locale, 3, 2 );
	//
	// if ( is_readable( $dir . 'languages/' . $lang . '-' . $country . '.php' ) ) {
	// 	require_once( $dir . 'languages/' . $lang . '-' . $country . '.php' );
	// } elseif ( is_readable( $dir . 'languages/' . $lang . '.php' ) ) {
	// 	require_once( $dir . 'languages/' . $lang . '.php' );
	// }

	// Javascripts: autoload.
	if ( is_admin() ) {
		$glob  = glob( $dir . 'scripts/admin/*.js' );
		$admin = 'admin/';
	} else {
		$glob  = glob( $dir . 'scripts/*.js' );
		$admin = '';
	}

	foreach ( $glob as $filename ) {
		$matches = array();
		preg_match( '!([^/]+).js$!', $filename, $matches );
		$code = 'ima-plugdev-' . $matches[1];
		$url  = plugins_url( 'scripts/' . $admin . $matches[1] . '.js', __FILE__ );
		wp_enqueue_script( $code, $url, array( 'jquery' ), null, true );
	}

	// CSS: autoload.
	$glob = glob( $dir . '*.css' );

	foreach ( $glob as $filename ) {
		$matches = array();
		preg_match( '!([^/]+).css!', $filename, $matches );
		$code = 'ima-plugdev-css-' . $matches[1];
		$url  = plugins_url( $matches[1] . '.css', __FILE__ );

		if ( 'admin' !== $matches[1] || is_admin() ) {
			wp_enqueue_style( $code, $url );
		}
	}
}
add_action( 'plugins_loaded', 'ima_plugdev_listing_init' );

/**
 * Automatically registers this plugin's widgets.
 */
function ima_plugdev_listing_widgets() {
	$dir = dirname( __FILE__ ) . '/';

	foreach ( glob( $dir . 'widgets/*.php' ) as $filename ) {
		/** @noinspection PhpIncludeInspection */
		require_once( $filename );

		$filename = substr( $filename, 0, strlen( $filename ) - strlen( '.php' ) );
		$filename = substr( $filename, strrpos( $filename, '/' ) + 1 );
		$filename = str_replace( '-', '_', $filename );
		register_widget( $filename );
	}
}
add_action( 'widgets_init', 'ima_plugdev_listing_widgets' );
