<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://monodelapila.com
 * @since      1.0.0
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/includes
 * @author     Pedro Ocampo <pocampov@gmail.com>
 */
class Makeandput_Button {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Makeandput_Button_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'MAKEANDPUT_BUTTON_VERSION' ) ) {
			$this->version = MAKEANDPUT_BUTTON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'makeandput-button';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
		//Create main Metabox
		require_once plugin_dir_path( __FILE__ ) . 'class-makeandput-metabox-with-options.php';
		new Makeandput_MetaBox_with_options();
		//Create new post Type
		require_once plugin_dir_path( __FILE__ ) . 'class-makeandput-Button-Post-Type.php';

		new Makeandput_Button_Post_Type();
		add_action('add_meta_boxes_makeandput_buttons', 'makeandput_quitar_metabox_publicar');

		add_shortcode('makeandput_button', array($this, 'makeandput_button_shortcode'));
		$post_data = array(
			'post_title' => 'Send Mail',
			'post_content' => 'UNA PRUEBA',
			'post_status' => 'draft',
			// Establecer el estado del post en borrador para que no sea visible públicamente
			'post_type' => 'post', // El tipo de post en el que se creará el formulario (puede ser "post", "page", "custom_post_type", etc.)
		);
		// Vinculo con funcionn javascript
		add_action('wp_ajax_mi_funcion_php',array($this, 'mi_funcion_php'));

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Makeandput_Button_Loader. Orchestrates the hooks of the plugin.
	 * - Makeandput_Button_i18n. Defines internationalization functionality.
	 * - Makeandput_Button_Admin. Defines all hooks for the admin area.
	 * - Makeandput_Button_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-makeandput-button-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-makeandput-button-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-makeandput-button-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-makeandput-button-public.php';

		$this->loader = new Makeandput_Button_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Makeandput_Button_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Makeandput_Button_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Makeandput_Button_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		// Añadimos plugin al menú principal
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Makeandput_Button_Public( $this->get_plugin_name(), $this->get_version() );

		$work_find = $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
		if (!$work_find)
			$plugin_public->enqueue_styles();
		$work_find = $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 10, 1);
		if (!$work_find)
			$plugin_public->enqueue_scripts();
		wp_enqueue_style('foundation-css', plugin_dir_url('') . 'makeandput-button/public/css/Foundation-Sites-CSS/css/foundation.min.css');
		wp_enqueue_script('foundation-js', plugin_dir_url('') . 'makeandput-button/public/css/Foundation-Sites-CSS/js/vendor/foundation.min.js', array('jquery'), '6.5.3', true );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Makeandput_Button_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	function makeandput_button_shortcode($atts,$button)
	{
		$post_id = $atts['id'];
		$button = get_post_meta( $post_id, 'button', true );
		$likes = strval($this->get_likes($post_id));
		return $button."<div id='mi-modal' ></div>
							<script>
								var element = document.getElementById('makeandput_likes'+$post_id);
								if (element !== null) {
									element.innerHTML = $likes;
								}
							</script>";
	}
	function get_likes($id)
	{
		$out = get_post_meta($id,'likes',true);
		if (!isset($out))
			$out = 0;
		return $out;
	}
	function mi_funcion_php()
	{
		// To implement
		wp_die();
	}
}

