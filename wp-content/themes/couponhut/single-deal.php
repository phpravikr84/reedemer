<?php

if ( function_exists('um_profile_id') && !um_profile_id() && get_field('registered_members_only') ) {
	wp_redirect(home_url('login/'));
	exit;
}

get_header();

?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>


	<?php 
	if ( get_field('image_type') == 'image' ) { 

		$image = get_field('header_image') ? get_field('header_image') : get_field('image');

	} else { 

		if( have_rows('slider') ):

			$img_num = 1; 

			while ( have_rows('slider') ) : the_row(); 

				if ( $img_num == 1 && get_sub_field('image') ) {
					$image = get_sub_field('image');

				}
				$img_num++;

			endwhile;

		endif;
	}

	?>

	<div class="modal fade" id="discount-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<div class="modal-header">
					<h4 class="modal-title" id="myModalLabel"><?php the_title(); ?></h4>
					<?php if ( $image ) : ?>
					<div class="bg-image modal-deal-image" data-bgimage="<?php echo esc_url( $image['sizes']['ssd_single-post-image'] ); ?>"></div>
					<?php endif; ?>
				</div>
				<div class="modal-body">
					<div class="modal-deal-code">
						<?php echo wp_kses_post(get_field('coupon_code')); ?>
					</div>
				</div>
				<div class="modal-footer">
					<p><?php esc_html_e('Code is copied', 'couponhut') ?></p>
					<a href="<?php echo esc_url(get_field('url')); ?>" target="_blank" class="btn btn-color"><?php echo esc_html_e('Visit Deal', 'couponhut'); ?></a>
				</div>
			</div>
		</div>
	</div><!-- end modal -->
	
	<?php 
	$print_image = get_field('print_image');
	if ( $print_image ) : 
	?>
		<img src="<?php echo esc_url($print_image['url']) ?>" alt="" class="image-deal-print">
	<?php endif; ?>
	
	<div class="single-deal-wrapper" itemscope itemtype="http://schema.org/Product">
	
	<div class="single-deal-header-wrapper">
		<div class="single-deal-header">
			
			<?php get_template_part('partials/content', 'single-deal-header');  ?>
			<?php get_template_part('partials/content', 'single-deal-box');  ?>

		</div><!-- end single-deal-header -->
	</div>
	

	<div class="container">

		<div class="row">
			<div class="col-sm-8 col-md-9">

				<div class="single-deal-content">
					<?php the_content(); ?>
					<div class="single-deal-share">
						<?php get_template_part( 'partials/content', 'share-buttons' ); ?>
					</div><!-- end single-deal-share -->
				</div>
				<?php if ( 'open' == $post->comment_status ) : ?>
				<div class="comments-container">
					<?php comments_template( '', true ); ?>
				</div>
				<?php endif ?>
				
			</div><!-- end col-sm-8 col-md-9 -->

			<div class="col-sm-4 col-md-3" itemscope itemtype="http://schema.org/Offer">

				<?php 
				$companies = get_the_terms( get_the_ID(), 'deal_company' );

				if ( $companies && ! is_wp_error( $companies ) ) :
				?>
				
				<div class="widget" itemprop="seller" itemscope itemtype="http://schema.org/Organization">
					<h2 class="widget-title" itemprop="name"><?php esc_html_e('Company', 'couponhut') ?></h2>
					<?php
					$company_taxonomy = $companies[0]->taxonomy;
					$company_id = $companies[0]->term_id;
					$acf_term =  $company_taxonomy . '_' . $company_id;
					$logo = get_field('company_logo', $acf_term);?>
					<a href="<?php echo esc_url(get_term_link($companies[0])); ?>" >
					<?php
					echo wp_get_attachment_image($logo['id'], 'ssd_company-logo');?>
					</a>
					<h5><a href="<?php echo esc_url(get_term_link($companies[0])); ?>" ><?php echo wp_kses_post($companies[0]->name); ?></a></h5>
					<p>
						<?php echo wp_kses_post($companies[0]->description); ?>
					</p>
				</div><!-- end single-deal-company -->

				<?php endif; ?> 

				<?php 
				if ( get_field('show_location') =='show' && get_field('location') ) :
				?>

				<div class="widget">
					<h2 class="widget-title" ><?php esc_html_e('Location', 'couponhut') ?></h2>
					<?php 
					$location = get_field('location');
					$address = explode( ',' , $location['address']);
					?>
					<div class="single-deal-map" data-gmap-zoom="<?php echo esc_attr(get_field('map_zoom')); ?>">
						<div class="marker" data-lat="<?php echo esc_attr($location['lat']); ?>" data-lng="<?php echo esc_attr($location['lng']); ?>"></div>
					</div>
					<p>
					<?php echo esc_attr($location['address']); ?>
					</p>
					
				</div><!-- end single-deal-company -->

				<?php endif; ?>
	
			</div><!-- end col-sm-3 -->

		</div><!-- end row -->
		
	</div><!-- end container -->

</div><!-- end single-deal-wrapper -->


<?php endwhile; endif; ?>
<?php
get_footer();
?>