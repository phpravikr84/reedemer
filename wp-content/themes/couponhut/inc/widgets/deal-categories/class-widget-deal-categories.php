<?php 
/**
* ----------------------------------------------------------------------------------------
*    Deal Categories Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Deal_Categories extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('This widget adds deal categories to your site.','couponhut') );
		parent::__construct( 'deal_categories', esc_html__('[CouponHut] Deal Categories', 'couponhut'), $widget_ops );

	}
	
	public function widget( $args, $instance ) {

		extract($args);

		$instance['number'] = isset($instance['number']) ? $instance['number'] : 10;

		$deal_cats = get_terms('deal_category', array( 
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
		
		echo '<div class="deal-categories-widget-wrapper widget-list">';
		
		if ( $title ) { echo $before_title . $title . $after_title; }

		echo '<div class="widget-deal-categories-content">';

		if ( ! empty( $deal_cats ) && ! is_wp_error( $deal_cats ) ){
			echo '<ul>';
			// Categories List
			foreach ( $deal_cats as $deal_cat ) {
				$category_link = get_term_link( $deal_cat );
				echo '<li><a href="' . esc_url( $category_link ) . '"><span class="widget-list-number-counter">' . $deal_cat->count . '</span>' . $deal_cat->name . '</a></li>';
			}
			echo '</ul>';
		}

		echo '</div> <!-- end widget-deal-categories-content -->';
		
		echo '</div><!-- end deal-categories-widget-wrapper -->';

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
			'title' => esc_html__('Deal Categories', 'couponhut'),
			'bgimage' => '',
			'number' => 10
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?>:</label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />	
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of Items', 'couponhut') ?>:</label>
			<input class="widefat" id="<?php echo esc_attr($this->get_field_id('number')); ?>" name="<?php echo esc_attr($this->get_field_name('number')); ?>" type="text" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
		<p>
			<?php if ( class_exists(SSD_Widget_Fields) ) {
				$args = array(
					'id' =>  $this->get_field_id('bgimage'),
					'name' => $this->get_field_name('bgimage'),
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