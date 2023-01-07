<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://privyreza.co.zw
 * @since             1.0.0
 * @package           Resellme
 *
 * @wordpress-plugin
 * Plugin Name:       Resellme
 * Plugin URI:        https://resellme.co.zw
 * Description:       Resellme Plugin for Domains And Domain Reselling
 * Version:           1.0.0
 * Author:            privyreza
 * Author URI:        https://privyreza.co.zw
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       resellme
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RESELLME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-resellme-activator.php
 */
function activate_resellme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-resellme-activator.php';
	Resellme_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-resellme-deactivator.php
 */
function deactivate_resellme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-resellme-deactivator.php';
	Resellme_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_resellme' );
register_deactivation_hook( __FILE__, 'deactivate_resellme' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-resellme.php';

/**
 * Load vendor libs that are required to connect to resellme api
 * 
 */
require plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_resellme() {

	$plugin = new Resellme();
	$plugin->run();

}
run_resellme();
