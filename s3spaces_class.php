<?php

class S3_Spaces {

  private static $instance;
  private        $key;
  private        $secret;
  private        $endpoint;
  private        $container;
  private        $storage_path;
  private        $file_only;
  private        $file_delete;
  private        $filter;
  private        $cdn_url;
  private        $upload_path;

	/**
	 *
	 * @return S3_Spaces
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new S3_Spaces(
				defined( 'S3_SPACE_KEY' ) ? S3_SPACE_KEY : null,
				defined( 'S3_SPACE_SECRET' ) ? S3_SPACE_SECRET : null,
        defined( 'S3_SPACE_CONTAINER' ) ? S3_SPACE_CONTAINER : null,
        defined( 'S3_SPACE_ENDPOINT' ) ? S3_SPACE_ENDPOINT : null,
        defined( 'S3_SPACE_STORAGE_PATH' ) ? S3_SPACE_STORAGE_PATH : null,
        defined( 'S3_SPACE_FILE_ONLY' ) ? S3_SPACE_FILE_ONLY : null,
        defined( 'S3_SPACE_FILE_DELETE' ) ? S3_SPACE_FILE_DELETE : null,
        defined( 'S3_SPACE_FILTER' ) ? S3_SPACE_FILTER : null,
        defined( 'S3_SPACE_CDN_URL' ) ? S3_SPACE_CDN_URL : null,
        defined( 'S3_SPACE_UPLOAD_PATH' ) ? S3_SPACE_UPLOAD_PATH : null
			);
		}
		return self::$instance;
  }

	public function __construct( $key, $secret, $container, $endpoint, $storage_path, $file_only, $file_delete, $filter, $cdn_url, $upload_path ) {
		$this->key                 = empty($key) ? get_option('s3spaces_key') : $key;
		$this->secret              = empty($secret) ? get_option('s3spaces_secret') : $secret;
    $this->endpoint            = empty($endpoint) ? get_option('s3spaces_endpoint') : $endpoint;
    $this->container           = empty($container) ? get_option('s3spaces_container') : $container;
    $this->storage_path        = empty($storage_path) ? get_option('s3spaces_storage_path') : $storage_path;
    $this->file_only           = empty($file_only) ? get_option('s3spaces_file_only') : $file_only;
    $this->file_delete         = empty($file_delete) ? get_option('s3spaces_file_delete') : $file_delete;
    $this->filter              = empty($filter) ? get_option('s3spaces_filter') : $filter;
    $this->cdn_url             = empty($cdn_url) ? get_option('s3spaces_cdn_url') : $cdn_url;
    $this->upload_path         = empty($upload_path) ? get_option('s3spaces_upload_path') : $upload_path;
	}

  // SETUP
  public function setup () {

    $this->register_actions();
    $this->register_filters();

  }

  // REGISTRATIONS
  private function register_actions () {

    add_action('admin_menu', array($this, 'register_menu') );
    add_action('admin_init', array($this, 'register_settings' ) );
    add_action('admin_enqueue_scripts', array($this, 'register_scripts' ) );
    add_action('admin_enqueue_scripts', array($this, 'register_styles' ) );

    add_action('wp_ajax_s3spaces_test_connection', array($this, 'test_connection' ) );

    add_action('add_attachment', array($this, 'action_add_attachment' ), 10, 1);
    add_action('delete_attachment', array($this, 'action_delete_attachment' ), 10, 1);

  }

  private function register_filters () {

    add_filter( "plugin_action_links_s3spaces", array($this, 'filter_add_settings_link') );

    add_filter('wp_update_attachment_metadata', array($this, 'filter_wp_update_attachment_metadata'), 20, 1);
    // add_filter('wp_save_image_editor_file', array($this,'filter_wp_save_image_editor_file'), 10, 5 );
    add_filter('wp_unique_filename', array($this, 'filter_wp_unique_filename') );

  }

  public function register_scripts () {

    wp_enqueue_script('s3spaces-core-js', plugin_dir_url( __FILE__ ) . '/assets/scripts/core.js', array('jquery'), '1.4.0', true);

  }

  public function register_styles () {

    wp_enqueue_style('s3spaces-flexboxgrid', plugin_dir_url( __FILE__ ) . '/assets/styles/flexboxgrid.min.css' );
    wp_enqueue_style('s3spaces-core-css', plugin_dir_url( __FILE__ ) . '/assets/styles/core.css' );

  }

  public function register_settings () {

    register_setting('s3spaces_settings', 's3spaces_key');
    register_setting('s3spaces_settings', 's3spaces_secret');
    register_setting('s3spaces_settings', 's3spaces_endpoint');
    register_setting('s3spaces_settings', 's3spaces_container');
    register_setting('s3spaces_settings', 's3spaces_storage_path');
    register_setting('s3spaces_settings', 's3spaces_file_only');
    register_setting('s3spaces_settings', 's3spaces_file_delete');
    register_setting('s3spaces_settings', 's3spaces_filter');
    // register_setting('s3spaces_settings', 's3spaces_debug');
    register_setting('s3spaces_settings', 's3spaces_cdn_url');
    register_setting('s3spaces_settings', 's3spaces_upload_path');

  }

  public function register_setting_page () {
    include_once('s3spaces_settings_page.php');
  }

  public function register_menu () {

    add_options_page(
      'S3 Spaces Sync',
      'S3 Spaces Sync',
      'manage_options',
      's3-spaces',
      array($this, 'register_setting_page')
    );

  }

  // FILTERS
  public function filter_wp_update_attachment_metadata ($metadata) {

    $paths = array();
    $upload_dir = wp_upload_dir();

    // collect original file path
    if ( isset($metadata['file']) ) {

      $path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
      array_push($paths, $path);

      // set basepath for other sizes
      $file_info = pathinfo($path);
      $basepath = isset($file_info['extension'])
          ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $path)
          : $path;

    }

    // collect size files path
    if ( isset($metadata['sizes']) ) {

      foreach ( $metadata['sizes'] as $size ) {

        if ( isset($size['file']) ) {

          $path = $basepath . $size['file'];
          array_push($paths, $path);

        }

      }

    }

    // process paths
    foreach ($paths as $filepath) {

      // upload file
      $this->file_upload($filepath, 0, true);

    }

    return $metadata;

  }

  public function filter_wp_unique_filename ($filename) {

    $upload_dir = wp_upload_dir();
    $subdir = $upload_dir['subdir'];

    $filesystem = S3_Space_Filesystem::get_instance($this->key, $this->secret, $this->container, $this->endpoint);

    $number = 1;
    $new_filename = $filename;
    $fileparts = pathinfo($filename);

    while ( $filesystem->has( $subdir . "/$new_filename" ) ) {
      $new_filename = $fileparts['filename'] . "-$number." . $fileparts['extension'];
      $number = (int) $number + 1;
    }

    return $new_filename;

  }

  private function filter_add_settings_link( $links ) {
      $settings_link = '<a href="options-general.php?page=s3-spaces">' . __( 'Settings' ) . '</a>';
      array_push( $links, $settings_link );
      return $links;
  }

  // ACTIONS
  public function action_add_attachment ($postID) {

    if ( wp_attachment_is_image($postID) == false ) {

      $file = get_attached_file($postID);

      $this->file_upload($file);

    }

    return true;

  }

  public function action_delete_attachment ($postID) {

    $paths = array();
    $upload_dir = wp_upload_dir();

    if ( wp_attachment_is_image($postID) == false ) {

      $file = get_attached_file($postID);

      $this->file_delete($file);

    } else {

      $metadata = wp_get_attachment_metadata($postID);

      // collect original file path
      if ( isset($metadata['file']) ) {

        $path = $upload_dir['basedir'] . DIRECTORY_SEPARATOR . $metadata['file'];
        array_push($paths, $path);

        // set basepath for other sizes
        $file_info = pathinfo($path);
        $basepath = isset($file_info['extension'])
            ? str_replace($file_info['filename'] . "." . $file_info['extension'], "", $path)
            : $path;

      }

      // collect size files path
      if ( isset($metadata['sizes']) ) {

        foreach ( $metadata['sizes'] as $size ) {

          if ( isset($size['file']) ) {

            $path = $basepath . $size['file'];
            array_push($paths, $path);

          }

        }

      }

      // process paths
      foreach ($paths as $filepath) {

        // upload file
        $this->file_delete($filepath);

      }

    }

  }

  // METHODS
  public function test_connection () {

    try {

      $filesystem = S3_Space_Filesystem::get_instance($this->key, $this->secret, $this->container, $this->endpoint);
      $filesystem->write('test.txt', 'test');
      $filesystem->delete('test.txt');
      // $exists = $filesystem->has('photo.jpg');

      $this->show_message(__('Connection is successfully established. Save the settings.', 's3spaces'));
      exit();

    } catch (Exception $e) {

      $this->show_message( __('Connection is not established.','s3spaces') . ' : ' . $e->getMessage() . ($e->getCode() == 0 ? '' : ' - ' . $e->getCode() ), true);
      exit();

    }

  }

  public function show_message ($message, $errormsg = false) {

    if ($errormsg) {

      echo '<div id="message" class="error">';

    } else {

      echo '<div id="message" class="updated fade">';

    }

    echo "<p><strong>$message</strong></p></div>";

  }

  // FILE METHODS
  public function file_path ($file) {

    $path = str_replace($this->upload_path, '', $file);

    return $this->storage_path . $path;

  }

  public function file_upload ($file) {

    // init cloud filesystem
    $filesystem = S3_Space_Filesystem::get_instance($this->key, $this->secret, $this->container, $this->endpoint);
    $regex_string = $this->filter;

    // prepare regex
    if ( $regex_string == '*' || !strlen($regex_string)) {
      $regex = false;
    } else {
      $regex = preg_match( $regex_string, $file);
    }

    try {

      // check if readable and regex matched
      if ( is_readable($file) && !$regex ) {

        // create fiel in storage
        $filesystem->put( $this->file_path($file), file_get_contents($file), [
          'visibility' => 'public'
        ]);

        // remove on upload
        if ( $this->file_only == 1 ) {

          unlink($file);

        }

      }

      return true;

    } catch (Exception $e) {

      return false;

    }

  }

  public function file_delete ($file) {

    if ( $this->file_delete == 1 ) {

      try {

        $filepath = $this->file_path($file);
        $filesystem = S3_Space_Filesystem::get_instance($this->key, $this->secret, $this->container, $this->endpoint);

        $filesystem->delete( $filepath );

      } catch (Exception $e) {

        error_log( $e );

      }

    }

    return $file;

  }

}