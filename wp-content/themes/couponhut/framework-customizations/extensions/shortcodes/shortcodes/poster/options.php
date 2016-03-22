<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'title' => array( 
		'type' => 'text' ,
		'label' => esc_html__('Title', 'couponhut'),
		),
	'image' => array(
		'type'  => 'upload',
		'label' => __('Image', 'couponhut'),
		'images_only' => true,
	),
	'link'   => array(
		'label' => __( 'Link', 'couponhut' ),
		'desc'  => __( 'Where should the poster link to', 'couponhut' ),
		'type'  => 'text',
		'value' => '#'
	),
	'button_target' => array(
		'type'    => 'switch',
		'label'   => __( 'Open Link in New Window', 'couponhut' ),
		'desc'    => __( 'Select here if you want to open the linked page in a new window', 'couponhut' ),
		'right-choice' => array(
			'value' => '_blank',
			'label' => __('Yes', 'couponhut'),
		),
		'left-choice' => array(
			'value' => '_self',
			'label' => __('No', 'couponhut'),
		),
	),
);