<?php 
/**
* ----------------------------------------------------------------------------------------
*    Daily Deal Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Twitter extends WP_Widget {

	public function __construct() {
		$widget_ops = array( 'description' => esc_html__('Display your latest tweets.','couponhut') );
		parent::__construct( 'twitter', esc_html__('[CouponHut] Twitter', 'couponhut'), $widget_ops );
	}

	
	public function widget( $args, $instance ) {

		extract($args);

		$title = apply_filters('widget_title', empty($instance['title']) ? '' : $instance['title']);

		echo $before_widget;

		echo '<div class="twitter-widget-wrapper">';

		if ( $title ) { echo $before_title . $title . $after_title; }
		
		if( function_exists( 'fw_ssd_twitter_feed' ) ){
			$tweets = fw_ssd_twitter_feed( $instance['tweet_count'], $instance['username'] );
			if( !is_wp_error( $tweets ) && !empty( $tweets ) ) :
			$output = '';
			$output .= '<ul>';
				if ( !empty($tweets['error']) ) {
					$output .= '<li><div class="tweet-content">'. $tweets['error'] .'</div></li>';
				}
				else {
					foreach($tweets as $tweet){
						if( !empty($tweet['tweet']) )
							$output .= '<li><div class="tweet-content">'. $tweet['tweet'] .'</div> <span class="tweet-time">'. $tweet['time'] .'</span></li>';
					}
				}
			$output .= '</ul>';
			endif;
			
		}

		echo wp_kses_post($output);

		echo '</div><!-- end twitter-widget-wrapper -->';

		echo $after_widget;

	}

	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['tweet_count'] = (int) $new_instance['tweet_count'];

		return $instance;

	}

	public function form( $instance ) {

		$defaults = array(
			'title' => esc_html__('Twitter', 'couponhut'),
			'username' => '',
			'tweet_count' => '3'
		);
		
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>

		<!-- API Key check -->
		<?php
		if( function_exists( 'ssd_twitter_feed' ) ) :
		?>
		<p>
			<?php fw_ssd_api_key_check('twitter'); ?>
		</p>
		<?php endif; ?>

		<!-- The Title -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title', 'couponhut') ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" class="widefat" value="<?php echo esc_attr($instance['title']); ?>">
		</p>

		<!-- Username -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('username')); ?>"><?php esc_html_e('Username:','couponhut')?></label>
			<input id="<?php echo esc_attr($this->get_field_id('username')); ?>" class="widefat" name="<?php echo esc_attr($this->get_field_name('username')); ?>" type="text" value="<?php echo esc_attr($instance['username']); ?>" />
		</p>
		
		<!-- Number of tweets -->
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('tweet_count')); ?>"><?php esc_html_e('Number of tweets to show:','couponhut')?></label>
			<input id="<?php echo esc_attr($this->get_field_id('tweet_count')); ?>" class='widefat' name="<?php echo esc_attr($this->get_field_name('tweet_count')); ?>" type="number" value="<?php echo esc_attr((int) $instance['tweet_count']); ?>" />
		</p>
		
	<?php
	}
	
}

?>