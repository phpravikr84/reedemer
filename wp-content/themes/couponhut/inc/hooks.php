<?php if ( ! defined( 'ABSPATH' ) ) { die( 'Direct access forbidden.' ); }
/**
 * Filters and Actions
 */


if ( ! function_exists( '_action_ssd_theme_setup' ) ) {
	function _action_ssd_theme_setup() {

		/*
		 * Make Theme available for translation.
		 */
		load_theme_textdomain( 'couponhut', get_template_directory() . '/lang' );

		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'title-tag' );
		add_image_size( 'ssd_deal-thumb', 400, 470, true );
        add_image_size( 'ssd_blog-thumb', 420, 280, true );
        add_image_size( 'ssd_single-post-image', 1300, 700, true );
        add_image_size( 'ssd_company-logo', 440, 200, true );
        add_image_size( 'ssd_half-image', 800, 1000, true );
        add_image_size( 'ssd_widget-bgimage', 400, 800, true );


		set_post_thumbnail_size( 50, 50, true );

		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption'
			) );

		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

	}
}
add_action( 'init', '_action_ssd_theme_setup' );

/**
*  Declare theme supports. These are used by the Subsolar Designs Extras plugin to
*  register the needed custom post types and widgets for the theme. If the plugin is activated
* on nonSubsoalr Designs theme, it will activate everything.
*/

if(!( function_exists('_action_ssd_declare_theme_support') )){
	function _action_ssd_declare_theme_support() {
		add_theme_support('subsolar-theme');
		add_theme_support('subsolar-deal');
	}
	add_action('after_setup_theme', '_action_ssd_declare_theme_support', 10);
}

/**
 * Register widget areas.
 */
function _action_ssd_theme_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar Widget Area', 'couponhut' ),
		'id'            => 'sidebar-main',
		'description'   => esc_html__( 'Appears in the sidebar section of the site.', 'couponhut' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		) );
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar Widget Area', 'couponhut' ),
		'id'            => 'sidebar-blog',
		'description'   => esc_html__( 'Appears in the sidebar section of the blog page.', 'couponhut' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div><!-- end widget -->',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
		) );

	// Footer Columns
	register_sidebar(
		array(
			'id' => 'footer1',
			'name' => esc_html__( 'Footer Column 1', 'couponhut' ),
			'description' => esc_html__( 'If this is set, your footer will be 1 column', 'couponhut' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			)
		);
	register_sidebar(
		array(
			'id' => 'footer2',
			'name' => esc_html__( 'Footer Column 2', 'couponhut' ),
			'description' => esc_html__( 'If this and Footer Column 1 are set, your footer will be 2 columns.', 'couponhut' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			)
		);	
	register_sidebar(
		array(
			'id' => 'footer3',
			'name' => esc_html__( 'Footer Column 3', 'couponhut' ),
			'description' => esc_html__( 'If this Footer Column 1 and Footer Column 2 are set, your footer will be 3 columns.', 'couponhut' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			)
		);
	register_sidebar(
		array(
			'id' => 'footer4',
			'name' => esc_html__( 'Footer Column 4', 'couponhut' ),
			'description' => esc_html__( 'If this Footer Column 1, Footer Column 2 and Footer Column 3 are set, your footer will be 4 columns.', 'couponhut' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget' => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
			)
		);
}

add_action( 'widgets_init', '_action_ssd_theme_widgets_init' );

/**
*  JS Check
*/
function _action_ssd_html_js_class () {
	echo '<script>document.documentElement.className = document.documentElement.className.replace("no-js","js");</script>'. "\n";
}
add_action( 'wp_head', '_action_ssd_html_js_class', 1 );

/**
*  AJAX
*/

add_action( 'wp_ajax_nopriv__action_ssd_post_like', '_action_ssd_post_like' );
add_action( 'wp_ajax__action_ssd_post_like', '_action_ssd_post_like' );
function _action_ssd_post_like() {
    // Check for nonce security

	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
		die ( 'Busted!');

	if(isset($_POST['post_like'])) {
        // Retrieve user IP address
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$post_id = $_POST['post_id'];

        	// Get voters'IPs for the current post
		$meta_IP = get_post_meta($post_id, "voted_IP");
		if( isset($meta_IP[0]) ) {
			$voted_IP = $meta_IP[0];
		} else {
			$voted_IP = array();
		}

		// Get votes count for the current post
		$votes_count = get_post_meta($post_id, "votes_count", true);

		if(!is_array($voted_IP)) {
			$voted_IP = array();
		}

        // User has already voted ?
		if(!$fw_ssd_has_already_voted($post_id)) {
            // Save IP and increase votes count
			update_post_meta($post_id, "voted_IP", sanitize_text_field($voted_IP));
			update_post_meta($post_id, "votes_count", sanitize_text_field(++$votes_count));

            // Display count (ie jQuery return value)
			echo $votes_count;
		}
		else
			echo "already";
	}
	die();
}

add_action( 'wp_ajax_nopriv__action_ssd_post_rate', '_action_ssd_post_rate' );
add_action( 'wp_ajax__action_ssd_post_rate', '_action_ssd_post_rate' );
function _action_ssd_post_rate() {

    // Check for nonce security
	$nonce = $_POST['nonce'];

	if ( ! wp_verify_nonce( $nonce, 'ajax-nonce' ) )
		die ( 'Busted!');

	if(isset($_POST['post_rate'])) {
        // Retrieve user IP address
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		$post_id = $_POST['post_id'];

        // Get voters'IPs for the current post
		$meta_IP = get_post_meta($post_id, "voted_IP");
		if( isset($meta_IP[0]) ) {
			$voted_IP = $meta_IP[0];
		} else {
			$voted_IP = array();
		}

		// Get votes count for the current post
		$rating = $_POST['rating'];
		$rating_field = 'rating_count_' . $rating;

		$ratings_count = get_post_meta($post_id, $rating_field, true);
		$rating_count_total = get_post_meta($post_id, "rating_count_total", true);

		if(!is_array($voted_IP)) {
			$voted_IP = array();
		}

        // User has already voted ?
		if(!fw_ssd_has_already_voted($post_id)) {

			$return = array();
			$voted_IP[$ip] = time();

            // Save IP and increase votes count
			update_post_meta($post_id, "voted_IP", $voted_IP);
			update_post_meta($post_id, $rating_field, sanitize_text_field(++$ratings_count) );

			update_post_meta($post_id, "rating_count_total", sanitize_text_field(++$rating_count_total) );

			$stars_total = 0;
			$votes_num = 0;

			for ( $i = 1; $i <= 5; $i++ ) {
				$rating_field = 'rating_count_' . $i;
				$ratings_count = get_post_meta($post_id, $rating_field, true);
				$stars_total += $i * $ratings_count;

				$votes_num += $ratings_count; 
			}

			update_post_meta($post_id, 'stars_total', sanitize_text_field($stars_total) );

			$rating_average = $stars_total / $votes_num;
			$rating_average = number_format((float)$rating_average, 2, '.', '');

			update_post_meta($post_id, "rating_average", sanitize_text_field($rating_average) );

            	// The array containing the printable stars in the front end
			$stars_array = array();

			for ( $i = 0; $i <= 4; $i++ ) {

				if ( $rating_average >= ( $i + 0.75 ) ) {
					$stars_array[$i] = 'full';
				} else if ( $rating_average >= ( $i + 0.25 ) ) {
					$stars_array[$i] = 'half';
				} else {
					$stars_array[$i] = 'empty';
				}

			}

			$return['average'] = $rating_average;
			$return['rating_count_total'] =get_post_meta($post_id, 'rating_count_total');
			$return['stars'] = $stars_array;

			echo json_encode($return);
		}
		else
			echo "already";
	}
	die();
}


/**
*  AJAX show cities on Country Dropdown select
*/

add_action( 'wp_ajax_nopriv__action_ssd_show_cities', '_action_ssd_show_cities' );
add_action( 'wp_ajax__action_ssd_show_cities', '_action_ssd_show_cities' );
function _action_ssd_show_cities() {

	$deal_country_slug = $_POST['country'] ?  $_POST['country'] : '';
	$deal_city_slug = $_POST['city'] ?  $_POST['city'] : '';

	$cities = array();

	// $args = array(
	// 	'post_type' => 'deal',
	// 	'posts_per_page' => -1
	// 	);

	// $deals_query = new WP_Query($args);

	// // Collect all cities for $deal_country_slug
	// if ($deals_query->have_posts()) : while ($deals_query->have_posts()) : $deals_query->the_post();

	// 	$post_country_slug = get_post_meta(get_the_ID(), 'geo_country_slug');
	// 	$post_city_slug = get_post_meta(get_the_ID(), 'geo_city_slug');
	// 	$post_city = get_post_meta(get_the_ID(), 'geo_city');

	// 	if ( $post_country_slug[0] && ($post_country_slug[0] == $deal_country_slug) && !in_array($post_city_slug[0], $cities)  ) {
	// 		$cities[$post_city[0]]['name'] = $post_city[0];
	// 		$cities[$post_city[0]]['slug'] = $post_city_slug[0];
	// 	}

	// endwhile; endif;

	// wp_reset_postdata();

	if( ( $all_locations = get_transient('ssd_all_locations') ) === false ) {	
		$all_locations = fw_ssd_get_all_locations();
		set_transient('ssd_all_locations', $all_locations, 0);
	}

	$html ='';

	// If cities are found create cities dropdown list
	$cities = $all_locations[$deal_country_slug];
	if ( !empty($cities) ) {

		$cities_found = true;
		
		foreach ( $cities as $city ) {
			if ( $city['slug'] ==  $deal_city_slug ) {
				$current = 'true';
			} else {
				$current = 'false';
			}

			$html .= '<li><a href="javascript:void(0)" data-value="' . $city['slug'] . '" data-current="' . $current . '">' . $city['name'] . '</a></li>';
		}

	} else {
		$cities_found = false;

		$html .= '<li><a href="javascript:void(0)" data-value="" data-current="">' . esc_html__('None', 'couponhut') . '</a href="javascript:void(0)"></li>';
		$html .= '<li class="select-country-first"><a href="javascript:void(0)">' . esc_html__('Please select a country', 'couponhut') . '</a></li>';
	}

	$response = array(
		'html' => $html,
		'cities_found' => $cities_found,
	);

	echo json_encode($response);


	die();
}

/**
 *  Add Admin Scripts
 */

function _action_ssd_enqueue_admin_scripts(){
	
}
add_action( 'admin_enqueue_scripts', '_action_ssd_enqueue_admin_scripts', 21 );


/**
 *  Hide not needed Unyson Extensions
 */

if (defined('FW')):
	function _action_ssd_hide_extensions_from_the_list() {

		if (fw_current_screen_match(array('only' => array('id' => 'toplevel_page_fw-extensions')))) {
			echo '
			<style type="text/css">
			#fw-ext-analytics, #fw-ext-megamenu, #fw-ext-portfolio, #fw-ext-styling, #fw-ext-seo, #fw-ext-feedback, #fw-ext-events, #fw-ext-learning, #fw-ext-social, #fw-ext-translation, #fw-ext-slider, #fw-ext-sidebars, fw-ext-backup { display: none !important; }
			</style>';
		}
	}
	add_action('admin_print_scripts', '_action_ssd_hide_extensions_from_the_list');
	endif;


/**
 *  Remove default sliders from Slider Extension
 */

function _filter_ssd_theme_flush_rewrite(){ 

	flush_rewrite_rules() ;
}
add_filter( 'fw_ext_backup_after_import_demo_content' , '_filter_ssd_theme_flush_rewrite');


/**
 *  Remove default Shortcodes
 */

if (defined('FW')):

	function _filter_ssd_disable_default_shortcodes($to_disable) {
		$to_disable = array( 'calendar', 'icon', 'map', 'special_heading', 'table', 'team_member', 'testimonials', 'contact_form', 'widget_area', 'call_to_action');
		return $to_disable;
	}
	add_filter('fw_ext_shortcodes_disable_shortcodes', '_filter_ssd_disable_default_shortcodes');

	endif;


/**
*  ACF Paths
*/

function fw_ssd_acf_settings_path( $path ) {
	$path = get_template_directory() . '/inc/includes/acf/';
	return $path;
}
add_filter('acf/settings/path', 'fw_ssd_acf_settings_path');


function fw_ssd_acf_settings_dir( $dir ) {
	$dir = get_template_directory_uri() . '/inc/includes/acf/';
	return $dir;
}
add_filter('acf/settings/dir', 'fw_ssd_acf_settings_dir');

/**
*  ACF Save JSON
*/

function _filter_ssd_acf_json_save_point( $path ) {

    $path = get_template_directory() . '/acf-json';
    return $path;
    
}

add_filter('acf/settings/save_json', '_filter_ssd_acf_json_save_point');

/**
*  ACF Load JSON
*/

function _filter_ssd_acf_json_load_point( $paths ) {

	unset($paths[0]);
	$paths[] = get_stylesheet_directory() . '/acf-json';
	return $paths;

}

add_filter('acf/settings/load_json', '_filter_ssd_acf_json_load_point');

/**
*  ACF Localization
*/

function _filter_ssd_acf_localization() {
	return 'couponhut';
}

add_filter('acf/settings/l10n_textdomain', '_filter_ssd_acf_localization');


/**
*  ACF Geolocation Saving
*/

function _action_ssd_save_geolocation_meta() {
	global $post;
	fw_ssd_save_post_geolocation($post->ID);

	$all_countries = fw_ssd_get_all_countries();
	set_transient('ssd_all_countries', $all_countries, 0);

	$all_locations = fw_ssd_get_all_locations();
	set_transient('ssd_all_locations', $all_locations, 0);

}

add_action('acf/save_post', '_action_ssd_save_geolocation_meta', 20);

/**
*  ACF Geolocation Save All Posts
*/

function _action_ssd_all_posts_save_geolocation_meta() {

	if ( get_option('all_posts_geo_saved') != 'yes' ) {

		$args = array(
			'post_type' => 'deal',
			'posts_per_page' => -1
			);

		$deals_query = new WP_Query($args);

		if ($deals_query->have_posts()) : while ($deals_query->have_posts()) : $deals_query->the_post();

		fw_ssd_save_post_geolocation(get_the_ID());

		endwhile; endif;

		wp_reset_postdata();

		$all_countries = fw_ssd_get_all_countries();
		set_transient('ssd_all_countries', $all_countries, 0);

		$all_locations = fw_ssd_get_all_locations();
		set_transient('ssd_all_locations', $all_locations, 0);

		update_option( 'all_posts_geo_saved', 'yes' );
	}

	
}


add_action('after_setup_theme', '_action_ssd_all_posts_save_geolocation_meta', 20);


/**
*  ACF Show in Admin
*/

add_filter('acf/settings/show_admin', '__return_false');

/**
*  ACF Show Updates
*/

add_filter('acf/settings/show_udates', '__return_false');


/**
*  Unyson Icon Select Field
*/

function _action_ssd_include_custom_option_types() {
    require_once get_template_directory() . '/inc/includes/option-types/icon-select/class-fw-option-type-icon-select.php';
}
add_action('fw_option_types_init', '_action_ssd_include_custom_option_types');


/**
*  Google Fonts Link in Header
*/

if(!function_exists('_action_ssd_process_google_fonts')) {
	function _action_ssd_process_google_fonts()
	{
		$include_from_google = array();
		$google_fonts = fw_get_google_fonts();

		$body_font = fw_get_db_settings_option('body_font');
		$heading_font = fw_get_db_settings_option('heading_font');

        // if is google font
		if( isset($google_fonts[$body_font['family']]) ){
			$include_from_google[$body_font['family']] =  $google_fonts[$body_font['family']];
		}

		if( isset($google_fonts[$heading_font['family']]) ){
			$include_from_google[$heading_font['family']] =  $google_fonts[$heading_font['family']];
		}

		$google_fonts_links = fw_ssd_get_remote_fonts($include_from_google);
        // set a option in db for save google fonts link
		update_option( 'fw_ssd_google_fonts_link', $google_fonts_links );
	}
	add_action('fw_settings_form_saved', '_action_ssd_process_google_fonts', 999, 2);
}

/**
*  Print Google Fonts link
*/
if (!function_exists('_action_ssd_print_google_fonts_link')) :
	function _action_ssd_print_google_fonts_link() {
		$google_fonts_link = get_option('fw_ssd_google_fonts_link', '');
		if($google_fonts_link != ''){
			echo $google_fonts_link;
		}
	}
	add_action('wp_head', '_action_ssd_print_google_fonts_link');
endif;


/**
 *  Custom Excerpt More
 */

function _filter_ssd_excerpt_more( $more ) {
	return '...';
}
add_filter('excerpt_more', '_filter_ssd_excerpt_more');


/**
*  Comment Avatar Class
*/

function _filter_ssd_avatar_css($class) {
	$class = str_replace("class='avatar", "class='avatar media-object", $class) ;
	return $class;
}
add_filter('get_avatar','_filter_ssd_avatar_css');

/**
*  Search blog posts only
*/

function _filter_ssd_search_blog_posts($query) {
	if ( ($query->is_search) && get_query_var('post_type') != 'deal' ) {
		$query->set('post_type', 'post');
	}
	return $query;
}

add_filter('pre_get_posts','_filter_ssd_search_blog_posts');

/**
*  Custom Post Type Search Page
*/

function _fitler_ssd_cpt_search_page($template) {    
	global $wp_query;
	$post_type = get_query_var('post_type');

	if ( $wp_query->is_search && locate_template( 'search-' . $post_type . '.php' ) ) {
		return locate_template( 'search-' . $post_type . '.php' );
	}

	return $template; 
}
add_filter('template_include', '_fitler_ssd_cpt_search_page');




function _filter_ssd_alter_search_deals($query) {
	if ( ($query->is_search) && get_query_var('post_type') == 'deal' ) {
		
		$query->set('post_type', 'post');

	}
	return $query;
}

// add_filter('pre_get_posts','_filter_ssd_alter_search_deals');




/**
*  Subscription Widget
*/

add_action('wp_ajax__action_fw_ssd_mailchimp_widget', '_action_fw_ssd_mailchimp_widget');
add_action('wp_ajax_nopriv__action_fw_ssd_mailchimp_widget', '_action_fw_ssd_mailchimp_widget');

if ( !function_exists( '_action_fw_ssd_mailchimp_widget' ) ) {
	function _action_fw_ssd_mailchimp_widget() { 

		$api_key = fw_ssd_get_option('mailchimp_api_key') ? fw_ssd_get_option('mailchimp_api_key') : false;
		$list_id = fw_ssd_get_option('mailchimp_list_id') ? fw_ssd_get_option('mailchimp_list_id') : false;

		if ( !$api_key || !$list_id ) {
			if ( current_user_can( 'edit_theme_options' ) ) {
				$error_msg = esc_html__('Mailchimp API Key or List ID are not set.', 'couponhut');
			} else { 
				$error_msg = esc_html__( "Something went wrong. We couldn't sign you up.", 'couponhut');
			}
			echo '<div class="response-error">' . $error_msg .'</div>';
		}
		else {
			$email = strtolower($_POST['email']);
			
			$Mailchimp = new Mailchimp( $api_key );
			$result = $Mailchimp->call('lists/subscribe', array(
				'id'                => $list_id,
				'email'             => array('email'=> $email ),
				'double_optin'      => false,
				'update_existing'   => false,
				'replace_interests' => false,
				'send_welcome'      => true,
				));

			if( !empty( $result->status ) && 'error' == $result->status ) {
				$error_msg = '';
				if( 'List_AlreadySubscribed' == $result->name)
					$error_msg = esc_html__('Oops! This email address is already subscribed!', 'couponhut');
				elseif( 'Email_NotExists' == $result->name )
					$error_msg = esc_html__('Email address does not exist', 'couponhut');
				elseif( 'List_DoesNotExist' == $result->name )
					$error_msg = current_user_can( 'edit_theme_options' ) ? esc_html__('List does not exist, please choose a valid list.', 'couponhut') : esc_html__( "Something went wrong. We couldn't sign you up.", 'couponhut');
				else
					$error_msg = esc_html__( "Something went wrong. We couldn't sign you up.", 'couponhut');
				// An error ocurred, return error message	
				echo '<div class="alert alert-danger">' . $error_msg .'</div>';

			}else{
				echo '<div class="alert alert-success">' . esc_html__( 'Success! You have signed up.', 'couponhut' ) . '</div>';
				
			}
		}
		die();

	}
}

/**
 * This plugin will fix the problem where next/previous of page number buttons are broken on list
 * of posts in a category when the custom permalink string is:
 * /%category%/%postname%/ 
 * The problem is that with a url like this:
 * /categoryname/page/2
 * the 'page' looks like a post name, not the keyword "page"
 */
function remove_page_from_query_string($query_string)
{ 	
    if (isset($query_string['name']) && $query_string['name'] == 'page' && isset($query_string['page'])) {
        unset($query_string['name']);
        // 'page' in the query_string looks like '/2', so i'm spliting it out
        list($delim, $page_index) = split('/', $query_string['page']);
        $query_string['paged'] = $page_index;
    }   
    return $query_string;
}
add_filter('request', 'remove_page_from_query_string');

// following are code adapted from Custom Post Type Category Pagination Fix by jdantzer
function fix_category_pagination($qs){
	$dummy_query = new WP_Query();  // the query isn't run if we don't pass any query vars
    $dummy_query->parse_query( $qs );

	if( $dummy_query->is_tax() && isset($qs['paged'])){
		$qs['post_type'] = get_post_types($args = array(
			'public'   => true,
			'_builtin' => false
		));
		array_push($qs['post_type'],'post');
	}
	return $qs;
}
add_filter('request', 'fix_category_pagination');

/**
*  Front End Deal Submit
*/

function _action_ssd_acf_submit_deal( $post_id ) {

	if( empty($_POST['acf']) ) {
		return;
	}

    if ( !isset($_POST['deal_submit']) ) {
    	return;
    }

	$fields = $_POST['acf'];

	$post = array(
	    'ID'           => $post_id,
	    'post_title'   => $_POST['post_title'],
	    'post_content'   => $_POST['post_content']
	);

	// Update the Post
	wp_update_post( $post );

	// Deal Information
	$title = $_POST['post_title'];
	$content = $_POST['post_content'];
	$deal_type = $fields['field_5519756e0f4e2'];
	$deal_summary = $fields['field_554f8e55b6dd8'];
	$coupon_code = $fields['field_551976780f4e4'];
	$discount_value = $fields['field_55016e0911ba1'];
	$url = $fields['field_55016e3011ba3'];
	$expiring_date = $fields['field_55016e3d11ba4'];

	$admin_page = admin_url( 'edit.php?post_status=pending&post_type=deal' );

	$message = __( 'New deal has been submited. Here are the details:', 'couponhut' )."\n\n
".__( 'Deal Name:', 'couponhut' )." {$title}\n\n
".__( 'Deal Type:', 'couponhut' )." {$deal_type}\n\n
".__( 'Deal Summary:', 'couponhut' )." {$deal_summary}\n\n
".__( 'Coupon Code:', 'couponhut' )." {$coupon_code}\n\n
".__( 'Discount:', 'couponhut' )." {$discount_value}\n\n
".__( 'Content:', 'couponhut' )." {$content}\n\n
".__( 'Deal URL:', 'couponhut' )." {$url}\n\n
".__( 'Expiring Date:', 'couponhut' )." {$expiring_date}\n\n
".__( 'Please visit your admin dashboard to approve it - ', 'couponhut' )." {$admin_page}";

	$email_to = fw_ssd_get_option('new-deal-email');

	wp_mail( $email_to, __( 'New Deal Submited', 'couponhut' ), $message );
   
}
add_action( 'acf/save_post', '_action_ssd_acf_submit_deal', 20 );