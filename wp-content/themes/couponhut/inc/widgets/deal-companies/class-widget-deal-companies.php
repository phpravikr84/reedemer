<?php 
/**
* ----------------------------------------------------------------------------------------
*    Deal Companies Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Deal_Companies extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('This widget adds deal companies to your site.','couponhut') );
		parent::__construct( 'deal_companies', esc_html__('[CouponHut] Deal Companies', 'couponhut'), $widget_ops );
	}

	public function widget( $args, $instance ) {

		extract($args);

		$deal_companies = get_terms('deal_company', array( 
			'hide_empty' => 0,
			'number' => $instance['number']
		));

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		$bgimage = $instance['bgimage'];

		if ( $bgimage ) :?>
			<?php
			$bgimage_array = wp_get_attachment_image_src($bgimage, 'ssd_widget-bgimage');
			$bgimage_url = $bgimage_array[0];	
			?>
			<div class="widget-bgimage" data-bgimage="<?php echo esc_url($bgimage_url) ?>"></div>
			<div class="overlay-dark"></div>
		<?php else: ?>
			<div class="overlay-color"></div>
		<?php endif;

		echo '<div class="deal-companies-widget-wrapper widget-list">';
		
		if ( $title ) { echo $before_title . $title . $after_title; }

		echo '<div class="widget-deal-companies-content">';

		if ( ! empty( $deal_companies ) && ! is_wp_error( $deal_companies ) ){
			echo '<ul>';
		
			// Categories List
			foreach ( $deal_companies as $deal_company ) {
				$category_link = get_term_link( $deal_company );
				echo '<li><a href="' . esc_url( $category_link ) . '"><span class="widget-list-number-counter">' . $deal_company->count . '</span>' . $deal_company->name . '</a></li>';
			}

			echo '</ul>';

		}

		echo '</div> <!-- end widget-deal-companies-content -->';

		echo '</div><!-- end deal-companies-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['bgimage'] = strip_tags($new_instance['bgimage']);
		$instance['number'] = strip_tags($new_instance['number']);

		return $instance;
	}

	public function form( $instance ) {
		
		$defaults = array(
			'title' => esc_html__('Deal Companies', 'couponhut'),
			'bgimage' => '',
			'number' => 10
		);

		$instance = wp_parse_args((array) $instance, $defaults);

		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Items', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
		<p>
			<?php if ( class_exists(SSD_Widget_Fields) ) {
				$args = array(
					'id' =>  $this->get_field_id('bgimage'),
					'name' => $this-> get_field_name('bgimage'),
					'value' => $instance['bgimage'],
					'type' => 'image',
					'label' =>  __( 'Background Image', 'couponhut' ),
				);
				SSD_Widget_Fields::field($args);
			} ?>
        </p>
		
	<?php
	}

	
}
?>