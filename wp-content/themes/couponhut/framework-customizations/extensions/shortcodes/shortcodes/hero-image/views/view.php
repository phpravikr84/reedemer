<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php
	$section_class = 'hero-image';
?>

<section class="hero-image">

	<?php  

	$mp4_url = isset($atts['video_mp4']) ? $atts['video_mp4'] : '';
	$webm_url = isset($atts['video_webm']) ? $atts['video_webm'] : '';
	$ogg_url = isset($atts['video_ogg']) ? $atts['video_ogg'] : '';


	$imageurl = isset($atts['image']['url']) ? $atts['image']['url'] : '';

	?>

	<div class="bigvideo-wrapper" data-bigvideo-mp4="<?php echo esc_url($mp4_url); ?>" data-bigvideo-webm="<?php echo esc_url($webm_url); ?>" data-bigvideo-ogg="<?php echo esc_url($ogg_url); ?>" data-bigvideo-image="<?php echo esc_url($imageurl); ?>">
		<div class="bg-image" data-bgimage="<?php echo esc_url($imageurl); ?>"></div>
		<div class="overlay-dark"></div>
	</div>

	
	
	<div class="hero-image-content-wrapper">
		<div class="hero-image-content">
			<h1><?php echo wp_kses_post( $atts['title']); ?></h1>
			<p class="subtitle"><?php echo wp_kses_post( $atts['subtitle'] ); ?></p>
			<div class="hero-fields row">
				<div class="col-sm-12">
					<div class="searchform-wrapper">
						<form action="<?php echo esc_url( home_url( "/" ) ); ?>" method="get">
							<input type="text" name="s" placeholder="<?php esc_attr_e('Search Deals', 'couponhut');?>">
							<input type="hidden" name="post_type" value="deal" />
							<button type="submit" id="searchsubmit"><i class="fa fa-arrow-right"></i></button>
						</form>
					</div>
				</div>
					
			</div><!-- end hero-fields -->
			
		</div><!-- end hero-image-content -->
		
	</div><!-- end hero-image-content-wrapper -->
	
	
</section><!-- end hero-image -->
