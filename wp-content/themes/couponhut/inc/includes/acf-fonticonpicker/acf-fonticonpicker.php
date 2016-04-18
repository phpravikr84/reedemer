<?php
/*
Plugin Name: Advanced Custom Fields: FontIconPicker
Plugin URI: http://codeb.it/fonticonpicker
Description: A simple Font Icons Picker for ACF
Version: 1.0.0
Author: Alessandro Benoit
Author URI: http://codeb.it/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
class acf_field_fonticonpicker_plugin {

	/**
	 *  Construct
	 *
	 *  @since: 1.0.0
	 */
	function __construct() {

		// Include field type for ACF5
		add_action('acf/include_field_types', 'include_field_types');

	}

	function include_field_types_font_awesome( $version ) {

		include_once('acf-font-awesome-v5.php');

	}

	function include_field_types() {
		include_once('fonticonpicker-v5.php');
	}

} // Class acf_field_fonticonpicker_plugin

new acf_field_fonticonpicker_plugin();