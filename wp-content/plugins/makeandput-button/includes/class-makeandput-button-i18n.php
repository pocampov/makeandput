<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://monodelapila.com
 * @since      1.0.0
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/includes
 * @author     Pedro Ocampo <pocampov@gmail.com>
 */
class Makeandput_Button_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'makeandput-button',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
