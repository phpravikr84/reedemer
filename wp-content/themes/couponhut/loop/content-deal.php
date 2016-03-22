<?php
$discount_value = get_field('discount_value');
?>



<div class="card-deal">

	<!-- Modal Popup for Coupon Deals if enabled -->
	<?php 
	if ( fw_ssd_get_option('popup-coupons-switch') && get_field('deal_type') == 'coupon' ) :
	?>

	<?php 
	if ( get_field('image_type') == 'image' ) { 

		$image = get_field('image');

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
	<div class="modal fade" id="discount-modal-<?php the_ID();?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
	<?php endif; // fw_ssd_get_option('popup-coupons-switch')?>

	<div class="card-deal-inner">
		
		<div class="deal-thumb-image">
			<?php 
			$enable_redirect = get_field('redirect_to_offer') ? get_field('redirect_to_offer') : array('');
			
			if ( fw_ssd_get_option('popup-coupons-switch') && get_field('deal_type') == 'coupon' ) :
			?>
			<a href="<?php echo esc_url(get_field('url')); ?>" target="_blank" class="show-coupon-code" data-target="#discount-modal-<?php the_ID();?>" data-clipboard-text="<?php echo esc_attr(get_field('coupon_code')) ?>" data-redirect="<?php echo $enable_redirect[0]; ?>">
			<?php
			elseif (fw_ssd_get_option('popup-coupons-switch') && get_field('deal_type') == 'discount' ) :
			?>
			<a href="<?php echo esc_url(get_field('url')); ?>" target="_blank">	
			<?php
			else :
			?>
			<a href="<?php echo esc_url(get_permalink()); ?>">	
			<?php endif; ?>
			
				<!-- Ribbon -->
				<?php if( $discount_value && (fw_ssd_get_option('stamp-switch') == 'show') ) : ?>
					<div class="discount-ribbon"><?php echo wp_kses_post( $discount_value ); ?></div>
				<?php endif; ?>

				<!-- Button -->
				<?php if ( get_field('deal_type') == 'discount' ) : ?>
					<div class="btn-card-deal"><i class="icon-Shopping-Cart"></i><span><?php esc_html_e('View Deal', 'couponhut'); ?></span></div>
				<?php else : ?>
					<div class="btn-card-deal"><i class="icon-Scissor"></i><span><?php esc_html_e('View Coupon', 'couponhut'); ?></span></div>
				<?php endif; ?>

				<!-- Image -->
				<?php 

				if ( get_field('image_type') == 'image') {
					if ( get_field('image') ) {
				 			$image = get_field('image');
				 		}
				} else {

					if( have_rows('slider') ):

						$img_num = 1;

						while ( have_rows('slider') ) {

							the_row();
							if ( $img_num == 1 && get_sub_field('image') ) {
								$image = get_sub_field('image');

							}
							$img_num++;

					 	}

					endif;

				}
				?>

				<?php if( isset($image) ) : ?>
					<img src="<?php echo esc_url( $image['sizes']['ssd_deal-thumb'] );?>" alt="<?php echo esc_attr( $image['alt'] ); ?>">
				<?php endif; ?>
			</a>
		</div><!-- end deal-thumb-image -->

		<div class="card-deal-info">
			
			<!-- Title -->
			<h2 class="card-deal-title"><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h2>

			<!-- Category -->
			<?php
			$cats = get_the_terms( get_the_ID(), 'deal_category' );
			$cats_array = array();

			if ( $cats && ! is_wp_error( $cats ) ) {

				foreach ($cats as $cat) {
					$cat_link = '<a href="' . get_term_link($cat) . '">' . $cat->name . '</a>';
					array_push($cats_array, $cat_link);
				}

			}

			$cats_string = implode(', ',$cats_array);
			?>

			<div class="card-deal-categories"><?php echo $cats_string ?></div>
	

			<!-- Rating -->
			<div class="card-deal-meta-rating">
				<?php if ( fw_ssd_get_option('rating-switch') == 'show' ) : ?>
					
					<?php	
					$rating_average = get_post_meta($post->ID, 'rating_average', true);

					if( empty( $rating_average ) ){
						update_post_meta($post->ID, 'rating_average', 0 );
						$rating_average = 0;
					}

					$rating_count_total = get_post_meta($post->ID, 'rating_count_total', true);

					if( empty( $rating_count_total ) ){
						update_post_meta($post->ID, 'rating_count_total', 0 );
						$rating_count_total = 0;
					}
					?>

					<div class="post-star-rating">
						<?php
						for ( $i = 0; $i <= 4; $i++ ) {

							$rating_value = $i + 1;

							if ( $rating_average >= ( $i + 0.75 ) ) { ?>
								<i class="rating-star fa fa-star" data-post-id="<?php echo esc_attr($post->ID) ?>" data-rating="<?php echo esc_attr($rating_value); ?>"></i>
							<?php
							} else if ( $rating_average >= ( $i + 0.25 ) ) { ?>
								<i class="rating-star fa fa-star-half-o" data-post-id="<?php echo esc_attr($post->ID) ?>" data-rating="<?php echo esc_attr($rating_value); ?>"></i>
								<?php
							} else { ?>
								<i class="rating-star fa fa-star-o" data-post-id="<?php echo esc_attr($post->ID) ?>" data-rating="<?php echo esc_attr($rating_value); ?>"></i>
							<?php
							}

						}
						?>
					</div>

				<?php endif; ?>

			</div>

			<!-- Pricing -->
			<?php if ( get_field('show_pricing_fields') ) : ?>

			<div class="deal-prices">
				<div class="deal-old-price">
					<?php echo wp_kses_post(get_field('old_price')); ?>
				</div>
				<div class="deal-new-price">
					<?php echo wp_kses_post(get_field('new_price')); ?>
				</div>
				<div class="deal-save-price">
					<span><?php esc_html_e('You save:', 'couponhut') ?></span>
					<?php echo wp_kses_post(get_field('save')); ?>
				</div>
			</div>

			<?php endif; ?>

			<!-- Expiring -->
			<?php if( get_field('expiring_date') ) : ?>
				<div class="card-deal-meta-expiring">
					<div class="card-deal-meta-title"><?php esc_html_e('Expires in', 'couponhut'); ?></div>
					<span class="jscountdown-wrap" data-time="<?php echo esc_attr(get_field('expiring_date') ) ?>" data-short="true" ></span>
				</div>
			<?php endif; ?>

		</div><!-- end card-deal-info -->

	</div><!-- end card-deal-inner -->

</div><!-- end card-deal -->