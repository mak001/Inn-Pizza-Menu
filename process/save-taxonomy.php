<?php

function dropdown_restaurant_menu_save_taxonomy_admin($tax_id) {
	if (isset($_POST['should_show']) || isset($_POST['meta-image'])) {
		$tax_data = array();
		$tax_data['should_show'] = sanitize_text_field($_POST['should_show']);
		$tax_data['meta_image'] = esc_url_raw($_POST['meta-image']);
		update_term_meta($tax_id, 'tax_data', $tax_data);
	}
}

?>