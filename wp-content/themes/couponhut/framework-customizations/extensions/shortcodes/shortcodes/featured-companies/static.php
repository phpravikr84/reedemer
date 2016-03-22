<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/featured-companies');

wp_enqueue_script(
	'fw-shortcode-featured-companies',
	$uri . '/static/js/scripts.js',
	array('jquery', 'ssd_owl-carousel-js'),
	false,
	true
);
wp_enqueue_style(
	'fw-shortcode-featured-companies',
	$uri . '/static/css/styles.css'
);
