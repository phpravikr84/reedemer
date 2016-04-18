<?php
/* Template Name: Front Page */
get_header();
?>

<div id="post-<?php the_ID(); ?>" class="overflow-h">

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<?php the_content(); ?>

	<?php endwhile; else : ?>

		<div class="no-posts-wrapper">
			<h3><?php esc_html_e('Sorry, no posts found.', 'couponhut'); ?></h3>
		</div>

	<?php endif; ?>
	
</div><!-- end post -->

<?php get_footer(); ?>