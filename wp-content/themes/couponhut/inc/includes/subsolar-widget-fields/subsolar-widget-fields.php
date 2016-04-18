<?php
if( ! defined('SSD_WIDGET_FIELDS_DIR') ) { define('SSD_WIDGET_FIELDS_DIR', get_template_directory_uri() . '/inc/includes/subsolar-widget-fields'); }
/**
*  Subsolar Designs helper functions for creating native widget fields
*/

class SSD_Widget_Fields {

	static function init(){
		if( !is_admin() ){
			return;
		}
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_enqueue_scripts') );
	}

	static function admin_enqueue_scripts($hook){
		if( 'widgets.php' != $hook ){
	        return;
		}

		wp_enqueue_media();

		wp_enqueue_script(
			'widget-selectize-js',
			SSD_WIDGET_FIELDS_DIR . '/assets/js/selectize.min.js',
			array( 'jquery' ),
			'1.0',
			true
			);

		wp_enqueue_script(
			'ssdwf-js',
			SSD_WIDGET_FIELDS_DIR . '/assets/js/scripts.js',
			array( 'jquery' ),
			'1.0',
			true
			);

		wp_enqueue_style(
			'widget-selectize-css',
			SSD_WIDGET_FIELDS_DIR . '/assets/css/selectize.custom.css',
			array(),
			'1.0'
			);
	}

	static function field($args = array()){

		switch ($args['type']) {
			case 'image':

				if ( $args['value'] ) {
					$image_array = wp_get_attachment_image_src($args['value']);
					$image_url = $image_array[0];
				} else {
					$image_url ='';
				}
				?>
				<label for="<?php echo esc_attr($args['name']); ?>"><?php echo esc_attr($args['label']); ?></label>
				<input name="" id="<?php echo esc_attr($args['id']); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url($image_url ); ?>" disabled/>
				<input class="button ssd-upload-image-button" type="button" value="Upload Image" data-name="<?php echo esc_attr($args['name']); ?>" />
				<input type="hidden" name="<?php echo esc_attr($args['name']); ?>" value="<?php echo esc_attr( $args['value'] ); ?>">
				<?php
				break;
			case 'multi-select':
			?>	
				<label for="<?php echo esc_attr($args['name']); ?>"><?php echo esc_attr($args['label']); ?></label>
				<select id="<?php echo esc_attr($args['id']); ?>" class="ssdwf-multi-select" placeholder="" name="<?php echo esc_attr($args['name']); ?>" data-name="<?php echo esc_attr($args['name']); ?>">
					<option value=""><?php esc_html_e('Select...', 'couponhut') ?></option>
				<?php foreach ($args['choices'] as $key => $value) : ?>
					<option <?php echo ( $args['value'] == $key ) ? 'selected' : ''; ?> value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
				<?php endforeach; ?>
				</select>
				<?php
				break;
			
			default:
				# code...
				break;
		}

	}
}

add_action( 'widgets_init', array( 'SSD_Widget_Fields', 'init' ) );