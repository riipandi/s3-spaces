=== S3 Spaces Sync ===
Contributors: keeross, riespandi
Donate link: https://paypal.me/riipandi/
Tags: media, storage, aws, digitalocean, s3, space, sync
Requires at least: 4.6
Tested up to: 5.0.2
Stable tag: 1.0.0
Requires PHP: 5.6

This plugin is allow you to synchronize your WordPress media library with DigitalOcean Spaces.

== Description ==

S3 Spaces Sync plugin connects your Media Library to a container in DigitalOcean Spaces. It syncs data from your website to cloud storage and replaces links to images (optional). You may keep the media locally (on your server) and make backup copy to cloud storage, or just serve it all from DigitalOcean Spaces.

In order to use this plugin, you have to create a DigitalOcean Spaces API key.

You may now define constants in order to configure the plugin. If the constant is defined, it overwrites the value from settings page.

= Contants Description =

* S3_SPACE_KEY - DigitalOcean Spaces key
* S3_SPACE_SECRET - DigitalOcean Spaces secret,
* S3_SPACE_ENDPOINT - DigitalOcean Spaces endpoint,
* S3_SPACE_CONTAINER - DigitalOcean Spaces container,
* S3_SPACE_STORAGE_PATH - The path to the file in the storage, will appear as a prefix,
* S3_SPACE_FILE_ONLY - Keep files only in DigitalOcean Spaces or not, values (true|false),
* S3_SPACE_FILE_DELETE - Remove files in DigitalOcean Spaces on delete or not, values (true|false),
* S3_SPACE_FILTER - A Regex filter,
* S3_SPACE_CDN_URL - A full url to the files, WP Constant,
* S3_SPACE_UPLOAD_PATH - A path to the local files, WP Constant

There is a known issue with the built in Wordpress Image Editor, it will not upload changed images. Know how to fix this, PR welcome.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/s3-spaces` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Use the Settings -> S3 Spaces Sync screen to configure the plugin
4. Create a DigitalOcean Spaces API key and container

== Screenshots ==

1. Configuration screen

== Frequently Asked Questions ==

:TODO

== Upgrade Notice ==

:TODO

== Changelog ==

= 1.0.0 =
* Initial release.
