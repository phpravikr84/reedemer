<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'tabs' => array(
		'type'          => 'addable-popup',
		'label'         => esc_html__( 'Tabs', 'couponhut' ),
		'popup-title'   => esc_html__( 'Add/Edit Tab', 'couponhut' ),
		'desc'          => esc_html__( 'Create your tabs', 'couponhut' ),
		'template'      => '{{=tab_title}}',
		'popup-options' => array(
			'tab_title' => array(
				'type'  => 'text',
				'label' => esc_html__('Title', 'couponhut')
			),
			'tab_content' => array(
				'type'  => 'textarea',
				'label' => esc_html__('Content', 'couponhut')
			)
		),
	)
);