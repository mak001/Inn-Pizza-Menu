<?php

function dropdown_restaurant_menu_menu_generator_shortcode() {
	
	wp_enqueue_style('restaurant_menu_css');
	wp_enqueue_script('restaurant_menu_js');
	
	$output = '<div id="menu">';
	
	$dish_types = get_taxonomies_by_parent();

	foreach($dish_types as $dish_type) {
		$output .= generate_section_html($dish_type);
	}
	return $output . '</div>';
}

function generate_section_html($dish_type) {
	$meta = get_term_meta($dish_type->term_taxonomy_id, 'tax_data', true);
	$out = '<div class="menu-section" id="' . $dish_type->slug . '">'.
		'<h2 class="menu-section-title">' . $dish_type->name  .
			'<span class="arrow open"></span>' .
		'</h2><div class="menu-section-container-container">'.
		'<div class="menu-section-container">';
	
	$out .= '<div class="top-menu-section-container">';
	
	$dishes = get_menu_items_by_tax_id($dish_type->term_taxonomy_id);
	foreach($dishes as $dish) {
		$out .= '<div class="menu-item">';
		$out .= get_top_menu_item_html($dish);
		
		$sub_items = get_sub_menu_items_by_menu_item_id($dish->ID);
		if ($sub_items) {
			$out .= '<div class="menu-item-extras">';
			
			foreach ($sub_items as $item) {
				$out .=  get_sub_menu_item_html($item);
			}
			
			$out .= '</div>'; //end of extras
		}
		
		$out .= '</div>'; //end of items
	}
	
	$out .= generate_section_image_html($meta['meta_image']);
	
	$out .= '</div>'; // end of section
	
	$sub_taxonomies = get_taxonomies_by_parent($dish_type->term_taxonomy_id);
	foreach($sub_taxonomies as $sub) {
		$out .= generate_sub_section_html($sub);
	}
	
	return $out . '</div></div></div>';
}

function generate_sub_section_html($dish_type) {
	$meta = get_term_meta($dish_type->term_taxonomy_id, 'tax_data', true);
	$out = '<div class="sub-menu-section">';
	
	if (!isset($meta['should_show']) || $meta['should_show'] !== 'false') {
		$out .= '<h3 class="sub-menu-section-title">' . $dish_type->name . '</h3>';
	}
	
	$out .= '<div style="position: relative; overflow: hidden;"><div class="sub-menu-section-container">';
	
	$dishes = get_menu_items_by_tax_id($dish_type->term_taxonomy_id);
	
	foreach($dishes as $dish) {
		$out .= '<div class="menu-item">';
		$out .= get_top_menu_item_html($dish);
		
		$sub_items = get_sub_menu_items_by_menu_item_id($dish->ID);
		if ($sub_items) {
			$out .= '<div class="menu-item-extras">';
			
			foreach ($sub_items as $item) {
				$out .=  get_sub_menu_item_html($item);
			}
			
			$out .= '</div>'; // end of extras
		}
		
		$out .= '</div>'; // end of items
	}
	
	$out .= generate_section_image_html($meta['meta_image']);

	return $out . '</div></div></div>';
}

function generate_section_image_html($imageURL) {
	return '<div class="section-image-container">' .
		'<div class="positioner">' .
			'<div class="section-image" style="background-image: url(' . $imageURL . ');"></div>' .
		'</div>' .
	'</div>';
}


function get_top_menu_item_html($item) {
	$meta = get_post_meta($item->ID, 'dish_data', true);
	$price = $meta['price'];
	$unit = $meta['unit'];
	$price_string = $price ? '<div class="menu-item-price">$' . $price . ' ' . $unit . '</div>' : '';
	
	$desc = $meta['description'];
	$desc_string = $desc ? '<div class="menu-item-desc">' .$desc . '</div>' : '';
	return '<div class="menu-item-name">' . $item->post_title . '</div>' . $price_string . $desc_string;
}

function get_sub_menu_item_html($item) {
	$meta = get_post_meta($item->ID, 'dish_data', true);
	$price = $meta['price'];
	$unit = $meta['unit'];
	$price_string = $price ? '<div class="item-extra-price">$' . $price . ' ' . $unit . '</div>' : '';
	return '<div class="menu-item-extra">' . '<div class="item-extra-desc">' . $item->post_title . '</div>' . $price_string . '</div>';
}

function get_taxonomies_by_parent($id = 0) {
	return get_terms(array(
		'taxonomy'			=>	'dish_types',
		'hide_empty'		=>	true,
		'parent'			=>	$id,
	));
}

function get_menu_items_by_tax_id($tax_id) {
	return get_posts(array(
		'offset'			=> 0,
		'posts_per_page'	=> -1,
		'post_type'			=> 'restaurant_menu_item',
		'post_status'		=> 'publish',
		'post_parent'    	=> 	0,
		'tax_query' => array(
			array(
				'taxonomy'			=>	'dish_types',
				'field'				=>	'term_taxonomy_id',
				'terms'				=>	$tax_id,
				'include_children'	=>	false,
			)
		),
	));
}

function get_sub_menu_items_by_menu_item_id($menu_item_id) {
	return get_posts(array(
		'offset'			=> 0,
		'posts_per_page'	=> -1,
		'post_type'			=> 'restaurant_menu_item',
		'post_status'		=> 'publish',
		'post_parent'    	=> 	$menu_item_id,
		'include_children'	=>	false,
	));
}

?>