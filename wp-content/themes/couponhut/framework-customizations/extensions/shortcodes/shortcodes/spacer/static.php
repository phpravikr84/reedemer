<?php if (!defined('FW')) die('Forbidden');

$uri = fw_get_template_customizations_directory_uri('/extensions/shortcodes/shortcodes/spacer');

wp_enqueue_style(
	'fw-shortcode-spacer',
	$uri . '/static/css/styles.css'
);
