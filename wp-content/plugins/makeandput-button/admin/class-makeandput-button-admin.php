<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://monodelapila.com
 * @since      1.0.0
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/admin
 * @author     Pedro Ocampo <pocampov@gmail.com>
 */
class Makeandput_Button_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Makeandput_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Makeandput_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/makeandput-button-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Makeandput_Button_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Makeandput_Button_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/makeandput-button-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function add_menu() {
		add_menu_page(
		"Make & Put", // Título de la página
		"Make&Put", // Literal de la opción
		"manage_options", // Dejadlo tal cual
		'makeandput', // Slug
		array( $this, 'admin_content' ), // Función que llama al pulsar
		plugins_url( 'images/makeandput.png', __FILE__ )  // Icono del menú
		);
	}

	public function admin_content() {
		echo "Hola Mundo ".plugins_url( 'public/images/makeandput.png', __FILE__ ) ;
	}

}
