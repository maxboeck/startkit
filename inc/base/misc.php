<?php

namespace Startkit\Misc;

/**
 * Send IE Chrome Frame Header
 */
function send_edge_headers() {
  header( 'X-UA-Compatible: IE=edge,chrome=1' );
}
add_action( 'send_headers', __NAMESPACE__ . '\\send_edge_headers' );


/**
 * Display Performance Stats in Footer
 */
function footer_query_stats() {
  if( current_user_can( 'manage_options' ) ) {
    $stat = sprintf( '%d queries in %.3f seconds, using %.2fMB memory',
        get_num_queries(),
        timer_stop( 0, 3 ),
        memory_get_peak_usage() / 1024 / 1024
    );
    echo "<!-- {$stat} -->";
   }
}
add_action( 'wp_footer', __NAMESPACE__ . '\\footer_query_stats' );


/**
 * Custom Login Screen Logo (Disabled)
 */
function custom_login_logo() {
  $src = get_bloginfo('template_directory').'/dist/images/logo-login.png';
  $w = 80;
  $h = 80;

  echo '<style type="text/css">
  #login h1 a { 
    background-image: url('.$src.');
    width: '.$w.'px;
    height: '.$h.'px;
    background-size: '.$w.'px '.$h.'px;
  }
  </style>';
}
//add_action('login_head', __NAMESPACE__ . '\\custom_login_logo');


/**
 * Add Outdated Browser Warning to Top Panel
 */
function outdated_browser_warning(){ ?>
<!--[if lte IE 9]>
  <div class="alert alert--legacy">
    <div class="container">
    <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser here</a> to improve your experience.', 'startkit'); ?>
    </div>
  </div>
<![endif]-->
<?php
}
add_action( 'get_top_banner', __NAMESPACE__ . '\\outdated_browser_warning', 20, 0 );