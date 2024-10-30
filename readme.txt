=== Mindutopia User Thumbnails ===
Contributors: mindutopia, natereist
Tags: user photos, gravatars, author photos
Requires at least: 3.5
Tested up to: 3.5.2
Stable tag: 1.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This plugin gives you the ability to add user thumbnails to your WordPress users much like featured images on posts, the images replace the gravatars.

== Description ==

This plugin allows you to:

* Add a photo with each user, much like featured images
* Replaces the user gravatar with their featured photo
* Only users levels that can upload_files in their capabilities can manage their user photo

== Installation ==

To install the plugin:

1. Upload `mindutopia_user_thumbnails` directory to the `/wp-content/plugins/` directory, or upload the `.zip` file through the `wp-admin` plugins interface.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. User photos will automatically replace user gravatars using the `get_avatar` filter.

Additionally these functions/template tags are available with this plugin to use in your templates and files.
* `has_author_thumbnail` - checks if a user has a photo saved with it : takes `user_id`
* `the_author_thumbnail` - print the author image markup : takes `user id, size, and image attributes`
* `get_the_author_thumbnail` - retrieve the image markup : takes `user id, size, and image attributes`

== Frequently Asked Questions ==

= Can my users edit their own photos? =
Only if they have the ability to upload photos on your site.

== Screenshots ==

1. The user table with user photo output.
1. The user profile form with the photo uploader.
1. Use the native wordpress uploader to choose your user photos.

== Changelog ==

= 1.0 =
Original Release
= 1.1 =
Image Sizing Update
= 1.2 =
Integer Support Image Sizing admin avatars

== Upgrade Notice ==

= 1.0 =
Original Release.
= 1.1 =
Added better sizing support, options such as 'medium', 'thumbnail', etc.
= 1.1 =
Added better sizing support logic for integers in admin screens.