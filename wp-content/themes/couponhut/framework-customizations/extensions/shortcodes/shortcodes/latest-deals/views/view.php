<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php
$template_url = fw_ssd_get_browse_template_url();
if ( !$template_url ) : ?>
	<p><?php esc_html_e('<strong>Note!</strong> Make sure than you have published one (and only one) page that uses the "Browse Deals" Template.', 'couponhut') ?></p>
<?php else:	?>

<div class="section-title-block">
	<h1 class="section-title"><?php echo wp_kses_post( $atts['title'] ); ?></h1>
	<a href="<?php echo esc_url($template_url); ?>" class="see-more"><span><?php esc_html_e('All Deals', 'couponhut'); ?></span><i class="fa fa-arrow-right"></i></a>
</div>

<?php endif; ?>

<div class="latest-deals-wrapper isotope-wrapper" data-isotope-cols="<?php echo esc_attr($atts['columns_count']); ?>" data-isotope-gutter="30">

	<?php

	$args = array(
		'post_type' => 'deal',
		'posts_per_page' => $atts['deals_count'],
	);

	if ( $atts['type'] == 'coupons' ) {
		$args['meta_key'] = 'deal_type';
		$args['meta_value'] = 'coupon';
	} 

	if( $atts['type'] == 'discounts' ) {
		$args['meta_key'] = 'deal_type';
		$args['meta_value'] = 'discount';
	}

	// Hide deals with enabled "Registered Members Only" when not registered
	if ( function_exists('um_profile_id') && !um_profile_id() && !fw_ssd_get_option('member-only-show-switch') ) {
		$registered_array = array(
			'relation' => 'OR',
			array(
				'key' => 'registered_members_only',
				'value' => false,
				'compare' => '=',
				'type' => 'UNSIGNED'
			),
			array(
				'key' => 'registered_members_only',
				'compare' => 'NOT EXISTS'
				)
		);
		$args['meta_query']['relation'] = 'AND';
		array_push($args['meta_query'], $registered_array);
	}

	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>

		<?php get_template_part('loop/content', 'deal'); ?>

	<?php
	endwhile;
	endif;
	wp_reset_postdata(); 
	?>

</div><!-- end latest-deals-wrapper -->