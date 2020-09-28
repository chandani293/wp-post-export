<?php

/**
 * @link              https://www.cmsminds.com/
 * @since             1.0.0
 * @package           Wp_Post_Export
 * Plugin Name:       WP Post Export
 * Plugin URI:        https://www.cmsminds.com/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Chandani Vadaria
 * Author URI:        https://www.cmsminds.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-post-export
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version. Start at version 1.0.0 and use
 */
define( 'WP_POST_EXPORT_VERSION', '1.0.0' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-post-export.php';

/**
 * Begins execution of the plugin.
 */
function run_wp_post_export() {

	$plugin = new Wp_Post_Export();
	$plugin->run();

}
run_wp_post_export();
