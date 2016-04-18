<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'title' => array(
		'type'  => 'text',
		'value' => 'Latest Deals',
		'label' => esc_html__('Title', 'couponhut'),
		),

	'deals_count' => array(
		'label'  => esc_html__( 'Number of deals to display', 'couponhut' ),
		'type'   => 'slider',
		'value' => 8,
		'properties' => array(
			'min' => 1,
			'max' => 50,
			'sep' => 1,
			'grid_snap' => true
			)
	),

	'columns_count' => array(
		'label'  => esc_html__( 'Number of columns', 'couponhut' ),
		'type'   => 'slider',
		'value' => 4,
		'properties' => array(
			'min' => 1,
			'max' => 4,
			'sep' => 1,
			'grid_snap' => true
			)
	),

	'type' => array(
		'type'  => 'select',
		'value' => 'both',
		'label' => esc_html__('Deal types to display', 'couponhut'),
		'choices' => array(
			'both' => esc_html__('Both', 'couponhut'),
			'discounts' => esc_html__('Discounts', 'couponhut'),
			'coupons' => esc_html__('Coupons', 'couponhut'),
        ),
	)

);