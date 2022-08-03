<?php
/**
 * Plugin Name: Really Simple URLs
 * Plugin URI: https://wordpress.org/plugins/really-simple-urls/
 * Description: Really Simple URLs is a complete URL management system that allows you create, manage, and track outbound links from your site by using custom post types and 301 redirects.
 * Author: Andrew Barnett
 * Author URI: https://nerdgineer.com/
 * Version: 0.0.1

 * Text Domain: really-simple-urls
 * Domain Path: /languages

 * License: GNU General Public License v2.0 (or later)
 * License URI: http://www.opensource.org/licenses/gpl-license.php
 *
 * @package really-simple-urls
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

define( 'REALLY_SIMPLE_URLS_DIR', plugin_dir_path( __FILE__ ) );
define( 'REALLY_SIMPLE_URLS_URL', plugins_url( '', __FILE__ ) );

require_once REALLY_SIMPLE_URLS_DIR . '/includes/class-simple-urls.php';

new Really_Simple_Urls();

if ( is_admin() ) {
    require_once REALLY_SIMPLE_URLS_DIR . '/includes/class-simple-urls-admin.php';
    new Really_Simple_Urls_Admin();
}
