<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
* ----------------------------------------------------------------------------------------
*    Ultimate Member Filters and Actions
* ----------------------------------------------------------------------------------------
*/


/**
*  Nav Menu Login Icon
*/

add_filter('wp_nav_menu_items','search_box_function', 10, 2);
function search_box_function( $nav, $args ) {


    if( function_exists('um_profile_id') && $args->theme_location == 'main-navigation' ){
   //  	$args = array(
			// 'post_type' => 'page',
			// 'fields' => 'ids',
			// 'nopaging' => true,
			// 'meta_key' => '_wp_page_template',
			// 'meta_value' => 'page-special.php'
   //  	);
   //  	$profile_pages = get_posts( $args );
   //  	foreach ( $pages as $page ) 
   //  		echo $page . '</br>';
    	// $op_pages = um_get_option('um_core_pages');
    	// fw_print($op_pages);
    	$um_user = get_option('um_core_pages');
    	$url_user = $um_user ? get_permalink($um_user['user']) : '';
    	
    	$um_login = get_option('um_core_pages');
    	$url_login = $url_login ? get_permalink($um_login['login']) : '';

    	$um_logout = get_option('um_core_pages');
    	$url_logout = $url_logout ? get_permalink($um_logout['logout']) : '';

    	$um_register = get_option('um_core_pages');
    	$url_register = $url_register ? get_permalink($um_register['register']) : '';

    	?>
    	<?php 
    	ob_start(); ?>

		<li class="menu-item-has-children">
			<?php if ( um_profile_id() ) : ?>
				<a href="<?php echo $url_user; ?>"><i class='icon-User'></i><?php echo um_get_display_name( um_profile_id() ); ?></a>
			<?php else: ?>
				<a href="<?php echo $url_login; ?>"><i class='icon-User'></i></a>
			<?php endif; ?>
			<ul class="sub-menu">
				<?php if ( um_profile_id() ) : ?>
				<li><a href="<?php echo $url_user; ?>"><?php esc_html_e('Profile', 'couponhut') ?></a></li>
				<?php 
				$template_id = fw_ssd_get_submit_template_id();
				if ( $template_id ) : ?>
				<li><a href="<?php echo get_permalink($template_id); ?>"><?php esc_html_e('Submit', 'couponhut') ?></a></li>
				<?php endif; ?>
				<li><a href="<?php echo $url_logout; ?>"><?php esc_html_e('Log Out', 'couponhut') ?></a></li>
				<?php else : ?>
				<li><a href="<?php echo $url_login; ?>"><?php esc_html_e('Log In', 'couponhut') ?></a></li>
				<li><a href="<?php echo $url_register; ?>"><?php esc_html_e('Register', 'couponhut') ?></a></li>
				<?php endif; ?>
			</ul>
		</li>
    	<?php
    	$ob_content = ob_get_contents();
		ob_end_clean();
        return $nav . $ob_content;
    }

    return $nav;
}

/**
*  Custom Profile Tab
*/

/* add a custom tab to show user deals */
add_filter('um_profile_tabs', 'pages_tab', 1000 );
function pages_tab( $tabs ) {
	unset($tabs['posts']);
	unset($tabs['comments']);

	$tabs['main']['icon'] = 'icon-User';	
	$tabs['deals'] = array(
		'name' => 'Deals',
		'icon' => 'icon-Pencil',
		'custom' => true
	);	
	return $tabs;
}



/* Tell the tab what to display */
add_action('um_profile_content_deals_default', 'um_profile_content_deals_default');
function um_profile_content_deals_default( $args ) {
	global $ultimatemember;
	$user_deals = $ultimatemember->query->make('post_type=deal&posts_per_page=10&offset=0&author=' . um_profile_id() );

	if ($user_deals->have_posts()) : ?>

	<div class="isotope-wrapper" data-isotope-cols="4" data-isotope-gutter="30">
		
		<?php while  ( $user_deals->have_posts() ) : $user_deals->the_post(); ?>
			<div class="deal-item-wrapper">
				<?php get_template_part('loop/content', 'deal'); ?>
			</div>
				
		<?php
		endwhile;
		?>

	</div><!-- end isotope-wrapper -->
	<?php
	endif;
}


/**
*  Customize account tabs
*/

add_filter('um_account_page_default_tabs_hook', '_action_ssd_custom_tab_icons', 100 );
function _action_ssd_custom_tab_icons( $tabs ) {
	
	$tabs[100]['general']['icon'] = 'icon-Pencil';
	$tabs[200]['password']['icon'] = 'icon-Unlock';
	$tabs[300]['privacy']['icon'] = 'icon-Key-2';
	$tabs[9999]['delete']['icon'] = 'icon-Eraser';

	return $tabs;
}
