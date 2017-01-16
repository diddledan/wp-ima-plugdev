<?php
function ima_plugdev_get_slug( $post_id ) {
	$slug = get_post_meta( $post_id, '_ima_plugdev_slug', true );
	if ( ! $slug ) {
		$post = get_post( $post_id );
		$slug = $post->post_name;
	}
	return $slug;
}

function ima_plugdev_metaboxes() {
	add_meta_box( 'ima_plugdev', __( 'WordPress.org Plugin Details' ), 'ima_plugdev_metabox', 'my-plugin', 'normal' );
}

function ima_plugdev_metabox() {
	global $post;

	wp_nonce_field( 'ima-plugdev', '_ima_plugdev_nonce' );

	$slug = get_post_meta( $post->ID, '_ima_plugdev_slug', true );
	$retired = get_post_meta( $post->ID, '_ima_plugdev_retired', true );
	?>
	<div>
		<label for="_ima_plugdev_slug"><?php _e( 'Plugin slug at the WordPress.org Plugins Directory', 'ima-plugdev' ); ?></label>
		<input type="text" id="_ima_plugdev_slug" name="_ima_plugdev_slug" value="<?php echo esc_attr( $slug ); ?>" class="widefat" />
	</div>
	<div>
		<label for="_ima_plugdev_retired"><?php _e( 'Plugin is retired', 'ima-plugdev' ); ?></label>
		<input type="checkbox" id="_ima_plugdev_retired" name="_ima_plugdev_retired" <?php echo ( '1' === $retired ) ? 'checked' : ''; ?> />
	</div>
	<?php
}

add_action( 'save_post_my-plugin', 'ima_plugdev_save_post', 10, 2 );
function ima_plugdev_save_post( $post_id, $post ) {
	if ( ! wp_verify_nonce( $_POST['_ima_plugdev_nonce'], 'ima-plugdev' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post->ID ) ) {
		return;
	}

	$slug = sanitize_title( $_POST['_ima_plugdev_slug'] );
	if ( ! empty( $slug ) ) {
		update_post_meta( $post_id, '_ima_plugdev_slug', $slug );
		ima_plugdev_fetch_readme( $post_id );
	} else {
		delete_post_meta( $post_id, '_ima_plugdev_slug' );
	}

	$retired = ( 'on' === $_POST['_ima_plugdev_retired'] ) ? 1 : 0;
	update_post_meta( $post_id, '_ima_plugdev_retired', $retired );
}