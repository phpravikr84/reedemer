<?php
/* Template Name: Page with Sidebar */
get_header();
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div class="container">
		
			<div class="row">

				<div class="col-sm-8 col-md-9 <?php echo fw_ssd_get_option('sidebar-switch') == 'left' ? 'col-sm-push-4 col-md-push-3' : '' ?>">

					<?php if ( get_the_title() ) : ?>
						<div class="section-title-block">
							<h1 class="section-title"><?php echo get_the_title(); ?></h1>
							<?php 
							if ( function_exists('fw_ext_breadcrumbs') ) {
								fw_ext_breadcrumbs( '>' );
							}
							?>
						</div><!-- end section-title-block -->
					<?php endif; ?>

					<div class="page-content">
						<?php the_content(); ?>
					</div>

				</div><!-- end col-sm-8 col-md-9 -->
				<?php get_sidebar(); ?>
			</div><!-- end row-->

		</div><!-- end container -->

	<?php endwhile; else : ?>

		<div class="no-posts-wrapper">
			<h3><?php esc_html_e('Sorry, no posts found.', 'couponhut'); ?></h3>
		</div>

	<?php endif; ?>

</div><!-- end post -->

<?php get_footer(); ?>