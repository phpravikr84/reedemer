<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'height' => array(
		'label'  => esc_html__( 'Height', 'couponhut' ),
		'type'   => 'slider',
		'value' => 100,
		'properties' => array(
			'min' => 0,
			'max' => 100,
			'sep' => 1,
			'grid_snap' => true
			)
	),
);