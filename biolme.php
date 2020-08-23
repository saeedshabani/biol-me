<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Biol.me
 * @since             1.0.0
 * @package           Biolme
 *
 * @wordpress-plugin
 * Plugin Name:       Biol.me - Multiple bio links
 * Plugin URI:        https://biol.me/
 * Description:       Biol.me is a tools to make a bio link with multiple links. You can use your bio link as Instagram bio link or other social networks like Telegram, Facebook, Twitter, ...
 * Version:           1.0.1
 * Author:            biol
 * Author URI:        https://profiles.wordpress.org/biol/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       biol
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
define( 'BIOLME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-biol-activator.php
 */
function activate_biolme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-biolme-activator.php';
	Biolme_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-biol-deactivator.php
 */
function deactivate_biolme() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-biolme-deactivator.php';
	Biolme_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_biolme' );
register_deactivation_hook( __FILE__, 'deactivate_biolme' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-biolme.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_biolme() {

	$plugin = new Biolme();
	$plugin->run();

}
run_biolme();
