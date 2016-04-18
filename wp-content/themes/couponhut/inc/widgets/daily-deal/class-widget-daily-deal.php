<?php 
/**
* ----------------------------------------------------------------------------------------
*    Daily Deal Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Daily_Deal extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('This widget adds selected deal as Daily Deal.','couponhut') );
		parent::__construct( 'daily_deal', esc_html__('[CouponHut] Daily Deal', 'couponhut'), $widget_ops );
	}

	
	public function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		?>

		<?php 
		$deal_image = get_field('image', $instance['daily_deal']);
		?>

		<div class="bg-image" data-bgimage="<?php echo $deal_image['sizes']['medium']; ?>"></div>
		<div class="overlay-dark"></div>

		<?php

		echo '<div class="daily-deal-widget-wrapper">';
		
		if ( $title ) { echo $before_title . $title . $after_title; } ?>

			<div class="daily-deal-content">
				<div class="daily-deal-title">
					<h2><a href="<?php echo esc_url(get_permalink($instance['daily_deal'])); ?>"><?php echo get_the_title($instance['daily_deal']); ?></a></h2>
				</div>
				<?php if ( get_field('expiring_date') ) : ?>
				<p class="daily-deal-expires-text"><?php esc_html_e('Expires in', 'couponhut') ?></p>
				<div class="daily-deal-expiring">
					<div class="jscountdown-wrap" data-time="<?php echo esc_attr( get_field('expiring_date', $instance['daily_deal']) ); ?>"></div>
				</div>
				<?php endif; ?>
			</div>

		<?php
		echo '</div><!-- end daily-deal-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['daily_deal'] = strip_tags($new_instance['daily_deal']);

		return $instance;

	}

	public function form( $instance ) {

		$defaults = array(
			'title' => esc_html__('Daily Deal', 'couponhut')
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
			
		</p>
		<p>
			<?php if ( class_exists(SSD_Widget_Fields) ) {
				$args = array(
					'id' =>  $this->get_field_id('daily_deal'),
					'name' => $this-> get_field_name('daily_deal'),
					'value' => esc_attr($instance['daily_deal']),
					'type' => 'multi-select',
					'label' =>  __( 'Daily Deal', 'couponhut' ),
					'choices' => fw_ssd_get_post_names('deal')
				);
				SSD_Widget_Fields::field($args);
			} ?>
        </p>
		
	<?php
	}
	
}

?>