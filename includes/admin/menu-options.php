<?php

function dropdown_menu_item_description($post) {
	$dish_data = get_post_meta($post->ID, 'dish_data', true);
	
	if (!$dish_data) {
		$dish_data = array(
			'description'	=>	'',
			'price'			=>	'',
			'unit'			=>	'',
		);
	}
	?>
	
	<div class="form-group">
		<label for="drm_description">Description</label>
		<textarea class="form-control" name="drm_description" id="drm_description"><?php
				echo $dish_data['description'];
			?></textarea>
	</div>
	
	<div class="form-group">
		<label for="drm_price">Price</label>
		<input type="text" pattern="^(?:\d{0,4})(?:.?)((?:\d{0})|(?:\d{2}))$" class="form-control" name="drm_price" id="drm_price" value="<?php	echo $dish_data['price'];	?>"/>
	</div>
	
	<div class="form-group">
		<label for="drm_unit">Units (leave blank if unsure)</label>
		<input type="text" class="form-control" name="drm_unit" id="drm_unit" value="<?php	echo $dish_data['unit'];	?>"/>
	</div>
	<?php
}
	
?>