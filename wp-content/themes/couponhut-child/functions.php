<?php
add_action( 'wp_enqueue_scripts', 'ssd_theme_enqueue_styles' );
function ssd_theme_enqueue_styles() {

	wp_enqueue_style( 'child-styles', get_stylesheet_directory_uri() . '/style.css', array('ssd_owl-carousel-css', 'ssd_font-awesome-css', 'ssd_icomoon-css', 'ssd_videojs-css', 'ssd_bigvideo-css', 'ssd_master-css', 'ssd_fw-theme-ie'), '1.0');

}