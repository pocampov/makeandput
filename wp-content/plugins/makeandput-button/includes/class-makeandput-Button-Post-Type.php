<?php
class Makeandput_Button_Post_Type {
// Create a Post Type to buttons shortcodes
    public function __construct() {
        add_action( 'init', array( $this, 'register_post_type' ) );
    }

	public function register_post_type()
	{
		$labels = array(
			'name' => __( 'Buttons', 'text-domain' ),
			'singular_name' => __( 'Button', 'text-domain' ),
			'add_new'	=> __('Add Button'),
			'menu_name' => __('My Buttons'),
			'add_new_item' => __('Add New Custom Button'),
			'edit_item' => __('Edit Button'),
        );
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => true,
			'menu_icon' => 'dashicons-align-pull-left',
			'supports' => array( 'title','edit' ),
			'show_ui' => true,
			'rewrite' => array( 'slug' => 'servicios' ),
		);
		register_post_type('makeandput_buttons', $args );
		add_filter('enter_title_here', function($title) {
			$post_type = get_post_type();
			if ($post_type === 'makeandput_buttons') {
				$title = __('Name your button');
			}
		add_filter('get_sample_permalink_html', array($this,'ocultar_enlace_permanente'), 10, 2);
		add_filter('admin_post_makeandput_buttons', array($this,'quita_mensaje'),10,2);
		return $title;
		});
	}
	function ocultar_enlace_permanente($return, $id)
	{
		// Comprobamos que estamos en el post type deseado
		if (get_post_type($id) === 'makeandput_buttons') {
			// Si estamos en el post type deseado, eliminamos el HTML del enlace permanente
			$return = '';
		}
		return $return;
	}
	function quita_mensaje($post_id)
	{
		unset($GLOBALS['messages']['updated']);
		return $messages;
	}
}