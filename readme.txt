=== I'm A Plugin Developer ===
Contributors: diddledan
Tags: WordPress.org, repository, plugin
Requires at least: 4.5
Tested up to: 4.9
Stable tag: 2.1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Showcase the plugins you have in the WordPress.org Plugin Directory on your own site.

== Description ==

This plugin will add a new post type which will display your plugin readme pulled directly from the WordPress.org API. It will show on your site complete with appropriate download links.

Portions of code are heavily influenced by [I make plugins](https://wordpress.org/plugins/i-make-plugins/) by
[Mark Jaquith](https://profiles.wordpress.org/markjaquith/).

== Changelog ==

= 2.1.0 =

* Re-add function `ima_plugdev_fetch_readme_by_slug()`

= 2.0.0 =

* Switch from post_meta to transients api
* Cleanup plugin bootstrap to reduce filesystem I/O

= 1.0.0 =

* Initial release
