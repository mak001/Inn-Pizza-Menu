<?php

function dropdown_restaurant_menu_init() {
	
	dropdown_restaurant_menu_taxonomy();
	add_action('restrict_manage_posts','restrict_listings_by_dish_type');
	add_filter('parse_query','convert_dish_type_id_to_taxonomy_term_in_query');
	
	$labels = array(
		'name'               => __( 'Menu Items', 'dropdown_restaurant_menu' ),
		'singular_name'      => __( 'Menu Item', 'dropdown_restaurant_menu' ),
		'menu_name'          => __( 'Menu Items', 'dropdown_restaurant_menu' ),
		'name_admin_bar'     => __( 'Menu Item', 'dropdown_restaurant_menu' ),
		'add_new'            => __( 'Add New', 'dropdown_restaurant_menu' ),
		'add_new_item'       => __( 'Add New Item', 'dropdown_restaurant_menu' ),
		'new_item'           => __( 'New Item', 'dropdown_restaurant_menu' ),
		'edit_item'          => __( 'Edit Item', 'dropdown_restaurant_menu' ),
		'view_item'          => __( 'View Item', 'dropdown_restaurant_menu' ),
		'all_items'          => __( 'All Items', 'dropdown_restaurant_menu' ),
		'search_items'       => __( 'Search Items', 'dropdown_restaurant_menu' ),
		'parent_item_colon'  => __( 'Parent Items:', 'dropdown_restaurant_menu' ),
		'not_found'          => __( 'No items found.', 'dropdown_restaurant_menu' ),
		'not_found_in_trash' => __( 'No items found in Trash.', 'dropdown_restaurant_menu' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'A custom post for restaurant menu items.', 'dropdown_restaurant_menu' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'menu_item' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 20,
		'supports'           => array('title', 'page-attributes'),
		'taxonomies'		 => array('dish_types')
	);

	register_post_type( 'restaurant_menu_item', $args );
}

function dropdown_restaurant_menu_taxonomy() {
	
	$labels = array(
		'name'              => _x( 'Dish Types', 'taxonomy general name', 'dropdown_restaurant_menu' ),
		'singular_name'     => _x( 'Dish Type', 'taxonomy singular name', 'dropdown_restaurant_menu' ),
		'search_items'      => __( 'Search Dish Types', 'dropdown_restaurant_menu' ),
		'all_items'         => __( 'All Dish Types', 'dropdown_restaurant_menu' ),
		'parent_item'       => __( 'Parent Dish Type', 'dropdown_restaurant_menu' ),
		'parent_item_colon' => __( 'Parent Dish Type:', 'dropdown_restaurant_menu' ),
		'edit_item'         => __( 'Edit Dish Type', 'dropdown_restaurant_menu' ),
		'update_item'       => __( 'Update Dish Type', 'dropdown_restaurant_menu' ),
		'add_new_item'      => __( 'Add New Dish Type', 'dropdown_restaurant_menu' ),
		'new_item_name'     => __( 'New Dish Type', 'dropdown_restaurant_menu' ),
		'menu_name'         => __( 'Dish Type', 'dropdown_restaurant_menu' ),
		'not_found'			=> __( 'No Dish Types found', 'dropdown_restaurant_menu' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'dish_type' ),
	);
	
	register_taxonomy('dish_types', array('restaurant_menu_item'), $args);
}

function restrict_listings_by_dish_type() {
    global $typenow;
    global $wp_query;
	
    if ($typenow=='restaurant_menu_item') {
        $taxonomy = 'dish_types';
        $dish_types_taxonomy = get_taxonomy($taxonomy);
		$selected = isset($wp_query->query['dish_types']) ? $wp_query->query['dish_types'] : 0;
        return wp_dropdown_categories(array(
            'show_option_all' =>  __("Show All {$dish_types_taxonomy->label}"),
            'taxonomy'        =>  $taxonomy,
            'name'            =>  'dish_types',
            'orderby'         =>  'name',
			'selected'		  =>  $selected,
            'hierarchical'    =>  true,
            'depth'           =>  3,
            'show_count'      =>  true, // Show # listings in parens
            'hide_empty'      =>  true, // Don't show businesses w/o listings
        ));
    }
}

function convert_dish_type_id_to_taxonomy_term_in_query($query) {
	global $pagenow;
    global $typenow;
    if ($pagenow == 'edit.php') {
        $filters = get_object_taxonomies($typenow);
        foreach ($filters as $tax_slug) {
            $var = &$query->query_vars[$tax_slug];
            if (isset($var) && $var != 0) {
                $term = get_term_by('id',$var,$tax_slug);
                $var = $term->slug;
            }
        }
    }
    return $query;
}

function dropdown_restaurant_menu_register_shortcode_assets() {
	//wp_register_style('restaurant_menu_specials_css', plugins_url('/assets/restaurant_menu_specials_style.css', DROPDOWN_RESTAURANT_MENU_PLUGIN_URL));
	wp_register_style('restaurant_menu_css', plugins_url('/assets/restaurant_menu_style.css', DROPDOWN_RESTAURANT_MENU_PLUGIN_URL));
	wp_register_script('restaurant_menu_js', plugins_url('/assets/restaurant_menu_script.js', DROPDOWN_RESTAURANT_MENU_PLUGIN_URL), array('jquery-core'));
}

?>