<?php
class Makeandput_MetaBox_with_options {
//Crea un metabox con los campos personalizados con las caracterìsticas del botón	
    public function __construct() {
		add_action( 'add_meta_boxes', array($this,'crear_campos_personalizados') );
        add_action( 'add_meta_boxes', array( $this, 'agregar_metabox' ) );
        add_action( 'save_post', array( $this, 'guardar_metabox' ) );
		
    }

    public function agregar_metabox() {
        add_meta_box(
            'button_features', // ID del metabox
            __( 'Setup your button', 'text-domain' ), // Título del metabox
            array( $this, 'contenido_metabox' ), // Función para mostrar el contenido
            'makeandput_buttons', // Nombre del post type donde aparecerá el metabox
            'normal', // Contexto del metabox (normal, side o advanced)
            'high' // Prioridad del metabox (high, core, default o low)
        );
    }
	function crear_campos_personalizados() {
		$post_id = get_the_ID();
		$campo_1_value = '';
		$campo_2_value = '';
		if (array_key_exists('campo_1', $_POST)) {
			$campo_1_value = $_POST['campo_1'];
		}
		if (array_key_exists('campo_2', $_POST)) {
			$campo_2_value = $_POST['campo_2'];
		}
		update_post_meta( $post_id, 'campo_1',  $campo_1_value, true );
		update_post_meta( $post_id, 'campo_2',  $campo_2_value, true );
	    register_meta( 'servicios', 'campo_1', array(
			'type' => 'string',
			'description' => 'Campo personalizado 1',
			'single' => true,
			'show_in_rest' => true,
		) );
	  
		register_meta( 'servicios', 'campo_2', array(
			'type' => 'string',
			'description' => 'Campo personalizado 2',
			'single' => true,
			'show_in_rest' => true,
		) ); 
		
	}
    public function contenido_metabox( $post ) {
		$campo_1_value = get_post_meta( $post->ID, 'campo_1', true );
		$campo_2_value = get_post_meta( $post->ID, 'campo_2', true );

		echo '<label for="campo_1">' . __('Label: ', 'text-domain' ) . '</label>';
		echo '<input type="text" name="campo_1" id="campo_1" value="' . esc_attr( $campo_1_value ) . '"><br>';
		
		echo '<label for="campo_2">' . __('Color: ', 'text-domain' ) . '</label>';
		echo '<input type="text" name="campo_2" id="campo_2" value="' . esc_attr( $campo_2_value ) . '">';
		wp_nonce_field( basename( __FILE__ ), 'metabox_nonce' );
    }

	public function guardar_metabox( $post_id ) {
		// Verificar el nonce.
		if ( !isset( $_POST['metabox_nonce'] ) || !wp_verify_nonce( $_POST['metabox_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}
	
		// Comprobar si el usuario tiene permiso para editar.
		if ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// Guardar los valores del campo 1 y 2.
		$campo_1_value = isset( $_POST['campo_1'] ) ? sanitize_text_field( $_POST['campo_1'] ) : '';
		$campo_2_value = isset( $_POST['campo_2'] ) ? sanitize_text_field( $_POST['campo_2'] ) : '';

		// Actualizar el valor en la base de datos.
		update_post_meta( $post_id, 'campo_1', $campo_1_value );
		update_post_meta( $post_id, 'campo_2', $campo_2_value );
	}
	function crear_nuevo_post_type() {
		// Recuperar los datos enviados por el formulario
		$titulo = $_POST['titulo'];
		$contenido = $_POST['contenido'];

		// Configurar los argumentos para la creación del post type
		$args = array(
		'post_title' => $titulo,
		'post_content' => $contenido,
		'post_type' => 'nombre_del_post_type',
		'post_status' => 'publish'
		);

		// Insertar el nuevo post type en la base de datos
		$post_id = wp_insert_post($args);

		// Redirigir al usuario a la página de edición del nuevo post type
		wp_redirect(admin_url('post.php?action=edit&post=' . $post_id));
		exit;
	}


}