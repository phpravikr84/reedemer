<?php

class acf_field_fonticonpicker extends acf_field {

	// Vars
	var $settings, 		// Will hold info such as dir / path
		$defaults,		// Will hold default field options
		$json_content; 	// Hold the content of icons JSON file

	/**
	 *  __construct
	 *
	 *  @since	1.0.0
	 */
	function __construct() {
		
		$this->name = 'fonticonpicker';
		$this->label = __('Icon Picker', 'acf');
		$this->category = __("jQuery", 'acf');
		$this->defaults = array(
			'allow_null' 	=>	0
		);
		$this->l10n = array();

    	parent::__construct();

    	// Settings
		$this->settings = array(
			'dir' => get_template_directory_uri() . '/inc/includes/acf-fonticonpicker',
			'path' => get_template_directory() . '/inc/includes/acf-fonticonpicker',
			'icons'		=>	get_template_directory_uri() . '/inc/includes/acf-fonticonpicker/icons/style.css',
			'version' 	=> 	'1.0.0'
		);

		
		// Apply a filter so that you can load icon set from theme
		$this->settings = apply_filters( 'acf/acf_field_fonticonpicker/settings', $this->settings );
		
		// Enqueue icons style in the frontend
		add_action( 'wp_enqueue_scripts', array( $this, 'frontend_enqueue' ) );

		// Load icons list from the icons JSON file
		if ( is_admin() ){

			$json_file = trailingslashit($this->settings['dir']) . 'icons/selection.json';

			$json_content = wp_remote_fopen( $json_file );

			if(!$json_content) {
				return new WP_Error('reading_error', 'Error when reading file'); 
			}
			$this->json_content = json_decode( $json_content, true );
		}

	}
	
	/**
	 *  frontend_enqueue()
	 *
	 *  @since	1.0.0
	 */
	function frontend_enqueue() {
		// Register icons style
		wp_register_style( 'acf-fonticonpicker-icons', $this->settings['icons'] );
		wp_enqueue_style( 'acf-fonticonpicker-icons' );
	}


	/**
	 *  render_field()
	 *
	 *  @param	$field - An array holding all the field's data
	 *
	 *  @since	1.0.0
	 */
	function render_field( $field ) {
		
		if ( !isset( $this->json_content['icons'] ) ){
			_e('No icons found', 'acf');
			return;
		}

		// icons SELECT input
		echo '<select name="'. $field['name'] .'" id="'. $field['name'] .'" class="acf-iconpicker">';
		echo '<option value="">'. __('None', 'acf').'</option>';
		foreach ( $this->json_content['icons'] as $icon ) {

			$glyph_full = $this->json_content['prefix'] . $icon;

			echo '<option value="'. $glyph_full .'" ' . selected( $field['value'], $glyph_full, false ) . '>'. $glyph_full .'</option>';
		}
		echo '</select>';
		
	}


	/**
	 *  input_admin_enqueue_scripts()
	 *
	 *  @since	1.0.0
	 */
	function input_admin_enqueue_scripts() {
	
		// Scripts
		wp_register_script( 'acf-fonticonpicker', $this->settings['dir'] . '/js/jquery.fonticonpicker.min.js', array('jquery'), $this->settings['version'], true );
		wp_register_script( 'acf-fonticonpicker-input', $this->settings['dir'] . '/js/input.js', array('acf-fonticonpicker'), $this->settings['version'], true );
		wp_enqueue_script( 'acf-fonticonpicker-input' );
		
		// Styles
		wp_register_style( 'acf-fonticonpicker-style', $this->settings['dir'] . '/css/jquery.fonticonpicker.min.css', false, $this->settings['version'] );
		wp_register_style( 'acf-fonticonpicker-icons', $this->settings['icons'] );
		wp_enqueue_style( array( 'acf-fonticonpicker-style', 'acf-fonticonpicker-icons' ) );
		
	}

} // Class acf_field_fonticonpicker

// create field
new acf_field_fonticonpicker();