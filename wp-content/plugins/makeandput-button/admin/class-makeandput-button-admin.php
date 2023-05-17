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
class Makeandput_Button_Admin
{

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
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/makeandput-button-admin.css', array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/makeandput-button-admin.js', array('jquery'), $this->version, false);

	}
	public function add_menu()
	{
		add_menu_page(
			"Make & Put",
			// Título de la página
			"Make&Put",
			// Literal de la opción
			"manage_options",
			'makeandput',
			array($this, 'admin_content'),
			plugins_url('images/makeandput.png', __FILE__)
		);
	}

	public function admin_content()
	{
		$admin_partials_path = $plugin_path . 'partials/template_carrusel.php';
		//include "partials/template_carrusel.php";

		echo "
			<h1>Make&Put</h1>
			<p>Is a plugin to you do yours buttons. You choose: the color, the size, the font color and box rounded.<br>
			The plugin produce a short-code that you could put in yours
			own post and pages.</p><br>
			Some examples:<br>";
		$imagen1 = plugins_url('images/button1.png', __FILE__);
		$imagen2 = plugins_url('images/button2.png', __FILE__);
		$imagen3 = plugins_url('images/button3.png', __FILE__);
		$imagen4 = plugins_url('images/button4.png', __FILE__);
		$title1 = "Link Button";
		$title2 = "Mail Button";
		$title3 = "Like Button";
		$title4 = "Rating Button";
		$content1 = "When clicked, another browser tab opens with the link that you indicate.";
		$content2 = "When clicked, open a modal with mail-form.";
		$content3 = "When clicked, a little heart appear upping for a second, it disappear then the counter is increment.";
		$content4 = "When clicked, the button is replaced by a box to do a rating.";
		$other_content1 = "";
		$other_content2 = "";
		$other_content3 = "";
		$other_content4 = "<img src='".plugins_url('images/rating.png', __FILE__)."' />
							<br><small class=\"text-muted\">Only one per page</small>";
		require_once plugin_dir_path(__FILE__) . 'partials/template_carrusel.php';

		echo "Navigate to <img src='".
			plugins_url('images/my-buttons.png', __FILE__)."'
			style='width: 12%; hight: 12%'/>  item menu and start creating.  Make and put your own buttons.";
	}
}
