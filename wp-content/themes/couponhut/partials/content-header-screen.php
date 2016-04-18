
<?php
	$image = fw_ssd_get_option('header-search-image');
	if ( $image ) {
		$bg_image = wp_get_attachment_image_src( $image['attachment_id'], 'ssd_single-post-image' );
		$image_url = $bg_image['0'];
	} else {
		$image_url = '';
	}
	

	// Categories
	$term_args = array( 'hide_empty' => 0 );
	$deal_cats = get_terms('deal_category', $term_args );

?>
<div class="header-screen">
	<div class="bg-image parallax" data-bgimage="<?php echo esc_url($image_url); ?>"></div>
	<div class="overlay-dark"></div>
	<div class="header-screen-content">
		<form action="<?php echo esc_url( home_url( "/" ) ); ?>" method="get" class="form-deal-submit header-screen-search">
			<span><?php esc_html_e("I'm searching for", 'couponhut') ?></span>
			<input type="text" name="s" placeholder="<?php esc_attr_e('Deals & Coupons', 'couponhut');?>">
			<span><?php esc_html_e('in', 'couponhut');?></span>
			<?php 
			if ( ! empty( $deal_cats ) && ! is_wp_error( $deal_cats ) ){

				if ( !empty($_GET['s_deal_category']) ) {
					$deal_cat_current = $_GET['s_deal_category'];
				} else {
					$deal_cat_current = '';
				}

				// Categories Dropdown
				echo '<div class="dropdown">';

				echo '<button id="categories-deal-dropdown dropdown-menu-one-column" class="btn-dropdown" data-toggle="dropdown" >' . esc_html__('Category', 'couponhut') . '</button>';

				echo '<ul class="dropdown-menu dropdown-menu-one-column" aria-labelledby="categories-deal-dropdown" data-name="s_deal_category">';
					echo '<li>
							<a href="#" data-value="" data-current="' . $current . '">' . esc_html__('None', 'couponhut') . '</a>
						</li>';
				foreach ( $deal_cats as $deal_cat ) {

					if ( $deal_cat->slug ==  $deal_cat_current ) {
						$current = 'true';
					} else {
						$current = 'false';
					}

					echo '<li>';
					if ( get_field('icon', "{$deal_cat->taxonomy}_{$deal_cat->term_id}") ) {
						$icon_class = get_field('icon', "{$deal_cat->taxonomy}_{$deal_cat->term_id}");	
						echo '<a href="' . get_term_link($deal_cat) . '" data-value="' . $deal_cat->slug . '" data-current="' . $current . '"><i class="' . $icon_class . '"></i>' . $deal_cat->name . '</a>';		
					} else {
						echo '<a href="' . get_term_link($deal_cat) . '" data-value="' . $deal_cat->slug . '" data-current="' . $current . '">' . $deal_cat->name . '</a>';	
					}
					echo '</li>';
					
				}
				echo '</ul>';
				echo '</div>';

			}

			if ( fw_ssd_get_option('geolocation-switch') ) :
			?>
				<span><?php esc_html_e('in country', 'couponhut');?></span>
				<?php 
				$all_countries = array();

				if( ( $all_countries = get_transient('ssd_all_countries') ) === false ) {	
					$all_countries = fw_ssd_get_all_countries();
					set_transient('ssd_all_countries', $all_countries, 0);
				}

				if ( !empty($_GET['deal_country']) ) {
					$deal_country_current = $_GET['deal_country'];
					$deal_country_current_none = '';
				} else {
					$deal_country_current = '';
					$deal_country_current_none = 'true';
				}
				// Countries Dropdown
				echo '<div class="dropdown">';

					echo '<button id="countries-deal-dropdown" class="btn-dropdown" data-toggle="dropdown" >' . esc_html__('Countries', 'couponhut') . '</button>';

					echo '<ul class="dropdown-menu" aria-labelledby="countries-deal-dropdown" data-name="deal_country">';

						echo '<li>
							<a href="javascript:void(0)" data-value="" data-current="' . $deal_country_current_none . '">' . esc_html__('None', 'couponhut') . '</a>
						</li>';

					foreach ( $all_countries as $deal_country ) {

						if ( $deal_country['slug'] ==  $deal_country_current ) {
							$current = 'true';
						} else {
							$current = 'false';
						}
						echo '<li>
							<a href="javascript:void(0)" data-value="' . $deal_country['slug'] . '" data-current="' . $current . '">' . $deal_country['name'] . '</a>
						</li>';
					}
					echo '</ul>';
				echo '</div>';
				?>
				<span><?php esc_html_e('and city', 'couponhut');?></span>
				<?php
				if ( !empty($_GET['deal_city']) ) {
					$deal_city_current = $_GET['deal_city'];
				} else {
					$deal_city_current = '';
				}

				// Cities Dropdown
				echo '<div class="dropdown">';

					echo '<button id="cities-deal-dropdown" class="btn-dropdown is-city-deal-dropdown" data-toggle="dropdown" >' . esc_html__('Cities', 'couponhut') . '</button>';

					echo '<ul class="dropdown-menu" aria-labelledby="cities-deal-dropdown" data-name="deal_city">';

					echo '</ul>';
				echo '</div>';
				?>
			<?php 
			endif;
			?>
			<input type="hidden" name="post_type" value="deal" />
			<input type="hidden" name="s_deal_category" value="" />
			<?php if ( fw_ssd_get_option('geolocation-switch') ) : ?>
			<input type="hidden" value="<?php echo esc_attr($deal_country_current); ?>" name="deal_country">
			<input type="hidden" value="<?php echo esc_attr($deal_city_current); ?>" name="deal_city">
			<?php endif; ?>
			<?php
			$ajax_class = fw_ssd_get_option('ajax-switch') ? 'is-ajax-deal-filter' : '';
			?>
			<button type="submit" class="<?php echo $ajax_class; ?>"><?php esc_html_e('Search', 'couponhut') ?></button>
		</form>
	</div>
</div>