<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Register menus
 */

register_nav_menus( array(
	'main-navigation'   => esc_html__( 'Top navigation menu', 'couponhut' ),
) );