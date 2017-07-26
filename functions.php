<?php
/**
 * Theme Constants
 * 
 * Defines Configuration Variables to use in the Setup.
 */

define("ASSETS_DIR", get_template_directory_uri() . '/dist');
//define("ANALYTICS_ID", 'UA-XXXXXXX-XX');

/**
 * Module includes
 *
 * The $includes array determines the code library included in your theme.
 */
$startkit_includes = [
  // base includes
  'base/cleanup',
  'base/setup',
  'base/filters',
  'base/assets',
  'base/titles',
  'base/navigation',
  'base/nicesearch',
  'base/icons',
  'base/misc',
  'base/utils',
  
  // disable features
  'custom/disable'
];

foreach ($startkit_includes as $file) {
  if (!$filepath = locate_template('inc/' . $file . '.php')) {
    trigger_error(sprintf(__('Error locating %s for inclusion', 'startkit'), $file), E_USER_ERROR);
  }

  require_once $filepath;
}
unset($file, $filepath);
