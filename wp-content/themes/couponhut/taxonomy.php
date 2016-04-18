<?php
get_header();
?>

<?php
$term_slug = get_queried_object()->slug;
$term_name = get_queried_object()->name;
$term_id = get_queried_object()->term_id;
$term_taxonomy = get_queried_object()->taxonomy;
$term_description = get_queried_object()->description;

$acf_term =  $term_taxonomy . '_' . $term_id;

if( get_query_var( 'paged' ) )
	$paged = get_query_var( 'paged' );
else {
	if( get_query_var( 'page' ) )
		$paged = get_query_var( 'page' );
	else
		$paged = 1;
	set_query_var( 'paged', $paged );
}

if ( !$term_slug ) {
	return;
} else {


	$args = array( 
		'post_type' => 'deal',
		'posts_per_page' => 10,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => $term_taxonomy,
				'field'    => 'slug',
				'terms'    => $term_slug,
				),
			),
		);

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
}
   
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>
	<div class="container">

		<div class="row">
			<div class="col-sm-12">
				<div class="section-title-block">

				<?php
				$deals_string = $the_query->found_posts == 1 ? esc_html__('deal', 'couponhut') : esc_html__('deals', 'couponhut');
				?>
				<h1 class="section-title"><?php echo esc_html__('Browsing', 'couponhut') . ' ' . $the_query->found_posts . ' ' . $deals_string ?></h1>
				<?php 
				if ( function_exists('fw_ext_breadcrumbs') ) {
					fw_ext_breadcrumbs( '>' );
				}
				?>
				</div>
			</div><!-- end col-sm-12 -->
		</div><!-- end row -->

		<div class="row">

			<div class="col-sm-4 col-md-3">

				<div class="single-taxonomy-wrapper">

					<?php if ( get_field('company_logo', $acf_term) ): ?>
						<div class="single-taxonomy-logo">
						<?php
						$logo = get_field('company_logo', $acf_term);
						echo  wp_get_attachment_image( $logo['id'], 'ssd_company-logo' );
						?>
						</div>
					<?php elseif ( get_field('icon', $acf_term) ) : ?>
						<div class="single-taxonomy-icon">
							<i class="icon <?php echo esc_attr(get_field('icon', $acf_term)); ?>"></i>
						</div>
					<?php endif ?>

					<div class="single-taxonomy-info">
						<h2 class="single-taxonomy-title"><?php echo single_term_title(); ?> </h2>

						<div class="single-taxonomy-description">
							<p><?php echo wp_kses_post( $term_description ); ?></p>
						</div>

						<?php if ( get_field('company_website', $acf_term) ) : ?>
						<div class="single-taxonomy-website">
							<i class="icon-Globe-2"></i><a href="<?php echo esc_url(get_field('company_website', $acf_term)); ?>" target="_blank"><?php esc_html_e('Visit Website', 'couponhut') ?></a>
						</div>
						<?php endif; ?>
						
					</div>
				</div><!-- end single-taxonomy-wrapper -->

			</div><!-- end col-sm-4 col-md-3 -->
			<div class="col-sm-8 col-md-9">

				<?php if ($the_query->have_posts()) : ?>

				<div class="isotope-wrapper" data-isotope-cols="3" data-isotope-gutter="30">

					<?php while ($the_query->have_posts()) : $the_query->the_post(); ?>

					<?php get_template_part('loop/content', 'deal'); ?>

					<?php endwhile; ?> 

				</div><!-- end isotope-wrapper -->	

					<?php else : ?>

						<div class="no-posts-wrapper">
							<h3><?php esc_html_e('Currently there are no deals in category ', 'couponhut'); ?><span class="highlight"><?php echo wp_kses_post($term_name); ?></span></h3>
						</div>

					<?php endif; ?>

					<?php fw_ssd_paging_nav($the_query); ?>

					<?php wp_reset_postdata(); ?>				
				
			</div><!-- end col-sm-8 col-md-9 -->
		</div><!-- end row -->
	</div><!-- end container -->
</div><!-- end post -->

<?php get_footer(); ?>