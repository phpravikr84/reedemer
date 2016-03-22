<?php 
/**
* ----------------------------------------------------------------------------------------
*    Mailchimp Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Mailchimp extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('Subscription form with Mailchimp integration.', 'couponhut') );
		parent::__construct( 'ssd_mailchimp', esc_html__('[CouponHut] Mailchimp', 'couponhut'), $widget_ops );
	}

	
	public function widget( $args, $instance ) {

		wp_enqueue_script( 'ssd_mailchimp-widget', get_template_directory_uri() . '/inc/widgets/mailchimp/assets/js/scripts.js', 'jquery', '1.0', 1.0, true );

		wp_localize_script( 'ssd_mailchimp-widget', 'subsolarMailchimp', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'subs_email_empty' => esc_html__('You have not entered an email address.', 'couponhut'),
			'subs_email_error' => esc_html__('You have entered an invalid email address.', 'couponhut'),
			'subs_email_add' => esc_html__('Adding your email address...', 'couponhut')
			));

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		echo '<div class="mailchimp-widget-wrapper">';
		
		if ( $title ) { echo $before_title . $title . $after_title; }

		?>

			<div class="mailchimp-widget-sub-text"><?php echo wp_kses_post($instance['sub_text']); ?></div>
			<form role="form" method="post" id="mailchimp-widget-subscribe">
				<fieldset>
					<input type="email" id="email" name="email" placeholder="<?php esc_attr_e('Your e-mail address', 'couponhut'); ?>" value="">
					<input id="signup-button" type="submit" value="<?php echo esc_attr($instance['button_text']); ?>" />
				</fieldset>
			</form>
			<div class="mailchimp-widget-message"></div>

		<?php
		echo '</div><!-- end mailchimp-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['sub_text'] = strip_tags($new_instance['sub_text']);
		$instance['button_text'] = strip_tags($new_instance['button_text']);

		return $instance;

	}

	public function form( $instance ) {

		$defaults = array(
			'title' => esc_html__('Newsletter', 'couponhut'),
			'sub_text' => esc_html__("Make sure you don't miss anything!", 'couponhut'),
			'button_text' => esc_html__('Subscribe', 'couponhut')
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<!-- API Key check -->

		<p>
			<?php fw_ssd_api_key_check('mailchimp'); ?>
		</p>
		
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('button_text')); ?>"><?php esc_html_e('Button Text', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($instance['button_text']); ?>" />
			
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('sub_text')) ?>"><?php esc_html_e('Subscription Text', 'couponhut') ?></label>
			<textarea cols="45" rows="4" id="<?php echo esc_attr($this->get_field_id('sub_text')) ?>" name="<?php echo esc_attr($this->get_field_name('sub_text')) ?>" class="widefat"><?php echo esc_attr($instance['sub_text']); ?></textarea>
		</p>

	<?php
	}

}
?>