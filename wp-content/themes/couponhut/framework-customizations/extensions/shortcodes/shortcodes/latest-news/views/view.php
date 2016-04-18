<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php 
if( get_option( 'show_on_front' ) == 'page' ) {
	$blog_url = get_permalink( get_option('page_for_posts' ) );
} else {
	$blog_url = home_url('/');
}
?>

<div class="section-title-block">
	<h1 class="section-title"><?php echo wp_kses_post( $atts['title']); ?></h1>
	<a href="<?php echo esc_url( $blog_url ); ?>" class="see-more"><span><?php esc_html_e('All News', 'couponhut'); ?></span><i class="fa fa-arrow-right"></i></a>

</div>

<div class="row">

	<?php 
	$args = array(
		'post_type' => 'post',
		'max_num_pages' => 1,
		'posts_per_page' => 3,
		'post_status' => 'publish'
	);

	$blog_query = new WP_Query($args);

	if ($blog_query->have_posts()) : while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
	
	<div class="col-sm-4">

		<div class="post-wrapper">
			<a href="<?php echo esc_url(get_permalink());?>" >

			<?php if (has_post_thumbnail() ) :?>	
				<div class="post-image">
					<?php the_post_thumbnail( 'ssd_blog-thumb' ); ?>
				</div><!-- end post-image -->
			<?php endif; ?>

			</a>

			<div class="post-header">
				<h2 class="post-title"><a href="<?php echo esc_url(get_permalink());?>"><?php the_title(); ?></a></h2>
				<div class="post-meta-date">
					<i class="icon-Calendar"></i>
					<?php echo get_the_date(); ?>
				</div>
			</div><!-- end post-header -->

		</div><!-- end post-wrapper -->

	</div><!-- end col-sm-4 -->
	
	<?php endwhile; endif; 
	wp_reset_postdata();
	?>
	
</div><!-- end row -->