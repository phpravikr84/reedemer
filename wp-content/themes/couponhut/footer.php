<?php
if( !empty( $ssd_get_option['tracking-code']) ) {
  echo wp_kses_post( $ssd_get_option['tracking-code'] );
}
?>
<?php if( is_active_sidebar('footer1') ) : ?>
<footer class="footer">	
	<?php if ( fw_ssd_get_option('footer_image') ): ?>
		<?php $footer_img = fw_ssd_get_option('footer_image'); ?>
		<div class="bg-image parallax" data-bgimage="<?php echo esc_url($footer_img['url']); ?>"></div>
		<div class="overlay-dark"></div>
	<?php endif ?>
	
	<div class="container footer-wrapper">
		<div class="row">

			<?php get_template_part('partials/content','footer-widgets'); ?>

		</div>
		<div class="row">
			<div class="col-sm-12">
				<section class="copyright">
					<?php echo wp_kses_post( fw_ssd_get_option('copyright-text')); ?>
				</section>
			</div>
		</div>
		

	</div><!-- end container -->
</footer>
<?php endif; ?>


<?php wp_footer() ;?>

</body>
</html>