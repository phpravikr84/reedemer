<?php
get_header();
?>
<div <?php post_class('page-wrapper'); ?>>

	<div class="container">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">
				<div class="page-content">
					<header class="error-header">
						<h1>Error 404</h1>
					</header>

					<div class="error404-message">
						<p><?php esc_html_e('Whatever you were looking for was not found, but maybe try looking again or search using the form below.', 'couponhut') ?></p>
					</div>

					<div class="error404-search">
						<?php get_search_form(); ?>
					</div>
				</div><!-- end page-content -->
				
			</div><!-- end col-sm-12 -->
		</div><!-- end row -->
		
	</div><!-- end container -->

</div><!-- end post -->

<?php get_footer(); ?>