<?php

namespace Startkit\Setup;

/**
 * Theme setup
 */
function setup() {
  // Make theme available for translation
  load_theme_textdomain('startkit', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'startkit')
  ]);

  // Enable post thumbnails
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebar
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'startkit'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="sidebar__widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');
