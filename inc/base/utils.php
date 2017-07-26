<?php

use Startkit\Icons;

/**
 * Pretty Debug Array Output
 */
if ( !function_exists( 'print_a' ) ) {
  function print_a( $a ) {
    print( '<pre>' );
    print_r( $a );
    print( '</pre>' );
  }
}

/**
 * Check if we're in a local dev environment
 */
if ( !function_exists( 'is_development_env' ) ) {
  function is_development_env(){
    return $_SERVER['SERVER_NAME'] === 'localhost';
  }
}


/**
 * Compare URL against relative URL
 */
if ( !function_exists( 'url_compare' ) ) {
  function url_compare($url, $rel) {
    $url = trailingslashit($url);
    $rel = trailingslashit($rel);
    return ((strcasecmp($url, $rel) === 0) || root_relative_url($url) == $rel);
  }
}

/**
 * SVG Icon Shorthand Func
 */
if( !function_exists( 'get_icon' ) ){
  function get_icon($icon = null, $title = '', $desc = '') {
    if(!empty($icon)){
      $args = array(
        'icon' => $icon,
        'title' => $title,
        'desc' => $desc
      );
      return Icons\get_svg_icon($args);
    }
  }
}