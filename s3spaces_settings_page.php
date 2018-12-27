<div class="s3spaces__loader">

</div>

<div class="s3spaces__page row">

  <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">

    <div class="s3spaces__message"></div>

    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h2>S3 Spaces Sync <?php _e('Settings', 's3spaces'); ?></h2>
      </div>

    </div>

    <div class="row">

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php _e('Type in your DigitalOcean Spaces container access information.', 's3spaces'); ?>
        <?php _e('Don\'t have an account? <a href="//www.digitalocean.com/?refcode=5c4f2a9f0908">Create it</a>', 's3spaces'); ?>
      </div>

    </div>

    <form method="POST" action="options.php">

      <?php settings_fields('s3spaces_settings'); ?>

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4>
            <?php _e('Connection settings', 's3spaces'); ?>
          </h4>
        </div>

      </div>

      <div class="s3spaces__block">

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_key">
              <?php _e('DO Spaces Key', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_key" name="s3spaces_key" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_KEY' ) ? S3_SPACE_KEY : get_option('s3spaces_key')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_KEY' ) ? 'disabled' : '' ); ?>/>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_secret">
              <?php _e('DO Spaces Secret', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_secret" name="s3spaces_secret" type="password" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_SECRET' ) ? S3_SPACE_SECRET : get_option('s3spaces_secret')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_SECRET' ) ? 'disabled' : '' ); ?>/>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_container">
              <?php _e('DO Spaces Container', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_container" name="s3spaces_container" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_CONTAINER' ) ? S3_SPACE_CONTAINER : get_option('s3spaces_container')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_CONTAINER' ) ? 'disabled' : '' ); ?>/>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_endpoint">
              <?php _e('Endpoint', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_endpoint" name="s3spaces_endpoint" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_ENDPOINT' ) ? S3_SPACE_ENDPOINT : get_option('s3spaces_endpoint')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_ENDPOINT' ) ? 'disabled' : '' ); ?>/>
            <div class="s3spaces__description">
              <?php _e('By default', 's3spaces'); ?>: <code>https://ams3.digitaloceanspaces.com</code>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <input type="button" name="test" class="button button-primary s3spaces__test__connection"
                   value="<?php _e('Check the connection', 's3spaces'); ?>" />
          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4>
            <?php _e('File & Path settings', 's3spaces'); ?>
          </h4>
        </div>

      </div>

      <div class="s3spaces__block">

        <div class="row larger">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="upload_url_path">
              <?php _e('Full URL-path to files', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="upload_url_path" name="upload_url_path" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'UPLOAD_URL_PATH' ) ? UPLOAD_URL_PATH : get_option('upload_url_path')  ); ?>"
                   <?php echo ( defined( 'UPLOAD_URL_PATH' ) ? 'disabled' : '' ); ?>/>
            <div class="s3spaces__description">
              <?php _e('Enter storage public domain or subdomain if the files are stored only in the cloud storage', 's3spaces'); ?>
              <code>(http://uploads.example.com)</code>,
              <?php _e('or full URL path, if are kept both in cloud and on the server.','s3spaces'); ?>
              <code>(http://example.com/wp-content/uploads)</code>.</p>
              <?php _e('In that case duplicates are created. If you change one, you change and the other,','s3spaces'); ?>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="upload_path">
              <?php _e('Local path', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="upload_path" name="upload_path" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'UPLOAD_PATH' ) ? UPLOAD_PATH : get_option('upload_path')  ); ?>"
                   <?php echo ( defined( 'UPLOAD_PATH' ) ? 'disabled' : '' ); ?>
                   placeholder="<?php echo ABSPATH;?>wp-content/uploads"/>
            <div class="s3spaces__description">
              <?php _e('Local path to the uploaded files. By default', 's3spaces'); ?>: <code>wp-content/uploads</code>
              <?php _e('Setting duplicates of the same name from the mediafiles settings. Changing one, you change and other', 's3spaces'); ?>.
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_storage_path">
              <?php _e('Storage prefix', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_storage_path" name="s3spaces_storage_path" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_STORAGE_PATH' ) ? S3_SPACE_STORAGE_PATH : get_option('s3spaces_storage_path')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_STORAGE_PATH' ) ? 'disabled' : '' ); ?>/>
            <div class="s3spaces__description">
              <?php _e( 'The path to the file in the storage will appear as a prefix / path.<br />For example, in your case:', 's3spaces' ); ?>
              <code><?php echo get_option('s3spaces_storage_path'); ?></code>
            </div>
          </div>

        </div>

        <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
            <label for="s3spaces_filter">
              <?php _e('Filemask/Regex for ignored files', 's3spaces'); ?>:
            </label>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <input id="s3spaces_filter" name="s3spaces_filter" type="text" class="regular-text code"
                   value="<?php echo esc_attr( defined( 'S3_SPACE_FILTER' ) ? S3_SPACE_FILTER : get_option('s3spaces_filter')  ); ?>"
                   <?php echo ( defined( 'S3_SPACE_FILTER' ) ? 'disabled' : '' ); ?>/>
            <div class="s3spaces__description">
              <?php _e('By default empty or', 's3spaces'); ?><code>*</code>
              <?php _e('Will upload all the files by default, you are free to use any Regular Expression, For example:', 's3spaces'); ?>
              <code>/^.*\.(png|jp?g|bmp|gif|pdf|zip|rar|docx)$/i</code>
            </div>
          </div>

        </div>

      </div>

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <h4>
            <?php _e('Sync settings', 's3spaces'); ?>
          </h4>
        </div>

      </div>

      <div class="row">

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="width: 50px;">
          <input id="onlystorage" type="checkbox" name="s3spaces_storage_file_only"
                 value="1" <?php echo checked( defined( 'S3_SPACE_STORAGE_FILE_ONLY' ) ? S3_SPACE_STORAGE_FILE_ONLY : get_option('s3spaces_storage_file_only'), 1 ); ?>"
                 <?php echo ( defined( 'S3_SPACE_STORAGE_FILE_ONLY' ) ? 'disabled' : '' ); ?> />
        </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
          <?php _e('Store files only in the cloud and delete after successful upload.', 's3spaces'); ?>
          <?php _e('Local files will removed, that saves you space.', 's3spaces'); ?>
        </div>

      </div>

      <div class="row">

        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
          <input id="s3spaces_storage_file_delete" type="checkbox" name="s3spaces_storage_file_delete"
                 value="1" <?php echo checked( defined( 'S3_SPACE_STORAGE_FILE_DELETE' ) ? S3_SPACE_STORAGE_FILE_DELETE : get_option('s3spaces_storage_file_delete'), 1 ); ?>"
                 <?php echo ( defined( 'S3_SPACE_STORAGE_FILE_DELETE' ) ? 'disabled' : '' ); ?> />
        </div>

        <div class="col-xs-11 col-sm-11 col-md-11 col-lg-11">
          <?php _e( 'Delete file from cloud storage as soon as it was removed from your library.', 's3spaces' ); ?>
        </div>

      </div>

      <div class="row">

        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
          <input type="hidden" name="action" value="update"/>
          <?php submit_button(); ?>
        </div>

      </div>

    </form>

  </div>

  <div class="col-xs-12 col-xs-12 col-md-4 col-lg-4">

    <p>
      <img id="img-spinner" src="<?php echo plugins_url() . '/' . dirname( plugin_basename(__FILE__) ); ?>/assets/images/do_logo.svg" alt="DigitalOcean" style="width: 150px;"/>
    </p>

    <p>
      This plugin syncs your WordPress library with DigitalOcean Spaces Container.
      It may be buggy, it may sometimes fail, feel free to write issues on github and PR.
    </p>

    <p>
      This plugin source available at <a href="https://github.com/riipandi/s3-spaces/" target="_blank">GitHub</a>.
    </p>

  </div>

</div>