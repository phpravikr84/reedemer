<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/poster');

wp_enqueue_style(
	'fw-shortcode-poster',
	$uri . '/static/css/styles.css'
);
