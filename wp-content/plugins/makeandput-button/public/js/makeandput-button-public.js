(function ($) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	function llamar_funcion_php(php_function,parameter) {
		if (typeof ajaxurl === "undefined") {
			var ajaxurl = makeandput_datos.ajaxurl;
		}
		jQuery.ajax({
			url: ajaxurl,
			type: 'POST',
			data: {
				action: php_function,
				nonce: makeandput_datos.nonce,
				parameters: parameter
			},
			success: function (resultado) {
			}
		}); 
	}
	window.llamar_funcion_php = llamar_funcion_php;

})(jQuery);

function makeandput_update_button(buttonObject) {
	var colorHex = document.getElementById("color").value;
	var size = document.getElementById("size").value + 'px';
	var rounded = document.getElementById("rounded").value;
	var label = document.getElementById("label").value;
	var width = document.getElementById("width").value + 'px';
	var font_color = document.getElementById("font_color").value;
	var actions = document.getElementById("actions").value;
	buttonObject.style.backgroundColor = colorHex;
	buttonObject.textContent = label;
	buttonObject.style.borderRadius = rounded;
	buttonObject.style.width = width;
	buttonObject.style.fontSize = size;
	buttonObject.style.color = font_color;
	if (actions == "Send mail") {
		document.getElementById("label_url").style.display = "none";
		document.getElementById("label_email").style.display = "block";
		document.getElementById("url").style.display = "none";
		document.getElementById("email").style.display = "inline-block";
	}
	else if (actions == "Link") {
		document.getElementById("label_email").style.display = "none";
		document.getElementById("label_url").style.display = "block";
		document.getElementById("email").style.display = "none";
		document.getElementById("url").style.display = "block";
	} else {
		document.getElementById("label_email").style.display = "none";
		document.getElementById("label_url").style.display = "none";
		document.getElementById("email").style.display = "none";
		document.getElementById("url").style.display = "none";
    }
}

function makeandput_copy_text(id_tag) {
	var content = document.getElementById(id_tag).innerText;
	var temp = document.createElement('textarea');
	temp.value = content;
	document.body.appendChild(temp);
	temp.select();
	document.execCommand('copy');
	document.body.removeChild(temp);
}
function link(url) {
	window.open(url);
}

async function modal(title, path) {
	var destino = path + '/public/partials' + '/plantilla_correo.htm';
	const response = await fetch(destino);
	const body = await response.text();
	var elboton = document.getElementById('makeandput_button');
	//event.stopPropagation();
	var modalContainer = document.getElementById("mi-modal");
	var content = `<div class="card bg-body-secondary "
						style="position: fixed;
							   --bs-bg-opacity: .97;
							   top: 50%;
							   left: 50%;
							   transform: translate(-50%, -50%);
							   z-index: 9999;">
						<p> `+ body +`</p>
						<button type='button' id='mandp_button' class='makeandput-button-close' >
							<span class="material-symbols-outlined">
								close
							</span>
						</button>
					</div > `;

	modalContainer.innerHTML = content;
	modalContainer.style.display = "block";
	//Detecta click por fuera del modal
	document.addEventListener("click", function (event) {
		if (!modalContainer.contains(event.target) && !elboton.contains(event.target)) {
			modalContainer.style.display = "none";
		}
	});
	miBoton = document.getElementById('mandp_button');
	miBoton.addEventListener("click", function () {
		modalContainer.style.display = "none";
	});

}
function envia_correo() {
	var subject = document.getElementById("subject").value;
	var recipient = document.getElementById("recipient-email").value;
	var message = document.getElementById("message").value;
	var parameter = {
		'subject': subject,
		'recipient': recipient,
		'message': message,
	}
	llamar_funcion_php("mi_funcion_php", parameter);	
}
function givemelike(id) {
	var heart_button = document.getElementById("makeandput_button"+id);
	var heart = document.getElementById("makeandput_heart"+id);
	var likes = parseInt(document.getElementById("makeandput_likes"+id).innerHTML);

	heart.style.display = 'inline-block';
	heart.classList.add('makeandput_heart');
	setTimeout(function () {
		heart.classList.remove('makeandput_heart');
	}, 1000);
	
	likes = likes + 1;
	document.getElementById("makeandput_likes"+id).innerHTML = likes;
	var parameter = {
		'id': id,
		'likes': likes,
	}
	llamar_funcion_php("save_likes_php", parameter);
}


function toggleDarkMode() {
	const body = document.body;
	const button = document.getElementById("dark-mode-toggle");

	// Toggle the 'dark-mode' class on the body element
	body.classList.toggle("dark-mode");

	// Toggle the text of the button
	button.textContent = body.classList.contains("dark-mode") ? "Light Mode" : "Dark Mode";

	// Modify other styles
	if (body.classList.contains("dark-mode")) {
		// Dark mode styles
		body.style.backgroundColor = "#222";
		body.style.color = "#fff";
	} else {
		// Light mode styles
		body.style.backgroundColor = "#fff";
		body.style.color = "#222";
	}
}