<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'hide_categories' => array(
		'label'  => esc_html__( 'Hide Categories', 'couponhut' ),
		'type'   => 'addable-option',
		'option' => array(
			'type'  => 'select',
			'population' => 'array',
			'choices' => fw_ssd_get_term_names('deal_category')
			),
		'desc'   => esc_html__('Selected categories will not be displayed in the categories list.', 'couponhut')
	),
	'show_parents_only' => array(
		'type'  => 'switch',
		'value' => false,
		'label' => esc_html__('Show Parent Categories Only', 'couponhut'),
		'left-choice' => array(
			'value' => false,
			'label' => esc_html__('No', 'couponhut'),
		),
		'right-choice' => array(
			'value' => true,
			'label' => esc_html__('Yes', 'couponhut'),
		),
	)
);