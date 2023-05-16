<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://monodelapila.com
 * @since      1.0.0
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Makeandput_Button
 * @subpackage Makeandput_Button/public
 * @author     Pedro Ocampo <pocampov@gmail.com>
 */
class Makeandput_Button_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		// Permite llamadas desde javascript
		add_action('wp_ajax_mi_funcion_php', array($this, 'mi_funcion_php'));
		add_action( "wp_ajax_nopriv_mi_funcion_php", array($this, 'mi_funcion_php'));
		add_action('wp_ajax_save_likes_php', array($this, 'save_likes_php'));
		add_action( "wp_ajax_nopriv_save_likes_php", array($this, 'save_likes_php'));
		add_action('wp_ajax_save_rateme_php', array($this, 'save_rateme_php'));
		add_action( "wp_ajax_nopriv_save_rateme_php", array($this, 'save_rateme_php'));
		add_action('wp_ajax_average_rating_php', array($this, 'average_rating_php'));
		add_action( "wp_ajax_nopriv_average_rating_php", array($this, 'average_rating_php'));

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/makeandput-button-public.css', array(), $this->version, 'all' );
		wp_enqueue_style($this->plugin_name.'-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap/css/bootstrap.css', array(), '', 'all');
		wp_enqueue_style($this->plugin_name . '-material-icons', 'https://fonts.googleapis.com/css2?family=Material+Icons&display=block', array(), '', 'all');

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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
		wp_enqueue_script( $this->plugin_name.'-script', plugin_dir_url( __FILE__ ) . 'js/makeandput-button-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script($this->plugin_name . '-bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap/js/bootstrap.js', array('jquery'), $this->version, true);

		// Define el objeto de datos para pasar a wp_localize_script()
		add_action('init', array($this,'generate_nonce'));
		$datos = array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'nonce' => $this->generate_nonce()
		);

		// Utiliza wp_localize_script() para pasar los datos al Front
		wp_localize_script( 'makeandput-button-script', 'makeandput_datos', $datos );

	}
	function generate_nonce()
	{
		$nonce = "kjnl32rfnlqwef9u0d";
		return $nonce;
	}
	function mi_funcion_php()
	{
		$parameters = $_POST['parameters'];
		$subject = sanitize_text_field($parameters['subject']);
		$recipient = sanitize_text_field($parameters['recipient']);
		$message = sanitize_text_field($parameters['message']);
		$result = wp_mail($recipient, $subject, $message);
		return $result;
		wp_die();
	}
	function save_likes_php()
	{
		$parameters = $_POST['parameters'];
		$id = sanitize_text_field($parameters['id']);
		$likes = sanitize_text_field($parameters['likes']);
		$result = update_post_meta($id, 'likes', $likes);
		return $result;
		wp_die();
	}
	function save_rateme_php()
	{
		$parameters = $_POST['parameters'];
		$id = sanitize_text_field($parameters['id']);
		$rate = sanitize_text_field($parameters['rate']);
		$session = $this->get_session();
		$stars = get_post_meta($id, 'stars', true);
		if (!is_array($stars)) {
			$stars = array(); // Si no existe un array, inicialízalo como un array vacío
		}
		
		$stars["$session"] = $rate;
		$result = update_post_meta($id, "stars", $stars);
		
		wp_die();
	}
	function average_rating_php()
	{
		$parameters = $_POST['parameters'];
		$post_id = sanitize_text_field($parameters['id']);
		$stars = get_post_meta($post_id, 'stars', true);
		$tot = 0;
		foreach($stars as $star)
		{
			$tot += $star;
		}
		$average = $tot / count($stars);
		echo $average;
	}
	function get_client_ip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}

		return $ip;
	}
	function get_session()
	{
		$numero_sesion = session_id();

		if (!empty($numero_sesion)) {
			echo "El número de sesión del usuario es: " . $numero_sesion;
		} else {
			session_start();
			$numero_sesion = session_id();
		}
		return $numero_sesion;
	}
}
