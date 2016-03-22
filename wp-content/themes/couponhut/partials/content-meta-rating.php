<?php
global $post;

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

<meta style="display:none;" itemprop="worstRating" content="1"/>
<meta style="display:none;" itemprop="bestRating" content="5" />
<meta style="display:none;" itemprop="ratingValue" content="<?php echo $rating_average; ?>">

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
<span class="rating-text"> (<span class="rating-count"><?php echo wp_kses_post($rating_count_total); ?></span> <span class="rates" itemprop="reviewCount"><?php ( ($rating_count_total == 1) ? esc_html_e('review', 'couponhut') : esc_html_e('reviews', 'couponhut') ) ?></span>)</span>