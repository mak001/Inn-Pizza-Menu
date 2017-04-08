<?php

/*
Plugin Name: Dropdown Restaurant Menu
Plugin URI: 
Description: A widget for a dropdown restaurant menu
Version: 0.001
Author: Matthew Koerber
Author URI: http://matthewkoerber.com/
License: none
*/

//setup
define('DROPDOWN_RESTAURANT_MENU_PLUGIN_URL', __FILE__);

// includes
include('includes/activate.php');
include('includes/init.php');
include('includes/admin/init.php');
include('includes/shortcodes/generator.php');
//include('includes/shortcodes/specials.php');
include('process/save-post.php');
include('process/save-taxonomy.php');

// hooks
register_activation_hook(__FILE__, 'dropdown_restaurant_menu_activate_plugin');
add_action('init', 'dropdown_restaurant_menu_init');
add_action('admin_init', 'dropdown_restaurant_menu_admin_init');
add_action('save_post_restaurant_menu_item', 'dropdown_restaurant_menu_save_post_admin', 10, 3);
add_action('edited_dish_types', 'dropdown_restaurant_menu_save_taxonomy_admin', 10, 2);  
add_action('create_dish_types', 'dropdown_restaurant_menu_save_taxonomy_admin', 10, 2);

add_action('wp_enqueue_scripts', 'dropdown_restaurant_menu_register_shortcode_assets');

add_filter( "radio-buttons-for-taxonomies-no-term-dish_types", "__return_FALSE" );

// shortcodes
add_shortcode('menu_generator', 'dropdown_restaurant_menu_menu_generator_shortcode');
//add_shortcode('menu_specials', 'dropdown_restaurant_specials_shortcode');

?>