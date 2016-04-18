<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}


$options = array(
	'title' => array(
		'type'  => 'text',
		'value' => 'Featured Companies',
		'label' => esc_html__('Title', 'couponhut'),
		),
	'text_content' => array(
		'type'  => 'wp-editor',
		'value' => '',
		'label' => esc_html__('Content', 'couponhut'),
		'reinit' => true,
		),
	'featured_companies' => array(
		'label'  => esc_html__( 'Featured Companies', 'couponhut' ),
		'type'   => 'addable-option',
		'option' => array(
			'type'  => 'multi-select',
			'population' => 'array',
			'choices' => fw_ssd_get_term_names('deal_company'),
			'limit' => 1,
			),
		'desc'   => esc_html__( 'Add Companies that will appear in the list.', 'couponhut' ),
	),
	'show_image' => array(
		'type'  => 'multi-picker',
		'label' => false,
		'desc'  => false,
		'value' => array(
			'block_image' => 'yes',
		),
		'picker' => array(
			'block_image' => array(
				'type'  => 'switch',
				'value' => 'hello',
				'label' => esc_html__('Show Image', 'couponhut'),
				'left-choice' => array(
					'value' => 'yes' ,
					'label' => esc_html__('Yes', 'couponhut'),
					),
				'right-choice' => array(
					'value' => 'no',
					'label' => esc_html__('No', 'couponhut'),
					),
				),
		),
		'choices' => array(
			'yes' => array(
				'block_image' => array(
					'label'  => esc_html__( 'Image', 'couponhut' ),
					'type'   => 'upload',
					'images_only' => true,
					'desc'   => esc_html__( 'Upload background image for the title block.', 'couponhut' ),
					),
		    )
		),
		'show_borders' => false,
	)
);