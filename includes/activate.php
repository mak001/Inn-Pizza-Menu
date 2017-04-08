<?php

function dropdown_restaurant_menu_activate_plugin() {
	if (version_compare(get_bloginfo('version'), '4.2', '<')) {
		wp_die(__('Update WordPress to version 4.2 or higher', 'resturaunt_menu'));
	}
}

?>