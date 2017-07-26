<?php

namespace Startkit\Assets;

/**
 * Theme assets enqueue
 */
function enqueue() {
  if(!defined('ASSETS_DIR')){
    trigger_error(sprintf(__('Asset Directory Constant "ASSETS_DIR" is not defined.', 'startkit')), E_USER_ERROR);
    return false;
  }

  // Enqueue CSS
  wp_enqueue_style( 'google_fonts', "http://fonts.googleapis.com/css?family=Open+Sans:400,700", false, false, 'all');
  wp_enqueue_style('main_styles', ASSETS_DIR . '/styles/main.min.css', false, null);

  // Enqueue Javascript
  wp_enqueue_script('main_scripts', ASSETS_DIR . '/scripts/main.min.js', ['jquery'], null, true);

  // Comments Script
  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue', 100);


/**
 * Load jQuery from jQuery's CDN with a local fallback
 */
function register_jquery() {
  if(is_admin()) return;

  $jquery_version = wp_scripts()->registered['jquery']->ver;
  wp_deregister_script('jquery');
  wp_register_script(
    'jquery',
    'https://code.jquery.com/jquery-' . $jquery_version . '.min.js',
    [],
    null,
    true
  );
  add_filter('wp_resource_hints', function ($urls, $relation_type) {
    if ($relation_type === 'dns-prefetch') {
      $urls[] = 'code.jquery.com';
    }
    return $urls;
  }, 10, 2);
  add_filter('script_loader_src', __NAMESPACE__ . '\\jquery_local_fallback', 10, 2);
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\register_jquery', 10);


/**
 * Output the local fallback immediately after jQuery's <script>
 *
 * @link http://wordpress.stackexchange.com/a/12450
 */
function jquery_local_fallback($src, $handle = null) {
  static $add_jquery_fallback = false;
  if ($add_jquery_fallback) {
    echo '<script>(window.jQuery && jQuery.noConflict()) || document.write(\'<script src="' . $add_jquery_fallback .'"><\/script>\')</script>' . "\n";
    $add_jquery_fallback = false;
  }
  if ($handle === 'jquery') {
    $add_jquery_fallback = apply_filters('script_loader_src', \includes_url('/js/jquery/jquery.js'), 'jquery-fallback');
  }
  return $src;
}
add_action('wp_head', __NAMESPACE__ . '\\jquery_local_fallback');


/**
 * Google Analytics snippet
 */
function ga_snippet() {
  if(
    !defined('ANALYTICS_ID') ||
    ANALYTICS_ID === 'UA-XXXXXXX-XX' ||
    current_user_can( 'manage_options' ) || 
    is_development_env()
  ) return;
  ?>
  <script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','<?php echo ANALYTICS_ID; ?>','auto');ga('send','pageview')
  </script>
  <script src="https://www.google-analytics.com/analytics.js" async defer></script>
<?php
}
add_action('wp_footer', __NAMESPACE__ . '\\ga_snippet', 20);