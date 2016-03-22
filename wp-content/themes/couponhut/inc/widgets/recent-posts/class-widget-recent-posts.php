<?php  
/**
* ----------------------------------------------------------------------------------------
*    Recent Posts Widget
* ----------------------------------------------------------------------------------------
*/
Class SSD_Widget_Recent_Posts extends WP_Widget {
	
	public function __construct() {
		$widget_ops = array( 'description' => esc_html__("Your site's most recent Posts.",'couponhut') );
		parent::__construct( 'recent_posts', esc_html__('[CouponHut] Recent Posts', 'couponhut'), $widget_ops );
	}

	public function widget($args, $instance) {
		extract($args);

		$title = apply_filters('widget-title', $instance['title']);

		echo $before_widget;

		if( $title ) {
			echo $before_title . $title . $after_title;
		}

		$args = array(
			'post_type' => 'post',
			'posts_per_page' => $instance['posts_number'],
			'post_status' => 'publish'
		);

		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) : ?>
			<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post(); ?>
				<article class="<?php post_class(); ?>" id="post-'<?php the_ID(); ?> '">
				<?php if ( has_post_thumbnail() ) : ?>
					<a href="<?php echo esc_url(get_permalink()); ?>">
						<div class="recent-post-image">
							<?php the_post_thumbnail( 'recent-image' ); ?>
						</div>
						<div class="recent-post-post-header">
							<h1><?php the_title(); ?></h1>
							<p class="recent-post-meta-extra"><?php echo get_the_date(get_option('date_format')); ?></p>
						</div>
					</a>
				<?php else : ?>
					<a href="<?php echo esc_url(get_permalink()); ?>">
						<div class="recent-background">
							<div class="post-header no-img">
								<h1><?php the_title(); ?></h1>
								<p class="post-meta-extra"><?php echo get_the_date(get_option('date_format')); ?></p>
							</div>
						</div>
					</a>
				<?php endif; // has_post_thumbnail?>

				</article>

			<?php
			endwhile; //the_query ?>
		<?php
		endif; //the_query

		wp_reset_postdata();

		echo $after_widget;
	}

	public function update($new_instance, $old_instance) {
		$instance = $old_instance;

		$instance['title'] = strip_tags($new_instance['title']);
		$instance['posts_number'] = strip_tags($new_instance['posts_number']);

		return $instance;
	}

	public function form($instance) {
		$defaults = array(
			'title' => esc_html__('Recent Posts', 'couponhut'),
			'posts_number' => 5
		);

		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		
		<p>
			<label for="<?php echo esc_url($this->get_field_id('title')) ?>"><?php esc_html_e('Title', 'couponhut') ?></label>
			<input type="text" id="<?php echo esc_url($this->get_field_id('title')) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>" class="widefat" value="<?php echo esc_attr($instance['title']); ?> ">
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('posts_number')) ?>"><?php esc_html_e('Number of Posts', 'couponhut') ?></label>
			<input type="text" id="<?php echo esc_attr($this->get_field_id('posts_number')) ?>" name="<?php echo esc_attr($this->get_field_name('posts_number')) ?>" class="widefat" value="<?php echo esc_attr($instance['posts_number']); ?> ">
		</p>

		<?php
	}

}
?>