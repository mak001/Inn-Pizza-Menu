<?php

function dropdown_restaurant_menu_save_post_admin($post_id, $post, $update) {
	if ($update == false) {
		return;
	}
	
	if (isset($_POST['drm_description']) || isset($_POST['drm_price']) ||
	  isset($_POST['drm_unit'])) {
		$dish_data = array();
		$dish_data['description'] = sanitize_text_field($_POST['drm_description']);
		$dish_data['price'] = sanitize_text_field($_POST['drm_price']);
		$dish_data['unit'] = sanitize_text_field($_POST['drm_unit']);
		
		update_post_meta($post_id, 'dish_data', $dish_data);
	}
}

?>