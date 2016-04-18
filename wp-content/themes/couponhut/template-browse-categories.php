<?php
/*
Template name: Browse Categories
*/
get_header();
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>
	
	<?php
	$args = array(
		'hide_empty'  => false,
		'orderby'     => fw_ssd_get_option('order-categories'),
		'order'       => fw_ssd_get_option('order-categories') == 'name' ? 'ASC' : 'DESC'
		); 
	$terms = get_terms( 'deal_category', $args );
	
	if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) : ?>

	<div class="container">
	
		<div class="row">

			<div class="col-sm-8 col-md-9">

				<div class="section-title-block">
					<h1 class="section-title"><?php the_title(); ?></h1>
					<?php 
					if ( function_exists('fw_ext_breadcrumbs') ) {
						fw_ext_breadcrumbs( '>' );
					}
					?>
				</div><!-- end section-title-block -->

				<div class="isotope-wrapper" data-isotope-cols="3" data-isotope-gutter="30">

				<?php
				foreach ( $terms as $term ) :
					$acf_term = $term->taxonomy . '_' . $term->term_id;
					if ( get_field('icon', $acf_term) ) : ?>

						<div class="grid-item">
							<a href="<?php echo get_term_link( $term->slug, 'deal_category' ); ?>" class="grid-item-icon">
								<i class="icon <?php echo esc_attr(get_field('icon', $acf_term)); ?>"></i>
								<h2><?php echo wp_kses_post($term->name); ?></h2>
							</a>
						</div><!-- end grid-item -->
					<?php
					endif; 
				endforeach;
				?>

				</div><!-- end isotope-wrapper -->

			</div><!-- end col-sm-8 col-md-9 -->

			<?php get_sidebar(); ?>

		</div><!-- end rows cols-np -->

	</div><!-- end container-fluid -->

	<?php endif; ?>

</div><!-- end post-id -->


<?php
get_footer();
?>