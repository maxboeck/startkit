<?php

namespace Startkit\Filters;


/**
 * Add and remove body_class() classes
 */
function body_class($classes) {
  // Add post/page slug
  if (is_single() || is_page() && !is_front_page()) {
    $classes[] = basename(get_permalink());
  }
  // Remove unnecessary classes
  $home_id_class = 'page-id-' . get_option('page_on_front');
  $remove_classes = array($home_id_class);
  $classes = array_diff($classes, $remove_classes);

  // add class for the name of the custom template used (if any)
  $temp = get_page_template();
  if ( $temp != null ) {
    foreach ($classes as $key => $class) {
      if (substr($class, 0, 13) == "page-template") {
        unset($classes[$key]);
      }
    }

    $path = pathinfo($temp);
    $tmp = $path['filename'] . "." . $path['extension'];
    $tn= str_replace(".php", "", $tmp);
    $classes[] = "tpl-".$tn;
  }

  return $classes;
}
add_filter('body_class', __NAMESPACE__ . '\\body_class');


/**
 * Add "… Read More" to the excerpt
 */
function excerpt_length($length) {
  return 50;
}
function excerpt_more($more) {
  return ' &hellip; <a href="' . get_permalink() . '">' . __('Read More', 'startkit') . '</a>';
}
add_filter('excerpt_length', __NAMESPACE__ . '\\excerpt_length');
add_filter('excerpt_more', __NAMESPACE__ . '\\excerpt_more');


/**
 * Auto Obfuscate Emails in Content
 */
function email_auto_antispambot($content) {
    $pattern = '/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4})/i';
    $fix = preg_replace_callback($pattern, __NAMESPACE__ . '\\email_obfuscate', $content);

    return $fix;
}
function email_obfuscate($result) {
  return antispambot($result[1]);
}
add_filter( 'the_content', __NAMESPACE__ . '\\email_auto_antispambot', 20 );


/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function embed_wrap($cache) {
  return '<div class="entry-content-asset">' . $cache . '</div>';
}
add_filter('embed_oembed_html', __NAMESPACE__ . '\\embed_wrap');


/**
 * Link Login Page Logo to Home URL
 */
function custom_login_logo_url() {
  return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', __NAMESPACE__ . '\\custom_login_logo_url' );

function custom_login_logo_url_title() {
  return get_bloginfo( 'name' );
}
add_filter( 'login_headertitle', __NAMESPACE__ . '\\custom_login_logo_url_title' );