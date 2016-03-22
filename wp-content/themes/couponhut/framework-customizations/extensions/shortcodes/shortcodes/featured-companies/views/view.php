<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php 
$company_ids = array();
if ( $atts['featured_companies'] ) :

foreach ($atts['featured_companies'] as $array) {
	array_push($company_ids, $array[0]);
}
?>

<div class="featured-companies-wrapper">
	
	<div class="section-title-block">
		<h1 class="section-title"><?php echo wp_kses_post( $atts['title'] ); ?></h1>
	</div>
	<?php echo wp_kses_post( $atts['text_content']); ?>

	<div class="isotope-wrapper" data-isotope-gutter="5" data-isotope-cols="3" data-isotope-cols-sm="2">

		<?php
		$companies_ids = array();
		foreach ($atts['featured_companies'] as $array) {
			array_push($companies_ids, $array[0]);
		}

		$terms = get_terms('deal_company');

		if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){

			foreach ($companies_ids as $company_id) {

				$current_company = get_term_by( 'id', $company_id, 'deal_company' );

				if ( ! empty( $current_company ) && ! is_wp_error( $current_company ) ){
					$image = get_field('company_logo', 'deal_company_' . $company_id);

					echo '<a href="'. get_term_link( $current_company->slug, 'deal_company' ) .'" class="featured-company-item">';
					echo '<div class="featured-company-inner">';
					echo  wp_get_attachment_image( $image['id'], 'ssd_company-logo' );
					echo '</div><!-- end featured-company-inner -->';
					echo '</a>';
				}
				
			}
		}

		
		?>
	</div><!-- end isotope-wrapper -->
	
	<?php
	$pages = get_pages(array(
		'meta_key' => '_wp_page_template',
		'meta_value' => 'template-browse-companies.php',
		'post_status' => 'publish',
		));
	if ( count($pages) > 1 ) : ?>

	<p>Make sure than you have published only one page that uses the "Browse Companies" Template.</p>

	<?php elseif ( count($pages) < 1 ) : ?>

	<p>Make sure than you have published one page that uses the "Browse Companies" Template.</p>

	<?php else:

	$template_url = get_permalink( $pages[0]->ID );
	?>
	
	<a href="<?php echo esc_url($template_url); ?>" class="btn"><?php esc_html_e('All Companies', 'couponhut') ?><i class="fa fa-arrow-right"></i></a>
	<?php endif; ?>

</div><!-- end featured-companies-wrapper -->

<?php endif; // if $atts['featured_companies'] ?>