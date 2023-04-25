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
		$label = '';
		$color = '';
		if (array_key_exists('label', $_POST)) {
			$label = $_POST['label'];
		}
		if (array_key_exists('color', $_POST)) {
			$color = $_POST['color'];
		}
		if (array_key_exists('rounded', $_POST)) {
			$label = $_POST['rounded'];
		}
		if (array_key_exists('size', $_POST)) {
			$label = $_POST['size'];
		}
		if (array_key_exists('width', $_POST)) {
			$label = $_POST['width'];
		}
		update_post_meta( $post_id, 'label',  $label, true );
		update_post_meta( $post_id, 'color',  $color, true );
		update_post_meta($post_id, 'rounded', $rounded, true);
		update_post_meta($post_id, 'size', $size, true);
		update_post_meta($post_id, 'width', $width, true);
	    register_meta( 'servicios', 'label', array(
			'type' => 'string',
			'description' => 'Label del boton',
			'single' => true,
			'show_in_rest' => true,
		) );
		register_meta( 'servicios', 'color', array(
			'type' => 'string',
			'description' => 'Color del boton',
			'single' => true,
			'show_in_rest' => true,
		) );
		register_meta('servicios', 'rounded', array(
			'type' => 'string',
			'description' => 'Redondeo de las esquinas del boton',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'size', array(
			'type' => 'string',
			'description' => 'Tamaño de la fuente que cambia altura del botón',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'width', array(
			'type' => 'string',
			'description' => 'Ancho del boton',
			'single' => true,
			'show_in_rest' => true,
		));

	}
    public function contenido_metabox( $post ) {
		include("makeandput_array_colors.php");
		$label = get_post_meta( $post->ID, 'label', true );
		$color = get_post_meta( $post->ID, 'color', true );
		$rounded = get_post_meta($post->ID, 'rounded', true);
		$features = [
			'label' => $label,
			'color' => $color,
			'size' => $size,
			'rounded' => $rounded
		];
		$this->render_button($features);
		wp_localize_script('makeandput-button-script',
			'makeandput',
			array('features'=>$features));
		echo '
		<div class="row">
			<div class="large-4 columns">
			  <label for="color">' . __('Color: ', 'text-domain' ).'
				<select name="color" id="color"
						onchange="makeandput_update_button(document.querySelector(\'#makeandput-button\'))">
					<option>'.__("Seleccione el color").'</option>';
					for ($i = sizeof($colors); $i > 0;$i--) {
						echo '<option value="'.$colors[$i]["value"].'"';
						if ($colors[$i]["value"] == esc_attr( $color ))
							echo 'selected ';
						echo 'style="background-color:'. $colors[$i]["value"].'">'.$colors[$i]["name"].'</option>';
					}
				echo '</select>
			  </label>';
		echo '<label for="label">' . __('Label: ', 'text-domain' ) . '</label>';
		echo '<input type="text" name="label" id="label"
					class="large-4 columns" value="' . esc_attr( $label ) . '"
					onchange="makeandput_update_button(document.querySelector(\'#makeandput-button\'))"
			   >';
		echo '<label for="rounded">' . __("Rounded: ", "text-domain") . '
				<select id="rounded" name="rounded" value="' .esc_attr($rounded). '">
					<option value="4px">4px</option>
					<option value="8px"';
					if ($rounded == "8px")
						echo ' selected';
					echo '>8px</option>
					<option value="12px"';
					if ($rounded == "12px")
						echo ' selected';
					echo '>12px</option>
					<option value="50%"';
					if ($rounded == "50%")
						echo ' selected';
					echo '>50%</option>
				</select>
			  </label>';
		echo '	</div>
			</div>';

		echo get_submit_button(__('Apply and Save'));

		wp_nonce_field( basename( __FILE__ ), 'metabox_nonce' );
    }

	function render_button($features)
	{
		$text = $features['label'];
		if ($text == '')
			$text = "LABEL";
		$button = '';
		echo '
			<div class="text-center">
				<button name = "my-button"
						id = "makeandput-button"
						class ="button "
						style = "
						background-color:'.$features["color"].';
						font-size:'.'16'.'; /* Button Size */
						border-radius:'.$features["rounded"].';
						color:'.'#030710' . '; /* Text Color */
						width:'. '100' .'px;


						"
			>'
						. $features["label"] . '
				</button>
			</div>';
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
		// Guardar los valores de las caracteristicas del botón.
		$label = isset( $_POST['label'] ) ? sanitize_text_field( $_POST['label'] ) : '';
		$color = isset( $_POST['color'] ) ? sanitize_text_field( $_POST['color'] ) : '';
		$rounded = isset($_POST['rounded']) ? sanitize_text_field($_POST['rounded']) : '';
		$size = isset($_POST['size']) ? sanitize_text_field($_POST['size']) : '';
		$width = isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';

		// Actualizar los valores en la base de datos.
		update_post_meta($post_id, 'label', $label );
		update_post_meta($post_id, 'color', $color );
		update_post_meta($post_id, 'rounded', $rounded);
		update_post_meta($post_id, 'size', $size);
		update_post_meta($post_id, 'width', $width);
	}

}