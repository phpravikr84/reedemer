<?php
/**
 * The template for displaying deals search results.
 */

get_header();
?>

<?php 
global $wp_query;

if ( !empty($_GET['s_deal_category']) ) {

	$cat_slug = $_GET['s_deal_category'];
	$myquery['tax_query'] = array(
		array(
			'taxonomy' => 'deal_category',
			'field' => 'slug',
			'terms' => $cat_slug
			)
		);
}


$myquery['meta_query'] = array(
	array(
		'relation' => 'OR',
		array(
			'key' => 'expiring_date',
			'value' => date('Ymd'),
			'compare' => '>=',
			'type' => 'UNSIGNED'
			),
		array(
			'key' => 'expiring_date',
			'value' => ''
			)
		)
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
	$myquery['meta_query']['relation'] = 'AND';
	array_push($myquery['meta_query'], $registered_array);
}




query_posts(
	array_merge(
		$myquery,
		$wp_query->query
	)
);

?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>


	<div class="container">
		
		<div class="row">

			<div class="col-sm-8 col-md-9 <?php echo fw_ssd_get_option('sidebar-switch') == 'left' ? 'col-sm-push-4 col-md-push-3' : '' ?>">
				
				<?php 

				if (have_posts()) : ?>

				<div class="section-title">
					<h3><?php esc_html_e('Search Results For: ', 'couponhut') ?><?php the_search_query(); ?></h3>
				</div>

				<div class="isotope-wrapper" data-isotope-cols="3" data-isotope-gutter="30">
					
					<?php while  ( have_posts() ) : the_post();

							get_template_part('loop/content', 'deal');
			
					endwhile;
					?>

				</div><!-- end isotope-wrapper -->

				<?php
				// Pagination
				fw_ssd_paging_nav();

				wp_reset_postdata();
				else : ?>
				<div class="no-posts-wrapper">
					<h3><?php esc_html_e('Sorry, no posts found.', 'couponhut'); ?></h3>
				</div>
				<?php
				endif; //have_posts()

				?>

			</div><!-- end col-sm-8 col-md-9 -->
			<?php get_sidebar(); ?>
		</div><!-- end rows cols-np -->

	</div><!-- end container-fluid -->


</div><!-- end post-id -->



<?php
get_footer();
?>