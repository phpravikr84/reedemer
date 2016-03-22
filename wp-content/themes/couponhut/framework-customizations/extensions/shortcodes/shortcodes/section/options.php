<?php if (!defined('FW')) {
	die('Forbidden');
}

$options = array(
	'is_fullwidth' => array(
		'label'        => __('Full Width', 'couponhut'),
		'type'         => 'switch',
	),
	'margin_bottom' => array(
		'label'  => esc_html__( 'Bottom Spacing', 'couponhut' ),
		'type'   => 'slider',
		'value' => 100,
		'properties' => array(
			'min' => 0,
			'max' => 100,
			'sep' => 1,
			'grid_snap' => true
			)
	),
	'background_color' => array(
		'label' => __('Background Color', 'couponhut'),
		'desc'  => __('Please select the background color', 'couponhut'),
		'type'  => 'color-picker',
	),
	'background_image' => array(
		'label'   => __('Background Image', 'couponhut'),
		'desc'    => __('Please select the background image', 'couponhut'),
		'type'    => 'background-image',
		'choices' => array(//	in future may will set predefined images
		)
	),
	'video' => array(
		'label' => __('Background Video', 'couponhut'),
		'desc'  => __('Insert Video URL to embed this video', 'couponhut'),
		'type'  => 'text',
	)
);
