<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

/**
 * Theme Includes
 */

require_once get_template_directory() .'/inc/init.php';


/**
 * TGM Plugin Activation
 */
{
	require_once get_template_directory() . '/TGM-Plugin-Activation/class-tgm-plugin-activation.php';

	/** @internal */
	function _action_theme_register_required_plugins() {
		tgmpa( array(
			array(
				'name'      => 'Unyson',
				'slug'      => 'unyson',
				'required'  => true,
			),
			array(
				'name'     				=> 'Envato Wordpress Toolkit',
				'slug'     				=> 'envato-wordpress-toolkit',
				'source'   				=> get_template_directory() . '/TGM-Plugin-Activation/plugins/envato-wordpress-toolkit.zip',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> 'Subsolar Designs Extras',
				'slug'     				=> 'subsolar-extras',
				'source'   				=> get_template_directory() . '/TGM-Plugin-Activation/plugins/subsolar-extras.zip',
				'required' 				=> true,
				'version' 				=> '1.2',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> 'Contact Form 7',
				'slug'     				=> 'contact-form-7',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			),
			array(
				'name'     				=> 'Ultimate Member',
				'slug'     				=> 'ultimate-member',
				'required' 				=> false,
				'version' 				=> '',
				'force_activation' 		=> false,
				'force_deactivation' 	=> false,
				'external_url' 			=> ''
			)
		) );

	}
	add_action( 'tgmpa_register', '_action_theme_register_required_plugins' );
}