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
function uninstall_makeandput_button()
{
	// Elimina los post types personalizados creadas por el plugin
	unregister_post_type('makeandput_buttons');
	// Eliminar las claves de post-meta asociadas con el plugin
	$args = array(
		'post_type' => 'makeandput_buttons',
		'posts_per_page' => -1,
		'post_status' => array('publish', 'pending', 'draft', 'future', 'private'),
	);
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		while ($query->have_posts()) {
			$query->the_post();
			$id = get_the_ID();
			// Mueve el post a la papelera antes de eliminar las claves de post-meta
			wp_trash_post($id);
			// Elimina variables personalizadas
			delete_post_meta($id, 'label');
			delete_post_meta($id, 'color');
			delete_post_meta($id, 'rounded');
			delete_post_meta($id, 'size');
			delete_post_meta($id, 'width');
			delete_post_meta($id, 'button');
			delete_post_meta($id, 'font_color');
			delete_post_meta($id, 'actions');
			delete_post_meta($id, 'email');
			delete_post_meta($id, 'url');
			delete_post_meta($id, 'likes');
			delete_post_meta($id, 'stars');
		}
		wp_reset_postdata();
	}
}
register_activation_hook( __FILE__, 'activate_makeandput_button' );
register_deactivation_hook( __FILE__, 'deactivate_makeandput_button' );
register_uninstall_hook(__FILE__, 'uninstall_makeandput_button');
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
add_action('before_delete_post', 'delete_custom_post_meta_on_delete');
function delete_custom_post_meta_on_delete($post_id)
{
	if (get_post_type($post_id) == 'makeandput_buttons') {
		delete_post_meta($post_id, 'label');
		delete_post_meta($post_id, 'color');
		delete_post_meta($post_id, 'rounded');
		delete_post_meta($post_id, 'size');
		delete_post_meta($post_id, 'width');
		delete_post_meta($post_id, 'button');
		delete_post_meta($post_id, 'font_color');
		delete_post_meta($post_id, 'actions');
		delete_post_meta($post_id, 'email');
		delete_post_meta($post_id, 'url');
		delete_post_meta($post_id, 'likes');
		delete_post_meta($post_id, 'stars');
	}
}
function run_makeandput_button() {

	$plugin = new Makeandput_Button();
	$plugin->run();

}

function makeandput_quitar_metabox_publicar() {
    remove_meta_box('submitdiv', 'makeandput_buttons', 'side');
}


run_makeandput_button();



//add_action('add_meta_boxes_makeandput_buttons', 'makeandput_quitar_metabox_publicar');