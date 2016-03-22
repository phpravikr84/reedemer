<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/tabs');

wp_enqueue_script(
	'fw-shortcode-tabs',
	$uri . '/static/js/scripts.js',
	array('jquery-ui-tabs'),
	false,
	true
);
wp_enqueue_style(
	'fw-shortcode-tabs',
	$uri . '/static/css/styles.css'
);
