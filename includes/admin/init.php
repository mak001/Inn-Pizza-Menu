<?php

function dropdown_restaurant_menu_admin_init() {
	include('create-metaboxes.php');
	include('menu-options.php');
	include('enqueue.php');
	
	add_action('add_meta_boxes', 'dropdown_restaurant_menu_create_metaboxes');
	
	add_action('dish_types_add_form_fields', 'add_dish_types_group_field');
	//add_action('dish_types_add_form_fields', 'dropdown_restaurant_menu_enqueue_image_meta');
	add_action('dish_types_edit_form_fields', 'add_dish_types_edit_group_field');
	//add_action('dish_types_edit_form_fields', 'dropdown_restaurant_menu_enqueue_image_meta');
	
	add_action('admin_enqueue_scripts', 'dropdown_restaurant_menu_admin_enqueue');
	add_action('admin_enqueue_scripts', 'dropdown_restaurant_menu_enqueue_image_meta');
}

?>