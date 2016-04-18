<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$cfg = array();

$cfg['page_builder'] = array(
	'title'       => esc_html__( 'Tabs', 'couponhut' ),
	'description' => esc_html__( 'Add some Tabs', 'couponhut' ),
	'tab'         => esc_html__( 'Content Elements', 'couponhut' ),
);