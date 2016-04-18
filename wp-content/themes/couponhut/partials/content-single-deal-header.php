<?php if ( get_field('image_type') == 'image' ) { ?>

	<?php $image = get_field('header_image') ? get_field('header_image') : get_field('image'); ?>
	<?php if ( $image ) : ?>
		<div class="bg-image"  data-bgimage="<?php echo esc_url( $image['sizes']['ssd_single-post-image'] ); ?>"></div>
	<?php endif; ?>
			

<?php } else { ?>

	<div class="single-deal-slider">

		<?php

		if( have_rows('slider') ):

		   while ( have_rows('slider') ) : the_row(); ?>

				<?php // get_sub_field('image'); ?>
				<?php $image = get_sub_field('image'); ?>
				<?php if ( $image ) : ?>
					<div class="single-deal-slide">
						<div class="bg-image" data-bgimage="<?php echo esc_url( $image['sizes']['ssd_single-post-image'] ); ?>"></div>
					</div>
				<?php endif; ?>

		   <?php endwhile;

		endif;

		?>

	</div><!-- end single-deal-slider -->

<?php } //end get_field('image_type') check ?>

<div class="single-deal-header-content">
	<h1 class="single-deal-title" itemprop="name"><?php the_title(); ?></h1>
	<?php if ( fw_ssd_get_option('rating-switch') == 'show' ) : ?>
	<div class="single-deal-rating" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
		<?php get_template_part( 'partials/content', 'meta-rating' ); ?>
	</div><!-- end single-deal-rating -->
	<?php endif; ?>
</div>