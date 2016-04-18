<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

$options = array(
	'id'    => array( 'type' => 'unique' ),
	'image'  => array(
		'label' => esc_html__( 'Background Image', 'couponhut' ),
		'type'  => 'upload',
		'images_only' => true
	),
	'video_mp4' => array(
		'type'  => 'text',
		'label' => esc_html__( 'MP4 Video URL', 'couponhut')
	),
	'video_webm' => array(
		'type'  => 'text',
		'label' => esc_html__( 'WEBM Video URL', 'couponhut'),
		'desc' => esc_html__( 'For browsers not supporting MP4 (Not required)', 'couponhut')
	),
	'video_ogg' => array(
		'type'  => 'text',
		'label' => esc_html__( 'OGG Video URL', 'couponhut'),
		'desc' => esc_html__( 'Fallback to OGG if there is no MP4 or WEBM', 'couponhut')
	),
	'title'  => array(
		'label' => esc_html__( 'Title', 'couponhut' ),
		'type'  => 'text',
		'value' => '',
		'images_only' => true
	),
	'subtitle'  => array(
		'label' => esc_html__( 'Subtitle', 'couponhut' ),
		'type'  => 'text',
		'value' => '',
		'images_only' => true
	),
	'placeholder'  => array(
		'label' => esc_html__( 'Type Shop Name Placeholder', 'couponhut' ),
		'type'  => 'text',
		'value' => 'Type Shop Name'
	),
);