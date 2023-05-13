<?php
add_filter('post_updated_messages', array($this, 'quita_mensaje'), 10, 2);
function quita_mensaje()
{
	unset($GLOBALS['messages']['updated']);
}
