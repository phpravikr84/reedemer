<?php

$cfg = array();

/**
 * Config example
 */

// $cfg['sidebar_positions'] = array(
// 	'left' => array(
// 		'icon_url' => 'left.png',
// 		'sidebars_number' => 1
// 	),
// 	'right' => array(
// 		'icon_url' => 'right.png',
// 		'sidebars_number' => 1
// 	)
// );

$cfg['dynamic_sidebar_args'] = array(
	'before_widget' => '<aside id="%1$s" class="widget %2$s">',
	'after_widget'  => '</aside>',
	'before_title'  => '<h4 class="widget-title">',
	'after_title'   => '</h4>',
	);


/**
 * Render sidebar metabox in post types.
 */
$cfg['show_in_post_types'] = false;
