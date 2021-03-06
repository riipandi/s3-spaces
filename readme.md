# S3 Spaces Sync

Synchronize your WordPress media library with [DigitalOcean Spaces](https://www.digitalocean.com/?refcode=5c4f2a9f0908) Container.

## Description

This WordPress plugin syncs your media library with DigitalOcean Spaces. It's allows you
to simuntanously upload and delete files, replacing public media URL with relative cloud
storage links. You can choose between two options, to keep local copy of the files, or to
delete them and keep files only in cloud storage.

In order to use this plugin, you have to create a DigitalOcean Spaces API key.

You may now define constants in order to configure the plugin. If the constant is defined,
it overwrites the value from settings page.

### Contants Description

```txt
S3_SPACE_KEY                  : DigitalOcean Spaces key
S3_SPACE_SECRET               : DigitalOcean Spaces secret
S3_SPACE_ENDPOINT             : DigitalOcean Spaces endpoint
S3_SPACE_CONTAINER            : DigitalOcean Spaces container
S3_SPACE_STORAGE_PATH         : Path to the file in the storage, will appear as a prefix
S3_SPACE_STORAGE_FILE_ONLY    : Keep files only in DO Spaces or not (true|false)
S3_SPACE_STORAGE_FILE_DELETE  : Remove files in DO Spaces on delete or not  (true|false)
S3_SPACE_FILTER               : Regular expression filter
S3_SPACE_UPLOAD_URL_PATH      : Full url to the files, WP Constant
S3_SPACE_UPLOAD_PATH          : Path to the local files, WP Constant
```

There is a known issue with the built in Wordpress Image Editor, it will not upload changed images.
Know how to fix this, PR welcome.

### Example Configuration

```php
/**
 * S3 Space Configuration
 */
define( 'S3_SPACE_KEY',        'xxxxxxxxxxxxxxxxxxxx' );
define( 'S3_SPACE_SECRET',     'xxxxxxxxxxxxxxxxxxxx' );
define( 'S3_SPACE_ENDPOINT',   'https://sgp1.digitaloceanspaces.com' );
define( 'S3_SPACE_CONTAINER',  'mywordpress' );
```

## Installation

1. Upload plugin directory to `/wp-content/plugins/`
2. Activate plugin through 'Plugins' menu in WordPress
3. Go to `Settings -> S3 Spaces Sync` and set up plugin

If plugin has been downloaded from GitHub, you have to install vendor components via `composer update`.

## Credits

This plugin forked from [keeross/DigitalOcean-Spaces-Sync](https://github.com/keeross/DigitalOcean-Spaces-Sync)
and licensed under [MIT License](./license.txt).
