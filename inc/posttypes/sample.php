<?php
// ===============================
// REGISTER POST TYPE: foobar (REPLACE THIS)
// ===============================

add_action( 'init', 'register_cpt_foobar' );
function register_cpt_foobar() {
	$labels = array(
		'name' => _x( 'Foobars', 'foobar' ),
		'singular_name' => _x( 'Foobar', 'foobar' ),
		'add_new' => _x( 'Hinzufügen', 'foobar' ),
		'add_new_item' => _x( 'Neuen Foobar hinzufügen', 'foobar' ),
		'edit_item' => _x( 'Foobar bearbeiten', 'foobar' ),
		'new_item' => _x( 'Neuer Foobar', 'foobar' ),
		'view_item' => _x( 'Foobar anzeigen', 'foobar' ),
		'search_items' => _x( 'Foobar durchsuchen', 'foobar' ),
		'not_found' => _x( 'Keine Foobar gefunden', 'foobar' ),
		'not_found_in_trash' => _x( 'Keine Foobar im Papierkorb gefunden', 'foobar' ),
		'parent_item_colon' => _x( 'Übergeordneter Foobar:', 'foobar' ),
		'menu_name' => _x( 'Foobar', 'foobar' ),
		);
	$args = array(
		'labels' => $labels,
		'hierarchical' => false,
		'description' => 'Ein Beispiel für einen Custom Post Type',
		'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt' ),
		'taxonomies' => array( 'type' ),
		'public' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'menu_position' => 6,
		'menu_icon' => 'dashicons-groups',
		'show_in_nav_menus' => true,
		'publicly_queryable' => true,
		'exclude_from_search' => false,
		'has_archive' => true,
		'query_var' => true,
		'can_export' => true,
		'rewrite' => true,
		'capability_type' => 'post'
		);
	register_post_type( 'foobar', $args );
	
	
	// custom taxonomies
	/*
	register_taxonomy('type',
	 array('foobar'), 
	 array(
		'hierarchical' => true,
		'label' => 'Typ',
		'show_ui' => true,
		'query_var' => true,
		'show_in_nav_menus' => true,
		'show_admin_column' => true,
		'rewrite' => array('slug' => 'type', 'with_front' => false)
	  ));
	*/

	$set = get_option('post_type_rules_flushed_foobar');
	if ($set !== true){
		global $wp_rewrite;
  	$wp_rewrite->flush_rules();
		update_option('post_type_rules_flushed_foobar',true);
	}
}


// ===============================
// CUSTOM ADMIN COLUMNS
// ===============================

add_action("manage_posts_custom_column",  "foobar_custom_columns");
add_filter("manage_edit-foobar_columns", "foobar_edit_columns");

function foobar_edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Name",
		"foo" => "Foo Label",
		"date" => "Datum"
		);
	return $columns;
}

function foobar_custom_columns($column){
	global $post;
	
	switch ($column) {
		case "foo":
		//do something
		break;
		case "bar":
		//do something
		break;
	}
}

// ===============================
// ADD POST TYPE TO 'AT A GLANCE'
// ===============================

add_filter( 'dashboard_glance_items', 'custom_glance_items', 10, 1 );
function custom_glance_items( $items = array() ) {
	$post_types = array( 'foobar' );
	foreach( $post_types as $type ) {
		if( ! post_type_exists( $type ) ) continue;
		$num_posts = wp_count_posts( $type );
		if( $num_posts ) {
			$published = intval( $num_posts->publish );
			$post_type = get_post_type_object( $type );
			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'mxb_textdomain' );
			$text = sprintf( $text, number_format_i18n( $published ) );
			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
				echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
			} else {
				$output = '<span>' . $text . '</span>';
				echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
			}
		}
	}
	return $items;
}
