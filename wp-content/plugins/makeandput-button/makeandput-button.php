<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://monodelapila.com
 * @since             1.0.0
 * @package           Makeandput_Button
 *
 * @wordpress-plugin
 * Plugin Name:       make&put Button
 * Plugin URI:        https://www.monodelapila/makeandput
 * Description:       Make your own buttons and puts its in your pages and post
 * Version:           1.0.0
 * Author:            Pedro Ocampo
 * Author URI:        https://monodelapila.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       makeandput-button
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
define( 'MAKEANDPUT_BUTTON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-makeandput-button-activator.php
 */
function activate_makeandput_button() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-makeandput-button-activator.php';
	Makeandput_Button_Activator::activate();

}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-makeandput-button-deactivator.php
 */
function deactivate_makeandput_button() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-makeandput-button-deactivator.php';
	Makeandput_Button_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_makeandput_button' );
register_deactivation_hook( __FILE__, 'deactivate_makeandput_button' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-makeandput-button.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_makeandput_button() {

	$plugin = new Makeandput_Button();
	$plugin->run();

}

function makeandput_quitar_metabox_publicar() {
    remove_meta_box('submitdiv', 'makeandput_buttons', 'side');
}


run_makeandput_button();



//add_action('add_meta_boxes_makeandput_buttons', 'makeandput_quitar_metabox_publicar');