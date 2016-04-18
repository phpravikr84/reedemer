<?php
/* Template Name: Contact */
get_header();
?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div class="page-contact-wrapper">

	<div class="split-section-row page-contact-map" data-split="1/1">
		<div class="split-section-col">
				<?php if ( get_field('image_or_map_location') == 'image' ): ?>
					<?php $image = get_field('upload_image'); ?>
					<div class="bg-image" data-bgimage="<?php echo esc_url( $image['sizes']['ssd_half-image'] ); ?>"></div>
					<div class="overlay-dark"></div>
					<div class="split-section-content">
						<h1 class="light-text"><?php echo wp_kses_post(get_field('image_title')) ?></h1>
						<?php echo wp_kses_post(get_field('image_text')) ?>
					</div>
				<?php else: ?>
					<?php $location = get_field('location'); ?>
					<div class="google-map">
						<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
					</div>

				<?php endif ?>
				
		</div>
		<div class="split-section-col">
			<div class="content-contact">
				<h1 class="page-title"><?php the_title(); ?></h1>
				<?php the_content(); ?>
			</div><!-- end content-contact -->
			
		</div>
	</div><!-- end split-section-row -->
	
</div><!-- end page-contact-wrapper -->

<?php endwhile; else : ?>

	<div class="no-posts-wrapper">
		<h3><?php esc_html_e('Sorry, no posts found.', 'couponhut'); ?></h3>
	</div>

<?php endif; ?>

<?php get_footer(); ?>