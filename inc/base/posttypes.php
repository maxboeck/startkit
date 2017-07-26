<?php
/**
 * Registers A Custom Post Type
 */

namespace Startkit\Posttypes;

class CustomPostType {
	public $post_type_name;
	public $post_type_args;
	public $post_type_labels;
	
	public function __construct( $name, $args = array(), $labels = array() ) {
		$this->post_type_name			= strtolower( str_replace( ' ', '_', $name ) );
		$this->post_type_args 		= $args;
		$this->post_type_labels 	= $labels;

		if( !post_type_exists( $this->post_type_name ) ) {
			add_action( 'init', array( &$this, 'register_post_type' ) );
			add_filter( 'dashboard_glance_items', array( &$this, 'add_to_dashboard' ), 10, 1);
		}
	}
	
	public function register_post_type() {
		$name 		= ucwords( str_replace( '_', ' ', $this->post_type_name ) );
		$plural 	= $name . 's';

		// We set the default labels based on the post type name and plural. We overwrite them with the given labels.
		$labels = array_merge(
			array(
				'name' 								=> _x( $plural, 'post type general name' ),
				'singular_name' 			=> _x( $name, 'post type singular name' ),
				'add_new' 						=> _x( 'Add New', strtolower( $name ) ),
				'add_new_item' 				=> __( 'Add New ' . $name ),
				'edit_item' 					=> __( 'Edit ' . $name ),
				'new_item' 						=> __( 'New ' . $name ),
				'all_items' 					=> __( 'All ' . $plural ),
				'view_item' 					=> __( 'View ' . $name ),
				'search_items' 				=> __( 'Search ' . $plural ),
				'not_found' 					=> __( 'No ' . strtolower( $plural ) . ' found'),
				'not_found_in_trash' 	=> __( 'No ' . strtolower( $plural ) . ' found in Trash'), 
				'parent_item_colon' 	=> '',
				'menu_name' 					=> $plural
			),
			$this->post_type_labels
		);

		$args = array_merge(
			array(
				'labels' 						=> $labels,
				'public' 						=> true,
				'show_ui' 					=> true,
				'supports' 					=> array( 'title', 'editor' ),
				'show_in_nav_menus' => true,
				'show_in_menu' 			=> true,
				'capability_type' 	=> 'post'
			),
			$this->post_type_args
		);

		// Register the post type
		register_post_type($this->post_type_name, $args);
		$this->flush_rewrite_rules();
	}
	
	public function add_taxonomy($name, $args = array(), $labels = array()) {
		if( !empty( $name ) ){

			$post_type_name 	= $this->post_type_name;
			$taxonomy_name		= strtolower( str_replace( ' ', '_', $name ) );
			$taxonomy_labels	= $labels;
			$taxonomy_args		= $args;

			if( !taxonomy_exists( $taxonomy_name ) ){
				$name 		= ucwords( str_replace( '_', ' ', $name ) );
				$plural 	= $name . 's';

				$labels = array_merge(
					array(
						'name' 							=> _x( $plural, 'taxonomy general name' ),
						'singular_name' 		=> _x( $name, 'taxonomy singular name' ),
						'search_items' 			=> __( 'Search ' . $plural ),
						'all_items' 				=> __( 'All ' . $plural ),
						'parent_item' 			=> __( 'Parent ' . $name ),
						'parent_item_colon' => __( 'Parent ' . $name . ':' ),
						'edit_item' 				=> __( 'Edit ' . $name ), 
						'update_item' 			=> __( 'Update ' . $name ),
						'add_new_item' 			=> __( 'Add New ' . $name ),
						'new_item_name' 		=> __( 'New ' . $name . ' Name' ),
						'menu_name' 				=> __( $name ),
					),
					$taxonomy_labels
				);

				// Default arguments, overwitten with the given arguments
				$args = array_merge(
					array(
						'label'							=> $plural,
						'labels'						=> $labels,
						'public' 						=> true,
						'show_ui' 					=> true,
						'show_in_nav_menus' => true,
						'show_admin_column' => true,
						'rewrite' 					=> array(
							'slug' => $taxonomy_name, 
							'with_front' => false
						)
					),
					$taxonomy_args
				);

				// Add the taxonomy to the post type
				add_action( 'init',
					function() use( $taxonomy_name, $post_type_name, $args ){						
						register_taxonomy( $taxonomy_name, $post_type_name, $args );
					}
				);
			}
		}
	}

	public function flush_rewrite_rules() {
		$is_flushed = get_option('post_type_rules_flushed_' . $this->post_type_name);
		if ($is_flushed !== true){
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
			update_option('post_type_rules_flushed_' . $this->post_type_name, true);
		}
	}

	public function add_to_dashboard($items = array()) {
		$num_posts = wp_count_posts( $this->post_type_name );
		if( $num_posts ) {
			$published = intval( $num_posts->publish );
			$post_type = get_post_type_object( $this->post_type_name );
			$text = _n( '%s ' . $post_type->labels->singular_name, '%s ' . $post_type->labels->name, $published, 'startkit' );
			$text = sprintf( $text, number_format_i18n( $published ) );

			if ( current_user_can( $post_type->cap->edit_posts ) ) {
				$output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $text . '</a>';
				echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
			} else {
				$output = '<span>' . $text . '</span>';
				echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
			}
		}
		return $items;
	}
}