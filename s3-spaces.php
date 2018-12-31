<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @wordpress-plugin
 * Plugin Name:       S3 Spaces Sync
 * Plugin URI:        https://wordpress.org/plugins/s3-spaces/
 * Description:       Synchronize your WordPress media library with DigitalOcean Spaces.
 * Version:           1.0.0
 * Author:            Aris Ripandi
 * Author URI:        https://keybase.io/riipandi
 * License:           MIT
 * License URI:       https://opensource.org/licenses/MIT
 * Text Domain:       s3spaces
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

require dirname(__FILE__) . DIRECTORY_SEPARATOR . 's3spaces_class.php';
require dirname(__FILE__) . DIRECTORY_SEPARATOR . 's3spaces_class_filesystem.php';

load_plugin_textdomain('s3spaces', false, dirname(plugin_basename(__FILE__)) . '/lang');

// Add settings link
function s3spaces_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=s3-spaces">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}

$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 's3spaces_add_settings_link' );

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