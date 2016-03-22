<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/accordion');

wp_enqueue_script(
	'fw-shortcode-accordion',
	$uri . '/static/js/scripts.js',
	array('jquery-ui-accordion'),
	false,
	true
);
wp_enqueue_style(
	'fw-shortcode-accordion',
	$uri . '/static/css/styles.css'
);
