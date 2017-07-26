<?php

namespace Startkit\Disable;


/**
 * Remove Pages from Admin Menu
 */
function clean_admin_menu(){
  global $menu;
  
  remove_menu_page( 'edit-comments.php' );
  remove_submenu_page( 'edit.php', 'edit-tags.php?taxonomy=post_tag' );
  remove_submenu_page( 'themes.php', 'theme-editor.php' );
  
}
add_action('admin_menu', __NAMESPACE__ . '\\clean_admin_menu');


/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function remove_dashboard_widgets() {
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'normal');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
}
add_action('admin_init', __NAMESPACE__ . '\\remove_dashboard_widgets');


/**
 * Disable XMLRPC
 */
add_filter('xmlrpc_enabled', '__return_false');


/**
 * Disable Author Archives, b/c they're a common exploit scan point
 */
function author_archive_redirect() {
  if( is_author() ) {
    wp_redirect( home_url(), 301 );
    exit;
  }
}
add_action( 'template_redirect', __NAMESPACE__ . '\\author_archive_redirect' );


/**
 * Don't Include wp-embed.js in Footer
 */
function disable_wp_embed(){
  wp_deregister_script( 'wp-embed' );
}
add_action('wp_footer', __NAMESPACE__ . '\\disable_wp_embed');


/**
 * Disable Emoji Stuff
 */
function disable_emojis() {
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_action( 'admin_print_styles', 'print_emoji_styles' );  
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );  
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  add_filter( 'tiny_mce_plugins', __NAMESPACE__ . '\\disable_emojis_tinymce' );
}
add_action( 'init', __NAMESPACE__ . '\\disable_emojis' );

function disable_emojis_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


/**
 * Disable Self Pingbacks
 */
function disable_self_trackback( &$links ) {
  foreach ( $links as $l => $link )
    if ( 0 === strpos( $link, get_option( 'home' ) ) )
      unset($links[$l]);
}
add_action( 'pre_ping', __NAMESPACE__ . '\\disable_self_trackback' );


/**
 * Returning an authentication error if a user who is not logged in tries to query the REST API
 */
function restrict_rest_access( $access ) {
	if( !is_user_logged_in() ) {
    return new WP_Error( 
      'rest_cannot_access', 
      __( 'Only authenticated users can access the REST API.', 'startkit' ), 
      array( 'status' => rest_authorization_required_code() ) 
    );
  }
  return $access;
}
add_filter( 'rest_authentication_errors', __NAMESPACE__ . '\\restrict_rest_access' );