<!doctype html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
  </head>
  <body <?php body_class(); ?>>
    <a href="#main" class="sr-skip-link" accesskey="1"><?php _e( 'skip to content', 'startkit' ); ?></a>
    <?php do_action( 'get_top_banner'); ?>

    <div class="hfeed site" role="document">