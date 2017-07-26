<?php
/**
 * Theme Constants
 * 
 * Defines Configuration Variables to use in the Setup.
 */

define("ASSETS_DIR", get_template_directory_uri() . '/dist');
define("ANALYTICS_ID", 'UA-XXXXXXX-XX');

/**
 * Module includes
 *
 * The $theme_includes array determines the code library included in your theme.
 */
$theme_includes = [
  'base/cleanup',
  'base/setup',
  'base/disable',
  'base/filters',
  'base/assets',
  'base/posttypes',
  'base/titles',
  'base/navigation',
  'base/nicesearch',
  'base/icons',
  'base/misc',
  'base/utils',
];

foreach ($theme_includes as $file) {
  if (!$filepath = locate_template('inc/' . $file . '.php')) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'startkit'), $file), E_USER_ERROR);
  }
  require_once $filepath;
}
unset($file, $filepath);
