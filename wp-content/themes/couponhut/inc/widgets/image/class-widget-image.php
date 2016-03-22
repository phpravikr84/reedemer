<?php 
/**
* ----------------------------------------------------------------------------------------
*    Deal Companies Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Image extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('This widget adds an image your site.','couponhut') );
		parent::__construct( 'image', esc_html__('[CouponHut] Image', 'couponhut'), $widget_ops );
	}

	public function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		echo '<div class="image-widget-wrapper widget-list">';
		
		if ( $title ) { echo $before_title . $title . $after_title; }

		if ( $instance['image'] ) :?>
			<?php
			echo wp_get_attachment_image( $instance['image'], 'ssd_widget-bgimage' )
			?>
		<?php endif;

		echo '</div><!-- end image-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['image'] = strip_tags($new_instance['image']);

		return $instance;
	}

	public function form( $instance ) {
		
		$defaults = array(
			'title' => esc_html__('Image', 'couponhut'),
			'image' => '',
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<?php if ( class_exists(SSD_Widget_Fields) ) {
				$args = array(
					'id' =>  $this->get_field_id('image'),
					'name' => $this-> get_field_name('image'),
					'value' => $instance['image'],
					'type' => 'image',
					'label' =>  __( 'Image', 'couponhut' ),
				);
				SSD_Widget_Fields::field($args);
			} ?>
        </p>
		
	<?php
	}

	
}
?>