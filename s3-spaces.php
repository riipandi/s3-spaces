<?php
/**
 * Plugin Name: S3 Spaces Sync
 * Plugin URI: https://github.com/riipandi/s3-spaces
 * Description: Synchronize your WordPress media library with DigitalOcean Spaces.
 * Version: 1.0.0
 * Author: Aris Ripandi
 * Author URI: https://keybase.io/riipandi
 * License: MIT
 * Text Domain: s3spaces
 * Domain Path: /languages
 */

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 's3spaces_class.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 's3spaces_class_filesystem.php';

load_plugin_textdomain('s3spaces', false, dirname(plugin_basename(__FILE__)) . '/lang');

function s3spaces_incompatibile($msg) {
  require_once ABSPATH . DIRECTORY_SEPARATOR . 'wp-admin' . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'plugin.php';
  deactivate_plugins(__FILE__);
  wp_die($msg);
}

if ( is_admin() && ( !defined('DOING_AJAX') || !DOING_AJAX ) ) {

  if ( version_compare(PHP_VERSION, '5.6.0', '<') ) {

    s3spaces_incompatibile(
      __(
        'Plugin S3 Spaces Sync requires PHP 5.6.0 or higher. The plugin has now disabled itself.',
        's3spaces'
      )
    );

  } elseif ( !function_exists('curl_version')
    || !($curl = curl_version()) || empty($curl['version']) || empty($curl['features'])
    || version_compare($curl['version'], '7.16.2', '<')
  ) {

    s3spaces_incompatibile(
      __('Plugin S3 Spaces Sync requires cURL 7.16.2+. The plugin has now disabled itself.', 's3spaces')
    );

  } elseif (!($curl['features'] & CURL_VERSION_SSL)) {

    s3spaces_incompatibile(
      __(
        'Plugin S3 Spaces Sync requires that cURL is compiled with OpenSSL. The plugin has now disabled itself.',
        's3spaces'
      )
    );

  }

}

$instance = S3_Spaces::get_instance();
$instance->setup();