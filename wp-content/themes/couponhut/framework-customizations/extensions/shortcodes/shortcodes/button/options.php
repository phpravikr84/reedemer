<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'label'  => array(
		'label' => esc_html__( 'Button Label', 'couponhut' ),
		'desc'  => esc_html__( 'This is the text that appears on your button', 'couponhut' ),
		'type'  => 'text',
		'value' => esc_html__( 'Button', 'couponhut' ),
	),
	'link'   => array(
		'label' => esc_html__( 'Button Link', 'couponhut' ),
		'desc'  => esc_html__( 'Where should your button link to', 'couponhut' ),
		'type'  => 'text',
		'value' => '#'
	),
	'target' => array(
		'type'  => 'switch',
		'label'   => esc_html__( 'Open Link in New Window', 'couponhut' ),
		'desc'    => esc_html__( 'Select here if you want to open the linked page in a new window', 'couponhut' ),
		'right-choice' => array(
			'value' => '_blank',
			'label' => esc_html__('Yes', 'couponhut'),
		),
		'left-choice' => array(
			'value' => '_self',
			'label' => esc_html__('No', 'couponhut'),
		),
	),
	'color' => array(
		'type'  => 'select',
		'value' => 'default',
		'label' => esc_html__('Color', 'couponhut'),
		'choices' => array(
			false => esc_html__('None', 'couponhut'),
			'default' => esc_html__('Default', 'couponhut'),
			'success' => esc_html__('Success', 'couponhut'),
			'info' => esc_html__('Info', 'couponhut'),
			'danger' => esc_html__('Danger', 'couponhut'),
			'warning' => esc_html__('Warning', 'couponhut'),
		)
    )
);