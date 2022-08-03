=== Plugin Name ===
Contributors: itsonlybarney, nathanrice, studiopress, cliffpaulick, marksabbath, modernnerd
Tags: redirect, click tracking, custom post types
Requires at least: 3.0
Tested up to: 6.0
Stable tag: 0.0.1

Really Simple URLs is a complete URL management system that allows you create, manage, and track outbound links from your site.

== FORK NOTICE ==

This plugin is a fork of the former [Simple URLSs](https://wordpress.org/plugins/simple-urls/) plugin created by StudioPress and partners prior to the current developer taking over.

== Description ==

Really Simple URLs is a complete URL management system that allows you create, manage, and track outbound links from your site by using custom post types and 301 redirects.

== Usage ==

Really Simple URLs adds a new custom post type to your Admin menu, where you can create, edit, delete, and manage URLs. It stores click counts in the form of a custom field on that custom post type, so it scales really well.

And, by avoiding page based redirects, which is the current trend in masking affiliate links, we avoid any issues with permalink conflicts, and therefore avoid any performance issues.

1. Upload the entire `really-simple-urls` folder to the `/wp-content/plugins/` directory
1. DO NOT change the name of the `really-simple-urls` folder
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Navigate to `Settings > Permalinks` and save them. Yes, just click save. Trust me.
1. Navigate to the `Really Simple URLs` menu
1. Create a new URL, or manage existing URLs.
1. Publish and use the URLs however you want!

== Frequently Asked Questions ==

= When I try to access my new URL, I'm getting a 404 (not found) error =

Sounds like you didn't follow the installation instructions :-)

Navigate to `Settings > Permalinks` and save them. No need to change anything, just click the save button.

= Can I change the URL structure to use something other than /go/ ??? =

Yes, by using the filter `really_simple_urls_slug`.

Usage:
```
add_filter( 'really_simple_urls_slug', function(){
    return 'redirect-me';
});
```

== Screenshots ==

1. The URL management screen
2. The URL create/edit screen

== Changelog ==

= 0.0.1 =
* Plugin fork of [Simple URLSs](https://wordpress.org/plugins/simple-urls/) from version 0.9.9
