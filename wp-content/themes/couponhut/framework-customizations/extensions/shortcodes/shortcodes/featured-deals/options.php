<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'id'    => array( 'type' => 'unique' ),
	'featured_posts' => array(
		'label'  => esc_html__( 'Featured Posts', 'couponhut' ),
		'type'   => 'addable-option',
		'option' => array(
			'type'  => 'multi-select',
			'population' => 'array',
			'choices' => fw_ssd_get_post_names('deal'),
			'limit' => 1,
			),
		'desc'   => esc_html__( 'Add Deals that will appear in the carousel.', 'couponhut' ),
	),
);