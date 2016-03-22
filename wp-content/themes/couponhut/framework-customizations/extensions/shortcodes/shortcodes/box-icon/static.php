<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/box-icon');

wp_enqueue_style(
	'fw-shortcode-box-icon',
	$uri . '/static/css/styles.css'
);
