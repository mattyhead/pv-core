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
 * @package           Pv_Core
 *
 * @wordpress-plugin
 * Plugin Name:       PV core
 * Plugin URI:        pv-core
 * Description:       Shared code for the various PV plugins.
 * Version:           1.0.0
 * Author:            matthew murphy
 * Author URI:        philadelphiavotes.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pv-core
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
