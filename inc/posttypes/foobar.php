<?php
/**
 * Register Foobar Post Type (Example)
 */

namespace Startkit\Posttypes\Foobar;
use Startkit\Posttypes\CustomPostType;

$foobar = new CustomPostType(
	'foobar',
	array(
		'supports' 	=> array( 'title', 'editor', 'thumbnail' ),
		'public'		=> false
	)
);

$foobar->add_taxonomy(
	'baz',
	array(
		'hierarchical' => true
	)
);

function edit_columns($columns){
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => "Name",
		"foo" => "Foo Label",
		"date" => "Datum"
		);
	return $columns;
}
add_filter('manage_edit-foobar_columns', __NAMESPACE__ . '\\edit_columns');

function column_content($column){
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
add_action('manage_posts_custom_column',  __NAMESPACE__ . '\\column_content');