<?php
function ima_plugdev_fetch_readme( $post_id = 0 ) {
	static $cache = array();

	if ( 0 === $post_id ) {
		$post_id = get_the_ID();
	}

	$slug = ima_plugdev_get_slug( $post_id );

	if ( $cache[ $slug ] ) {
		return $cache[ $slug ];
	}
	$rm = get_post_meta( $post_id, '_ima_plugdev_readme', true );
	if ( $rm ) {
		if ( $rm['timestamp'] > time() - 7200 ) {
			$cache[ $slug ] = $rm['readme'];
			return $rm['readme'];
		}
	}

	require_once( ABSPATH . '/wp-admin/includes/plugin-install.php' );
	$readme = plugins_api( 'plugin_information', array( 'slug'   => $slug,
	                                                    'fields' => array( 'short_description' => true )
	) );
	if ( is_wp_error( $readme ) ) {
		return false;
	}

	$readme->banners = array();
	foreach ( array( '1544x500', '772x250' ) as $size ) {
		foreach ( array( 'png', 'jpg' ) as $extension ) {
			$url    = "https://plugins.svn.wordpress.org/{$slug}/assets/banner-{$size}.{$extension}";
			$result = wp_remote_head( $url );
			if ( ! is_wp_error( $result ) && 200 == $result['response']['code'] ) {
				$readme->banners[ $size ] = $url;
			}
		}
	}
	foreach ( array( '256x256', '128x128' ) as $size ) {
		foreach ( array( 'png', 'jpg' ) as $extension ) {
			$url    = "https://plugins.svn.wordpress.org/{$slug}/assets/icon-{$size}.{$extension}";
			$result = wp_remote_head( $url );
			if ( ! is_wp_error( $result ) && 200 == $result[ 'response' ][ 'code' ] ) {
				$readme->logos[ $size ] = $url;
			}
		}
	}

	$cache[ $slug ] = $readme;
	update_post_meta( $post_id, '_ima_plugdev_readme', array( 'timestamp' => time(), 'readme' => $readme ) );

	return $readme;
}