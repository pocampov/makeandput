<?php
class Makeandput_MetaBox_with_options {
//Crea un metabox con los campos personalizados con las caracterìsticas del botón
    private $menu_options=
	array( // [Option name, variable, method name]
		["Link","url","link"],
		["Send mail","email","email"],
		["Give me Like","like","like"],
		["Rate me","rate","rate"],
		["Search","search","search"]
		);
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
            'advanced', // Contexto del metabox (normal, side o advanced)
            'high' // Prioridad del metabox (high, core, default o low)
        );
    }
	function crear_campos_personalizados() {
		$post_id = get_the_ID();
		$label = '';
		$color = '';
		$likes = 0;
		if (array_key_exists('label', $_POST)) {
			$label = $_POST['label'];
		}
		if (array_key_exists('color', $_POST)) {
			$color = $_POST['color'];
		}
		if (array_key_exists('rounded', $_POST)) {
			$rounded = $_POST['rounded'];
		}
		if (array_key_exists('size', $_POST)) {
			$size = $_POST['size'];
		}
		if (array_key_exists('width', $_POST)) {
			$width = $_POST['width'];
		}
		if (array_key_exists('button', $_POST)) {
			$button = $_POST['button'];
		}
		if (array_key_exists('font_color', $_POST)) {
			$button = $_POST['font_color'];
		}
		if (array_key_exists('actions', $_POST)) {
			$button = $_POST['actions'];
		}
		if (array_key_exists('email', $_POST)) {
			$button = $_POST['email'];
		}
		if (array_key_exists('url', $_POST)) {
			$button = $_POST['url'];
		}
		if (array_key_exists('likes', $_POST)) {
			$button = $_POST['likes'];
		}
		update_post_meta( $post_id, 'label',  $label, true );
		update_post_meta( $post_id, 'color',  $color, true );
		update_post_meta($post_id, 'rounded', $rounded, true);
		update_post_meta($post_id, 'size', $size, true);
		update_post_meta($post_id, 'width', $width, true);
		update_post_meta($post_id, 'button', $button, true);
		update_post_meta($post_id, 'font_color', $font_color, true);
		update_post_meta($post_id, 'actions', $actions, true);
		update_post_meta($post_id, 'email', $mail, true);
		update_post_meta($post_id, 'url', $url, true);
		update_post_meta($post_id, 'likes', $likes, true);
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
		register_meta('servicios', 'button', array(
			'type' => 'string',
			'description' => 'tag del boton',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'font_color', array(
			'type' => 'string',
			'description' => 'tag del boton',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'actions', array(
			'type' => 'string',
			'description' => 'accion del boton',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'action', array(
			'type' => 'string',
			'description' => 'URL o email cuando la accion lo exige',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'email', array(
			'type' => 'string',
			'description' => 'email cuando la accion lo exige',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'url', array(
			'type' => 'string',
			'description' => 'URL cuando la accion lo exige',
			'single' => true,
			'show_in_rest' => true,
		));
		register_meta('servicios', 'likes', array(
			'type' => 'string',
			'description' => 'likes recibidos al boton like',
			'single' => true,
			'show_in_rest' => true,
		));
	}
    public function contenido_metabox( $post ) {
		include("makeandput_array_colors.php");
		$label = get_post_meta( $post->ID, 'label', true );
		$color = get_post_meta( $post->ID, 'color', true );
		$rounded = get_post_meta($post->ID, 'rounded', true);
		$size = get_post_meta($post->ID, 'size', true);
		$width = get_post_meta($post->ID, 'width', true);
		$font_color = get_post_meta($post->ID, 'font_color', true);
		$actions = get_post_meta($post->ID, 'actions', true);
		$email = get_post_meta($post->ID, 'email', true);
		$url = get_post_meta($post->ID, 'url', true);
		$likes = get_post_meta($post->ID, 'likes', true);
		$features = [
			'label' => $label,
			'color' => $color,
			'size' => $size,
			'rounded' => $rounded,
			'width' => $width,
			'font_color' => $font_color,
			'actions' => $actions,
			'url' => $url,
			'email' => $email,
			'likes' => $likes
		];
		echo '<div class="text-center">';
			$features['button'] = $this->render_button($features);
		echo '</div>';
		update_post_meta(get_the_ID(), 'button', $features['button']);
		wp_localize_script('makeandput-button-script',
			'makeandput_variables',
			array('features'=>$features));

		echo '<form>
				';
		$t12 = $this->select_tag($color, 'color', array_reverse($colors), true);

		$t11 = '			<label for="label" style="display:inline-block">' . __('Label: ', 'text-domain') . '</label>';
		$t11 .= '			<input type="text"
							name="label"
							id="label"
							class="input"
							value="' . esc_attr( $label ) . '"
							onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))"
						/>';
		$options = ['4px', '8px', '12px', '50%'];
		$t21 = $this->select_tag($rounded, 'rounded', $options);
		$t22 = $this->select_tag($font_color, 'font_color', $colors, true);
		$t31 = '<label for="width">' . __("Width: ", "text-domain") . '
					<input onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))" type="range" id="width" name="width" min="50" max="600" value="' . esc_attr($width) . '" step="1">
		      </label>';
		$options = array_column($this->menu_options, 0);//['Link', 'Send mail', 'Give me Like', 'Rate me', 'Search', 'Dark mode button', 'Add to Favorites'];
		$t41 = $this->select_tag($actions, 'actions', $options);
		$t32 = '<label for="size">' . __("Size: ", "text-domain") . '
					<input onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))" type="range" id="size" name="size" min="4" max="24" value="' . esc_attr($size) . '" step="2">
		       </label>';
		switch ($actions) {
			case $this->menu_options[0][0]:
				$action = $this->menu_options[0][1];
				$email_visibility = ' style="display: none;" ';
				$label_email_style = ' style="display: none;" ';
				break;
			case $this->menu_options[1][0]:
				$action = $this->menu_options[1][2];
				$url_visibility = ' style="display: none;" ';
				$label_url_style = ' style="display: none;" ';
				break;
			case null:
				$action = $this->menu_options[0][1];
				$email_visibility = ' style="display: none;" ';
				$label_email_style = ' style="display: none;" ';
				break;
		}
		$url_input = '<label for="url" ' . $label_url_style . ' id="label_url">' . __("Link: ", "text-domain") . '</label>
						<input '.$url_visibility.'
								name="url"
								type="url"
								id="url"
								pattern="^(https?:\/\/)?([-\w]+\.){2,}([-\w]+)?([\/?=&#]\S*)?$"
								onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))"
								class="input"
								value="' . esc_attr($url) . '"
						>';
		$email_input = '<label for="email" '.$label_email_style.' id="label_email">' . __("Mail: ", "text-domain") . '</label>
						<input '.$email_visibility.'
								name="email"
								type="email"
								id="email"
								onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))"
								class="input"
								value="' . esc_attr($email) . '"
						>';
		$t42 = $email_input . $url_input;
		include 'plantillas/plantilla_tabla.php';
		echo '</form>';
// REVISAR **
echo '<label for="dark-mode-toggle">Modo oscuro</label>';
echo '<input type="checkbox" id="dark-mode-toggle" onchange="toggleDarkMode()" />';
// **********

		wp_nonce_field( basename( __FILE__ ), 'metabox_nonce' );
		echo '<div class="callout"><cite>';
		echo __('Copy and paste this shortcode to put your button in your page or post:');
		echo	'</cite>';
		echo	'<div class="text-center">';
		echo		'<span id="copyText">[makeandput_button id="'.get_the_ID().'" /]</span>';
		echo		'<div class="badge rounded-pill">
						<a onclick="makeandput_copy_text(\'copyText\')" > copy </a>
					 </div>';
		echo	'</div>';
		echo '</div>';
		echo get_submit_button(__('Apply and Save'));
	}
	function select_tag(&$value,$tag_name, $options,$is_color=false){
		//Determino si $options tiene mas de una dimensión
		if (count($options, COUNT_RECURSIVE) == count($options)) {
			// Convierto $options de una a dos dimensiones
			foreach ($options as $i=>$option) {
				$new_options[$i] = array('name'=> $option,'value' => $option);
			}
			$options = $new_options;
		}
		$label = ucfirst($tag_name);
		$out = '	<label for="' . $tag_name . '" style="display:inline-block">' . __("$label: ", "text-domain") . '</label>';
		$out .= '	<select id="'.$tag_name.'" name="'.$tag_name.'" value="'. esc_attr($value).'" onchange="makeandput_update_button(document.querySelector(\'#makeandput_button\'))" style="display:inline-block">';
					foreach ($options as $key=>$option){
					$out .= '<option value="'.$option["value"].'"';
						if ($option["value"] == esc_attr($value))
							$out .= ' selected ';
						if ($is_color)
							$out .= 'style="background-color:' . $option["value"] . '"';
						$out .= '>'.$option["name"].'</option>';
					}
		$out .= '	</select>';
		return $out;
	}
	function render_button($features)
	{
		$text = $features['label'];
		if ($features["actions"] == $this->menu_options[1][0]){
			$contenido = json_encode(array('titulo'=>'Envío de correo',
								'cuerpo'=>'Alguna cosa'));
			$run = "modal('Env&iacute;o de correo','". plugins_url('makeandput-button')."');";
		}
		if ($features["actions"] == $this->menu_options[0][0]){
			$run = strtolower($features["actions"]) . '(\'' . $features["url"] . '\')"';
		}
		if ($features["actions"] == $this->menu_options[2][0]) {
			$run = "givemelike(".get_the_ID().")";
			$heart = ' <span id="makeandput_likes'. get_the_ID().'" class="badge text-bg-secondary">
							 '. $features["likes"].'
						</span><span id="makeandput_heart'.get_the_ID().'" style="display:none"></span>';
		}
		if ($text == '')
			$text = "LABEL";
		//"' . strtolower($features["actions"]) . '(\''. $features["url"].'\')"
		$ajaxurl = "'".admin_url('admin-ajax.php'). "'";

		$button = '
				<button name = "my-button"
						id = "makeandput_button"'.get_the_ID().'
						class ="btn border border-3 "
						onclick ="event.preventDefault();'.$run.' "
						style = "
						background-color:'.$features["color"].';
						font-size:'.$features["size"].'px; /* Button Size */
						border-radius:'.$features["rounded"].';
						color:'.$features["font_color"] . '; /* Text Color */
						width:'. $features["width"] .'px;
						font-weight: bold;

						"
			>'
						. $features["label"]. $heart .'
				</button>';
		echo $button;
		return $button;
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
		$button = isset($_POST['button']) ? sanitize_text_field($_POST['button']) : '';
		$font_color = isset($_POST['font_color']) ? sanitize_text_field($_POST['font_color']) : '';
		$actions = isset($_POST['actions']) ? sanitize_text_field($_POST['actions']) : '';
		$email = isset($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
		$url = isset($_POST['url']) ? sanitize_text_field($_POST['url']) : '';
		$likes = isset($_POST['likes']) ? sanitize_text_field($_POST['likes']) : 0;
		// Actualizar los valores en la base de datos.
		update_post_meta($post_id, 'label', $label );
		update_post_meta($post_id, 'color', $color );
		update_post_meta($post_id, 'rounded', $rounded);
		update_post_meta($post_id, 'size', $size);
		update_post_meta($post_id, 'width', $width);
		update_post_meta($post_id, 'button', $button);
		update_post_meta($post_id, 'font_color', $font_color);
		update_post_meta($post_id, 'actions', $actions);
		update_post_meta($post_id, 'email', $email);
		update_post_meta($post_id, 'url', $url);
		update_post_meta($post_id, 'likes', $likes);
	}
}