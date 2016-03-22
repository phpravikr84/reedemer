<?php
/* Template Name: Blog */
get_header();
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>
	
	<div class="container">
		
		<div class="row">
			<div class="col-sm-8 col-md-9 <?php echo fw_ssd_get_option('sidebar-switch') == 'left' ? 'col-sm-push-4 col-md-push-3' : '' ?>">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'loop/content', 'post' ); ?>

				<div class="comments-container">
					<?php comments_template( '', true ); ?>
				</div>

			<?php endwhile; endif; ?>	
			</div><!-- end col-sm-8 col-md-9 -->
			<?php get_sidebar('blog'); ?>
			
		</div>

	</div><!-- end container-fluid -->

</div><!-- end post -->


<?php get_footer(); ?>