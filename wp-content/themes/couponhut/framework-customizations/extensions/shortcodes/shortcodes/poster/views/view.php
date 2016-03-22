<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php
$imageurl = isset($atts['image']['url']) ? $atts['image']['url'] : '';
?>

<div class="poster-block">
	<a href="<?php echo esc_attr($atts['link']); ?>" target="<?php echo esc_attr($atts['button_target']); ?>">
		<div class="bg-image" data-bgimage="<?php echo esc_url($imageurl); ?>"></div>
		<div class="overlay-dark"></div>
		<h2 class="light-text" data-backtext="<?php echo esc_attr($atts['title']); ?>"><?php echo wp_kses_post($atts['title']); ?></h2>
	</a>
	
</div>