<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(

	'icon_box' => array(
	    'type'  => 'addable-box',
	    'value' => array(
	        array(
	            'icon' => '',
	            'icon_content' => '',
	        )
	    ),
	    'label' => esc_html__('Icon Box', 'couponhut'),
	    'box-options' => array(
	    	'icon' => array(
	    		'type'  => 'icon-select',
	    		'value' => '',
	    		'label' => esc_html__('Icon', 'couponhut'),
	    		),
	        'icon_content' => array( 
	        	'type' => 'textarea' ,
	        	'label' => esc_html__('Icon Content', 'couponhut'),
	        	),
	    ),
	    'template' => '{{- icon_content }}', // box title
	    'limit' => 0, // limit the number of boxes that can be added
	    'add-button-text' => esc_html__('Add', 'couponhut'),
	    'sortable' => true,
	)
);