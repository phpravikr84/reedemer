<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Include static files: javascript and css
 */

if ( is_admin() ) {

	return;
}

/**
 * Enqueue scripts and styles for the front end.
 */

// Owl Carousel CSS
wp_enqueue_style(
	'ssd_owl-carousel-css',
	get_template_directory_uri() . '/assets/css/owl.carousel.css',
	array(),
	'1.0'
);

// Font Awesome CSS
wp_enqueue_style(
	'ssd_font-awesome-css',
	get_template_directory_uri() . '/assets/css/font-awesome.min.css',
	array(),
	'1.0'
);

// Iconsmind CSS
wp_enqueue_style(
	'ssd_icomoon-css',
	get_template_directory_uri() . '/assets/css/icomoon.css',
	array(),
	'1.0'
);

// Video JS Styles
wp_enqueue_style(
	'ssd_videojs-css',
	get_template_directory_uri() . '/assets/css/video-js.min.css',
	array(),
	'1.0'
);

// BigVideo Styles
wp_enqueue_style(
	'ssd_bigvideo-css',
	get_template_directory_uri() . '/assets/css/bigvideo.css',
	array(),
	'1.0'
);

// Theme Styles
wp_enqueue_style(
	'ssd_master-css',
	get_template_directory_uri() . '/assets/css/master.css',
	array(),
	'1.0'
);


// Load the Internet Explorer specific stylesheet.
wp_enqueue_style(
	'ssd_fw-theme-ie',
	get_template_directory_uri() . '/assets/css/ie.css',
	array( 'fw-theme-style', 'genericons' ),
	'1.0'
);
wp_style_add_data( 'ssd_fw-theme-ie', 'conditional', 'lt IE 9' );


// WP jQuery UI
wp_enqueue_script(
	'jquery-ui-core'
);
wp_enqueue_script(
	'jquery-ui-slider'
);

// Bootstrap JS
wp_enqueue_script(
	'ssd_bootstrap-js',
	get_template_directory_uri() . '/assets/js/bootstrap.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Smooth Scroll JS
wp_enqueue_script(
	'ssd_smoothscroll-js',
	get_template_directory_uri() . '/assets/js/SmoothScroll.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Owl Carousel JS
wp_enqueue_script(
	'ssd_owl-carousel-js',
	get_template_directory_uri() . '/assets/js/owl.carousel.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// WP Comment Reply
if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}

// ImagesLoaded Script
wp_enqueue_script(
	'ssd_imagesloaded-js',
	get_template_directory_uri() . '/assets/js/imagesloaded.pkgd.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Video Script
wp_enqueue_script(
	'ssd_video-js',
	get_template_directory_uri() . '/assets/js/video.js',
	array( 'jquery' ),
	'1.0',
	true
);

// JSCountdown Script
wp_enqueue_script(
	'ssd_countdown-js',
	get_template_directory_uri() . '/assets/js/jquery.countdown.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Hover Intent Script
wp_enqueue_script(
	'ssd_hoverintent-js',
	get_template_directory_uri() . '/assets/js/hoverIntent.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Superfish Script
wp_enqueue_script(
	'ssd_superfish-js',
	get_template_directory_uri() . '/assets/js/superfish.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// Isotope Script
wp_enqueue_script(
	'ssd_isotope-js',
	get_template_directory_uri() . '/assets/js/isotope.pkgd.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// SlickNav Script
wp_enqueue_script(
	'ssd_slicknav-js',
	get_template_directory_uri() . '/assets/js/jquery.slicknav.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// ClipboardJS Script
wp_enqueue_script(
	'ssd_clipboard-js',
	get_template_directory_uri() . '/assets/js/clipboard.min.js',
	array( 'jquery' ),
	'1.0',
	true
);

// BigVideo Script
wp_enqueue_script(
	'ssd_bigvideo-js',
	get_template_directory_uri() . '/assets/js/bigvideo.js',
	array( 'jquery', 'jquery-ui-core', 'jquery-ui-slider', 'ssd_imagesloaded-js', 'ssd_video-js' ),
	'1.0',
	true
);

// Google Maps

if ( is_page_template( 'template-contact.php' ) ) {
	wp_enqueue_script(
		'ssd_gmapsapi', 
		'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;sensor=false',
		'jquery',
		'1.0',
		false
		);

	wp_enqueue_script(
		'ssd_google-map-js',
		get_template_directory_uri() . '/assets/js/google-map.js',
		'jquery',
		'1.0',
		false
		);
}


// Custom scripts
wp_enqueue_script(
	'ssd_fw-theme-script',
	get_template_directory_uri() . '/assets/js/scripts.js',
	array( 'jquery' ),
	'1.0',
	true
);

wp_localize_script( 'ssd_fw-theme-script', 'couponhut', array(
		'ajaxurl' => admin_url( 'admin-ajax.php' ),
		'expired' => esc_html__('Expired!', 'couponhut'),
		'day' => esc_html__('day', 'couponhut'),
		'days' => esc_html__('days', 'couponhut'),
		'hour' => esc_html__('hour', 'couponhut'),
		'hours' => esc_html__('hours', 'couponhut'),
		'minute' => esc_html__('minute', 'couponhut'),
		'minutes' => esc_html__('minutes', 'couponhut'),
		'loading_deals' => esc_html__('Loading deals...', 'couponhut'),
		'no_deals' => esc_html__('No deals found.', 'couponhut'),
		'nonce' => wp_create_nonce('ajax-nonce')
		));