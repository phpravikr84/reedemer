<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }

Class SSD_Widget_Social extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__( 'Add social links to your site.', 'couponhut' ) );

		parent::__construct( false, __( '[CouponHut] Social', 'couponhut' ), $widget_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		echo '<div class="social-widget-wrapper">';

		if ( $title ) { echo $before_title . $title . $after_title; }
		?>
			<div class="share-buttons">

				<?php 
				unset($instance['title']);

				foreach ( $instance as $key => $value ) :
					if ( empty( $value ) ) {
						continue;
					}
					?>
						<a href="<?php echo esc_attr( $value ); ?>" class="<?php echo sanitize_title($key); ?>" target="_blank">
							<i class="icon-<?php echo $key ?>"></i>
						</a>
				<?php endforeach; ?>
			</div><!-- end share-buttons -->
		<?php
		echo '</div>';

		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = wp_parse_args( (array) $new_instance, $old_instance );

		return $instance;
	}

	function form( $instance ) {

		$defaults = array(
			'title' => esc_html__('Follow Us', 'couponhut')
		);

		$titles = array(
			'Facebook'     => esc_html__( 'Facebook URL', 'couponhut' ),
			'Google-Plus'  => esc_html__( 'Google URL', 'couponhut' ),
			'Twitter'      => esc_html__( 'Twitter URL', 'couponhut' ),
			'Vimeo'        => esc_html__( 'Vimeo URL', 'couponhut' ),
			'Linkedin'     => esc_html__( 'Linkedin URL', 'couponhut' ),
			'Instagram'    => esc_html__( 'Instagram URL', 'couponhut' ),
			'Pinterest'    => esc_html__( 'Pinterest URL', 'couponhut' ),
			'Youtube'    => esc_html__( 'Youtube URL', 'couponhut' )
		);

		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			
		</p>
		<?php
		foreach ( $titles as $key => $value ) {
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo $value; ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id($key)); ?>" name="<?php echo esc_attr($this->get_field_name($key)); ?>" type="text" value="<?php echo esc_attr($instance[$key]); ?>" />
				
			</p>
		<?php
		}
	}
}
