<?php

namespace Startkit\Icons;

/**
 * Add SVG definitions to the footer.
 */
function include_icon_sprite() {
  $sprite_file = get_parent_theme_file_path( '/dist/icons/sprite.svg' );
  if(file_exists($sprite_file)){
    $container_style = preg_replace('/\s+/', '', '
      position:absolute;
      width:0;
      height:0;
      overflow:hidden;
    ');
    echo '<div id="svg-icon-sprite" style="' . $container_style . '" hidden>';
    require_once($sprite_file);
    echo '</div>';
  }
}
add_action('wp_footer', __NAMESPACE__ . '\\include_icon_sprite', 9999);


/**
 * Return SVG Icon markup
 *
 * @param array $args {
 *     Parameters needed to display an SVG.
 *
 *     @type string $icon  Required SVG icon filename.
 *     @type string $title Optional SVG title.
 *     @type string $desc  Optional SVG description.
 * }
 * @return string SVG markup.
 */
function get_svg_icon($args = array()) {
  // Make sure $args are an array.
	if ( empty( $args ) ) {
		return __( 'Please define default parameters in the form of an array.', 'startkit' );
	}
	// Define an icon.
	if ( false === array_key_exists( 'icon', $args ) ) {
		return __( 'Please define an SVG icon filename.', 'startkit' );
	}
	// Set defaults.
	$defaults = array(
		'icon'        => '',
		'title'       => '',
		'desc'        => '',
		'aria_hidden' => true, // Hide from screen readers.
		'fallback'    => false,
	);
	// Parse args.
	$args = wp_parse_args( $args, $defaults );
	// Set aria hidden.
	$aria_hidden = '';
	if ( true === $args['aria_hidden'] ) {
		$aria_hidden = ' aria-hidden="true"';
	}
	// Set ARIA.
	$aria_labelledby = '';
	if ( $args['title'] && $args['desc'] ) {
		$aria_labelledby = ' aria-labelledby="title desc"';
	}
	// Begin SVG markup.
	$svg = '<svg class="icon icon--' . esc_attr( $args['icon'] ) . '"' . $aria_hidden . $aria_labelledby . ' role="img">';
	// If there is a title, display it.
	if ( $args['title'] ) {
		$svg .= '<title>' . esc_html( $args['title'] ) . '</title>';
	}
	// If there is a description, display it.
	if ( $args['desc'] ) {
		$svg .= '<desc>' . esc_html( $args['desc'] ) . '</desc>';
	}

	$svg .= '<use xlink:href="#icon-' . esc_html( $args['icon'] ) . '"></use>';
	$svg .= '</svg>';
	return $svg;
}

/**
 * Add Favicons to Head
 * @link http://realfavicongenerator.net/
 */
function favicons() {
	$favicon = get_parent_theme_file_path( '/dist/images/favicon/favicon.ico' );
	if(!defined('ASSETS_DIR') || !file_exists( $favicon )){
		return false;
	}

	$favicon_dir = ASSETS_DIR . '/images/favicon';
	$ver = 1;
	$icons = trim('
	<link rel="apple-touch-icon" sizes="180x180" href="' . $favicon_dir . '/apple-touch-icon.png?v=' . $ver . '">
	<link rel="icon" type="image/png" href="' . $favicon_dir . '/favicon-32x32.png?v=' . $ver . '" sizes="32x32">
	<link rel="icon" type="image/png" href="' . $favicon_dir . '/favicon-16x16.png?v=' . $ver . '" sizes="16x16">
	<link rel="shortcut icon" href="' . $favicon_dir . '/favicon.ico?v=' . $ver . '">');

	echo $icons;
}
add_action('wp_head', __NAMESPACE__ . '\\favicons', 5);
