<?php
add_filter( 'the_content', 'ima_plugdev_the_content_filter' );
function ima_plugdev_the_content_filter( $content ) {
	if ( is_singular( 'my-plugin' ) ) {
		remove_filter( 'the_content', 'do_shortcode', 11 );
	    unset( $content );
		if ( ! ima_plugdev_fetch_readme() ) {
			return __( 'Could not load plugin readme.txt from WordPress.org', 'ima-plugdev' );
		}
		ob_start();
		if ( locate_template( 'content-my-plugin.php', false ) ) {
			get_template_part( 'content', 'my-plugin' );
		} else {
		    include( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'content-my-plugin.php' );
        }
		return ob_get_clean();
	}
	if ( is_post_type_archive( 'my-plugin' ) ) {
		remove_filter( 'the_content', 'do_shortcode', 11 );
	    unset( $content );
		ob_start();
		if ( locate_template( 'excerpt-my-plugin.php', false ) ) {
			get_template_part( 'excerpt', 'my-plugin' );
		} else {
			include( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'excerpt-my-plugin.php' );
		}
		return ob_get_clean();
	}
	return $content;
}

add_filter( 'get_the_excerpt', 'ima_plugdev_the_excerpt_filter', 10, 2 );
function ima_plugdev_the_excerpt_filter( $excerpt, $post ) {
	if ( 'my-plugin' === $post->post_type ) {
		unset( $excerpt );
		unset( $post );
		ob_start();
		if ( locate_template( 'excerpt-my-plugin.php', false ) ) {
			get_template_part( 'excerpt', 'my-plugin' );
		} else {
			include( dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'excerpt-my-plugin.php' );
		}
		return ob_get_clean();
	}
	return $excerpt;
}

function get_ima_plugdev_plugin_version( $post_id = 0 ) {
	$readme = ima_plugdev_fetch_readme( $post_id );
	return isset( $readme->version ) ? $readme->version : '';
}
function the_ima_plugdev_plugin_version() {
	echo esc_html( get_ima_plugdev_plugin_version() );
}

function get_ima_plugdev_plugin_retired( $post_id = 0 ) {
	global $post;
	if ( 0 === $post_id ) {
		$post_id = $post->ID;
	}
	return ( '1' === get_post_meta( $post_id, '_ima_plugdev_retired', true ) ) ? true : false;
}

function get_ima_plugdev_plugin_zip( $post_id = 0 ) {
	$readme = ima_plugdev_fetch_readme( $post_id );
	return isset( $readme->download_link ) ? $readme->download_link : '';
}
function the_ima_plugdev_plugin_zip() {
	echo esc_url( get_ima_plugdev_plugin_zip() );
}

function get_ima_plugdev_plugin_description( $post_id = 0 ) {
	$readme = ima_plugdev_fetch_readme( $post_id );
	return isset( $readme->sections['description'] ) ? $readme->sections['description'] : '';
}
function the_ima_plugdev_plugin_description() {
	echo get_ima_plugdev_plugin_description();
}

function get_ima_plugdev_plugin_excerpt( $post_id = 0 ) {
	$readme = ima_plugdev_fetch_readme( $post_id );
	if ( isset( $readme->short_description ) && !empty( $readme->short_description ) ) {
		return $readme->short_description;
	}
	return '';
}
function the_ima_plugdev_plugin_excerpt() {
	echo get_ima_plugdev_plugin_excerpt();
}

function have_ima_plugdev_plugin_banner( $post_id = 0 ) {
	return '' !== get_ima_plugdev_plugin_banner_url( '1x', $post_id );
}
function get_ima_plugdev_plugin_banner_url( $size = '1x', $post_id = 0 ) {
	$sizes = array( '1x' => '772x250', '2x' => '1544x500' );
	$dimensions = $sizes[ $size ];

	$readme = ima_plugdev_fetch_readme( $post_id );
	if ( isset( $readme->banners[ $dimensions ] ) ) {
		return $readme->banners[ $dimensions ];
	}
	return '';
}
function get_ima_plugdev_plugin_banner( $post_id = 0 ) {
	$banner = get_ima_plugdev_plugin_banner_url( '1x', $post_id );
	$banner2x = get_ima_plugdev_plugin_banner_url( '2x', $post_id );
	if ( '' !== $banner ) {
		return '<img alt="' . esc_attr( sprintf( __( 'Banner for the %s plugin', 'ima-plugdev' ), get_the_title( $post_id ) ) ) . '" ' .
		       'src="' . esc_attr( $banner ) . '" ' .
		       ( ( $banner2x ) ? 'srcset="' . esc_attr( $banner2x ) . ' 2x" ' : '' ) .
		       '/>';
	}
	return '';
}
function the_ima_plugdev_plugin_banner( $post_id = 0 ) {
	echo get_ima_plugdev_plugin_banner( $post_id );
}

function have_ima_plugdev_plugin_logo( $post_id = 0 ) {
	return ( '' !== get_ima_plugdev_plugin_logo_url( '1x', $post_id ) );
}
function get_ima_plugdev_plugin_logo_url( $size = '1x', $post_id = 0 ) {
	$sizes = array( '1x' => '128x128', '2x' => '256x256' );
	$dimensions = $sizes[ $size ];

	$readme = ima_plugdev_fetch_readme( $post_id );
	if ( isset( $readme->logos[ $dimensions ] ) ) {
		return $readme->logos[ $dimensions ];
	}
	return '';
}
function get_ima_plugdev_plugin_logo( $post_id = 0 ) {
	$logo = get_ima_plugdev_plugin_logo_url( '1x', $post_id );
	$logo2x = get_ima_plugdev_plugin_logo_url( '2x', $post_id );
	if ( '' !== $logo ) {
		return '<img alt="' . esc_attr( sprintf( __( '%s plugin logo', 'ima-plugdev' ), get_the_title( $post_id ) ) ) . '" ' .
		       'src="' . esc_attr( $logo ) . '" ' .
		       ( ( $logo2x ) ? 'srcset="' . esc_attr( $logo2x ) . ' 2x" ' : '' ) .
		       '/>';
	}
	return '';
}
function the_ima_plugdev_plugin_logo( $post_id = 0 ) {
	echo get_ima_plugdev_plugin_logo( $post_id );
}
