<?php
function ima_plugdev_add_posttype() {
	$labels = array(
		'name'                  => _x( 'My Plugins', 'Post Type General Name', 'ima-plugdev' ),
		'singular_name'         => _x( 'My Plugin', 'Post Type Singular Name', 'ima-plugdev' ),
		'menu_name'             => __( 'My Plugins', 'ima-plugdev' ),
		'name_admin_bar'        => __( 'My Plugin', 'ima-plugdev' ),
		'archives'              => __( 'My Plugin Archives', 'ima-plugdev' ),
		'attributes'            => __( 'My Plugin Attributes', 'ima-plugdev' ),
		'parent_item_colon'     => __( 'Parent Plugin:', 'ima-plugdev' ),
		'all_items'             => __( 'All My Plugins', 'ima-plugdev' ),
		'add_new_item'          => __( 'Add New Plugin', 'ima-plugdev' ),
		'add_new'               => __( 'Add New', 'ima-plugdev' ),
		'new_item'              => __( 'New Plugin', 'ima-plugdev' ),
		'edit_item'             => __( 'Edit Plugin', 'ima-plugdev' ),
		'update_item'           => __( 'Update Plugin', 'ima-plugdev' ),
		'view_item'             => __( 'View Plugin', 'ima-plugdev' ),
		'view_items'            => __( 'View Plugins', 'ima-plugdev' ),
		'search_items'          => __( 'Search Plugins', 'ima-plugdev' ),
		'not_found'             => __( 'Not found', 'ima-plugdev' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'ima-plugdev' ),
		'featured_image'        => __( 'Featured Image', 'ima-plugdev' ),
		'set_featured_image'    => __( 'Set featured image', 'ima-plugdev' ),
		'remove_featured_image' => __( 'Remove featured image', 'ima-plugdev' ),
		'use_featured_image'    => __( 'Use as featured image', 'ima-plugdev' ),
		'insert_into_item'      => __( 'Insert into plugin', 'ima-plugdev' ),
		'uploaded_to_this_item' => __( 'Uploaded to this plugin', 'ima-plugdev' ),
		'items_list'            => __( 'My Plugins list', 'ima-plugdev' ),
		'items_list_navigation' => __( 'My Plugins list navigation', 'ima-plugdev' ),
		'filter_items_list'     => __( 'Filter my plugins list', 'ima-plugdev' ),
	);

	$args = array(
		'label'                => __( 'My Plugin', 'ima-plugdev' ),
		'description'          => __( 'My WordPress.org Plugin', 'ima-plugdev' ),
		'labels'               => $labels,
		'supports'             => array( 'title' ),
		'hierarchical'         => false,
		'public'               => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'menu_position'        => 5,
		'menu_icon'            => 'dashicons-admin-plugins',
		'show_in_admin_bar'    => true,
		'show_in_nav_menus'    => true,
		'can_export'           => true,
		'has_archive'          => true,
		'exclude_from_search'  => false,
		'publicly_queryable'   => true,
		'capability_type'      => 'page',
		'register_meta_box_cb' => 'ima_plugdev_metaboxes',
		'show_in_rest'         => true,
		'rest_base'            => 'plugin',
		'rewrite'              => array( 'slug' => 'plugins' ),
	);

	register_post_type( 'my-plugin', $args );
}
add_action( 'init', 'ima_plugdev_add_posttype', 0 );

function ima_plugdev_add_cpt_to_jetpack_sitemap( $post_types ) {
	$post_types[] = 'my-plugin';
	return $post_types;
}
add_filter( 'jetpack_sitemap_post_types', 'ima_plugdev_add_cpt_to_jetpack_sitemap' );
