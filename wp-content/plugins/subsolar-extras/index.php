<?php

/*
Plugin Name: Subsolar Designs Extras
Plugin URI: http://www.subsolardesigns.com
Description: Adds Custom Post Types and Widgets for themes by Subsolar Designs.
Version: 1.3.1
Author: Subsolar Designs
Author URI: http://www.subsolardesigns.com
*/	

/**
 * Require post type file.
 */
require_once( trailingslashit( plugin_dir_path( __FILE__ ) ) . 'cpt.php' );

function ssd_register_extras(){
	
	( current_theme_supports('subsolar-theme') ) ? $subsolar_theme = true : $subsolar_theme = flase;
	
	/**
	 * Register Custom Post Types
	 */
	if( current_theme_supports('subsolar-deal') || !$subsolar_theme ){
		add_action( 'init', 'ssd_register_deal' );
		add_action( 'init', 'ssd_create_deal_taxonomies' );
	}
	
}
add_action('after_setup_theme', 'ssd_register_extras', 15);