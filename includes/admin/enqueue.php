<?php

function dropdown_restaurant_menu_admin_enqueue() {
	wp_register_style('dropdown_restaurant_menu_admin_css', plugins_url('/assets/admin_style.css', DROPDOWN_RESTAURANT_MENU_PLUGIN_URL));
	wp_enqueue_style('dropdown_restaurant_menu_admin_css');
}

/**
 * Loads the image management javascript
 * From: http://themefoundation.com/wordpress-meta-boxes-guide/
 */
function dropdown_restaurant_menu_enqueue_image_meta() {
    global $typenow;
    if( $typenow == 'restaurant_menu_item' ) {
        wp_enqueue_media();
        // Registers and enqueues the required javascript.
        wp_register_script( 'meta_box_image_script', plugins_url('/assets/image-meta.js', DROPDOWN_RESTAURANT_MENU_PLUGIN_URL));
        wp_localize_script( 'meta_box_image_script', 'meta_image',
            array(
                'title' => __( 'Choose or Upload an Image', 'dropdown_restaurant_menu' ),
                'button' => __( 'Use this image', 'dropdown_restaurant_menu' ),
            )
        );
        wp_enqueue_script('meta_box_image_script');
    }
}

?>