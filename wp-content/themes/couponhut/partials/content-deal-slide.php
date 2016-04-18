<?php
$discount_value = get_field('discount_value');
?>
<div class="deals-slider">
		
	<div class="deal-slide-image">
		<a href="<?php echo esc_url(get_permalink()); ?>">
			<!-- Ribbon -->
			<?php if( $discount_value && (fw_ssd_get_option('stamp-switch') == 'show') ) : ?>
				<div class="discount-ribbon"><?php echo wp_kses_post( $discount_value ); ?></div>
			<?php endif; ?>

			<div class="deal-slide-overlay-text">
				
				<!-- Category -->
				<?php
				$cats = get_the_terms( get_the_ID(), 'deal_category' );
				$cats_array = array();

				if ( $cats && ! is_wp_error( $cats ) ) {

					foreach ($cats as $cat) {
						array_push($cats_array, $cat->name);
					}

				}

				$cats_string = implode(', ',$cats_array);
				?>

				<div class="deal-slide-categories"><?php echo $cats_string ?></div>

				<!-- Title -->
				<h2 class="deal-slide-title"><?php the_title(); ?></h2>

				<!-- Rating -->
				<div class="deal-slide-meta-rating">
				<?php if ( fw_ssd_get_option('rating-switch') == 'show' ) : ?>
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
				<?php endif; ?>
				</div>

				<!-- Expiring -->
				<?php if( get_field('expiring_date') ) : ?>
				<div class="deal-slide-meta-expiring">
					<div class="deal-slide-meta-title"><?php esc_html_e('Expires in', 'couponhut'); ?></div>
					<span class="jscountdown-wrap" data-time="<?php echo esc_attr(get_field('expiring_date') ) ?>" data-short="true" ></span>
				</div>
				<?php endif; ?>

				<!-- Button -->
				<?php if ( get_field('deal_type') == 'discount' ) : ?>
					<div class="btn-card-deal"><i class="icon-Shopping-Cart"></i><span>View Deal</span></div>
				<?php else : ?>
					<div class="btn-card-deal"><i class="icon-Scissor"></i><span>View Coupon</span></div>
				<?php endif; ?>

			</div><!-- end deal-slide-overlay-text -->

			

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

			<?php if ( $image ) : ?>
				<div class="bg-image"  data-bgimage="<?php echo esc_url( $image['sizes']['ssd_single-post-image'] ); ?>"></div>
			<?php endif; ?>
		</a>
		
	</div><!-- end deal-slide-image -->

</div><!-- end deals-slider -->