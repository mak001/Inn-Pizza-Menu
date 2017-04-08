<?php

function dropdown_restaurant_menu_create_metaboxes() {
	add_meta_box(
		// id of metabox (shows up in html)
		'dropdown_menu_item_description',
		// title of metabox
		__('Description', 'dropdown_restaurant_menu'),
		// function it calls when displayed
		'dropdown_menu_item_description',
		// post type
		'restaurant_menu_item',
		// context - where it should appear
		'normal',
		// priority
		'high'
	);
}

function add_dish_types_group_field($taxonomy) {
	?>
	<div class="form-field term-show-wrap">
		<label for="should_show">Show sub-section title (does not affect main sections)</label>
		<div class="term-show-option">
			<input type="radio" name="should_show" id="should_show_true" value="true" checked="checked"/>
			<label for="should_show_true">Show</label>
		</div>
		<div class="term-show-option">
			<input type="radio" name="should_show" id="should_show_false" value="false"/>
			<label for="should_show_false">Hide</label>
		</div>
	</div>
	
	<div class="form-field term-image-wrap">
		<label for="meta-image"><?php _e( 'Background image', 'dropdown_restaurant_menu' )?></label>
		<img src="" id="meta-image-example" width="150" height="150">
			<input type="text" name="meta-image" id="meta-image" value="" hidden="hidden"/>
		<input type="button" id="meta-image-button" class="button" value="<?php _e('Choose or Upload an Image', 'dropdown_restaurant_menu')?>" />
	</div>
	<?php
}

function add_dish_types_edit_group_field($taxonomy) {
	$meta = get_term_meta($taxonomy->term_taxonomy_id, 'tax_data', true);
	
	if (!$meta) {
		$meta = array(
			'should_show'			=>	true,
			'meta_image'			=>	'',
		);
	}
	
	if (!isset($meta['meta_image'])) {
		$meta['meta_image'] = '';
	}
	
	?>
	
	<tr class="form-field term-show-wrap">
        <th scope="row"><label for="should_show">Show sub-section title<br>(does not affect main sections)</label></th>
        <td>
			<div class="term-show-option">
				<input type="radio" name="should_show" id="should_show_true" value="true" <?php
					if (!isset($meta['should_show']) || $meta['should_show'] == 'true') {
						echo 'checked="checked"';
					}
				?>>
				<label for="should_show_true">Show</label>
				</div>
				<div class="term-show-option">
				<input type="radio" name="should_show" id="should_show_false" value="false" <?php
					if ($meta['should_show'] === 'false') {
						echo 'checked="checked"';
					}
				?>>
				<label for="should_show_false">Hide</label>
			</div>
        </td>
    </tr>
	
	<tr>
		<th scope="row"><label for="meta-image"><?php _e( 'Background image', 'dropdown_restaurant_menu' )?></label></th>
		<td class="form-field term-image-wrap">
			<img src="<?php	echo $meta['meta_image'];	?>" id="meta-image-example" width="150" height="150">
			<input type="text" name="meta-image" id="meta-image" value="<?php	echo $meta['meta_image'];	?>" hidden="hidden"/>
			<input type="button" id="meta-image-button" class="button" value="<?php _e('Choose or Upload an Image', 'dropdown_restaurant_menu')?>" />
		</td>
	</tr>
	<?php
}

?>