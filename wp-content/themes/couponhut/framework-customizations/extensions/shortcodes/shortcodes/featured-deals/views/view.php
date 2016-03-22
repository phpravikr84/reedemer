<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php
if ( $atts['featured_posts'] ) :

$template_url = fw_ssd_get_browse_template_url();
if ( !$template_url ) : ?>
	<p><?php esc_html_e('<strong>Note!</strong> Make sure than you have published one (and only one) page that uses the "Browse Deals" Template.', 'couponhut') ?></p>
<?php else:	?>

<?php endif; ?>

<div id ="<?php echo esc_attr( $atts['id'] ); ?>" class="featured-deals-slider owl-carousel">
	
	<?php 
	$post_ids = array();
	foreach ($atts['featured_posts'] as $array) {
		array_push($post_ids, $array[0]);
	}	

	$args = array(
		'post_type' => 'deal',
		'posts_per_page' => -1,
		'post__in' => $post_ids
	);
	$the_query = new WP_Query($args);

	if ($the_query->have_posts()) : while ($the_query->have_posts()) : $the_query->the_post(); ?>	
	
		<div class="deal-item-wrapper">
			<?php get_template_part('partials/content', 'deal-slide'); ?>
		</div>
		
	<?php
	endwhile;
	endif;
	wp_reset_postdata(); 
	?>
	
</div><!-- end featured-deals-carousel -->

<?php endif; // if $atts['featured_posts'] ?>