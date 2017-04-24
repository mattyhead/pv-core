<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              philadelphiavotes.com
 * @since             1.0.0
 * @package           Pv_Elections_Core
 *
 * @wordpress-plugin
 * Plugin Name:       elections core ui
 * Plugin URI:        pv-elections-core
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            matthew murphy
 * Author URI:        philadelphiavotes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pv-elections-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pv-elections-core-activator.php
 */
function activate_pv_elections_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pv-elections-core-activator.php';
	Pv_Elections_Core_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pv-elections-core-deactivator.php
 */
function deactivate_pv_elections_core() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pv-elections-core-deactivator.php';
	Pv_Elections_Core_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pv_elections_core' );
register_deactivation_hook( __FILE__, 'deactivate_pv_elections_core' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pv-elections-core.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pv_elections_core() {

	$plugin = new Pv_Elections_Core();
	$plugin->run();

}
run_pv_elections_core();
