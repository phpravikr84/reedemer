<?php 
/**
* ----------------------------------------------------------------------------------------
*    Deal Search Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Deal_Search extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('This widget adds deal search field to your site.','couponhut') );
		parent::__construct( 'deal_search', esc_html__('[CouponHut] Deal Search', 'couponhut'), $widget_ops );
	}

	
	public function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);


		echo $before_widget;

		echo '<div class="deal-search-widget-wrapper">';
		
		if ( $title ) { echo $before_title . $title . $after_title; } ?>
		
		<form action="<?php echo esc_url( home_url( "/" ) ); ?>" method="get">

			<div class="input-group">
				<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e('Search Deals', 'couponhut');?>">
				<input type="hidden" name="post_type" value="deal" />
				<span class="input-group-btn">
					<button type="submit" id="searchsubmit"><i class="fa fa-arrow-right"></i></button>
				</span>
			</div>

		</form>
		<?php

		echo '</div><!-- end deal-search-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);

		return $instance;

	}

	public function form( $instance ) {

		$defaults = array(
			'title' => esc_html__('Search', 'couponhut')
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			
		</p>
		
	<?php
	}
	
}
?>