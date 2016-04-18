<?php
// Flush rewrite rules on activation
register_uninstall_hook(__FILE__, 'ssd_cpt_delete_plugin_options');
register_activation_hook( __FILE__, 'ssd_cpt_activation' );

add_action('admin_init', 'ssd_cpt_init' );
add_action('admin_menu', 'ssd_cpt_options_page');

/**
*  Delete options table entries ONLY when plugin deactivated AND deleted
*/
function ssd_cpt_delete_plugin_options() {
	delete_option('ssd_cpt_display_options');
}

/**
*  Flush rewrite rules on activation
*/
function ssd_cpt_activation() {
	flush_rewrite_rules(true);
}

/**
*  Init plugin options to white list our options
*/
function ssd_cpt_init(){
	register_setting( 'ssd_cpt_plugin_display_options', 'ssd_cpt_display_options', 'ssd_cpt_validate_display_options' );
}

/**
*  Add menu page
*/
function ssd_cpt_options_page() {
	$theme = wp_get_theme();
	add_submenu_page( 'edit.php?post_type=deal', 'Deal Post Type Options', 'Deal Post Type Options', 'manage_options', __FILE__, 'ssd_cpt_render_form' );
}

/**
*  Render the Plugin options form
*/
function ssd_cpt_render_form() { 
	$theme = wp_get_theme();
?>
	
	<div class="wrap">
	
		<h2><?php esc_html_e(' Deal Post Type Options', 'subsolar'); ?></h2>
		<b>After making changes, be sure to visit your <a href="options-permalink.php">Permalink Settings</a> and click the 'Save Changes' to refresh your permalinks, otherwise your links may not work properly.</b>
		
		<div class="wrap">
		
			<form method="post" action="options.php">
				<?php settings_fields('ssd_cpt_plugin_display_options'); ?>
				<?php $displays = get_option('ssd_cpt_display_options'); ?>
				
				<table class="form-table">
					<tr valign="top">
						<td>
							<label>Enter the URL slug you want to use for this post type. 
							<br/><b>DO NOT: use numbers, spaces, capital letters or special characters.</b><br/><br />
							<input type="text" size="30" name="ssd_cpt_display_options[deal_slug]" value="<?php echo $displays['deal_slug']; ?>" placeholder="deal" /><br />
							 <br/>
							 <b>Example:</b> Entering 'deal' will result in www.website.com/deal becoming the URL to your deal.<br />
							<b>After making changes, be sure to visit your <a href="options-permalink.php">Permalink Settings</a> and click the 'Save Changes' to refresh your permalinks, otherwise your links may not work properly.</b></label>			 
						</td>
					</tr>
				</table>
				<hr>
				<table class="form-table">
					<tr valign="top">
						<td>
							<label>Enter the URL slug you want to use for the deal post type <b>deal category</b> taxonomy. 
							<br/><b>DO NOT: use numbers, spaces, capital letters or special characters.</b><br/><br />
							<input type="text" size="30" name="ssd_cpt_display_options[deal_category_slug]" value="<?php echo $displays['deal_category_slug']; ?>" placeholder="deal_category" /><br />
							 <br/>
							 <b>Example:</b> Entering 'deal_category' will result in www.website.com/deal_category becoming the URL to your deal category.<br />
							<b>After making changes, be sure to visit your <a href="options-permalink.php">Permalink Settings</a> and click the 'Save Changes' to refresh your permalinks, otherwise your links may not work properly.</b></label>			 
						</td>
					</tr>
				</table>
				<hr>
				<table class="form-table">
					<tr valign="top">
						<td>
							<label>Enter the URL slug you want to use for the deal post type <b>deal category</b> taxonomy. 
							<br/><b>DO NOT: use numbers, spaces, capital letters or special characters.</b><br/><br />
							<input type="text" size="30" name="ssd_cpt_display_options[deal_company_slug]" value="<?php echo $displays['deal_company_slug']; ?>" placeholder="deal_company" /><br />
							 <br/>
							 <b>Example:</b> Entering 'deal_company' will result in www.website.com/deal_company becoming the URL to your deal company.<br />
							<b>After making changes, be sure to visit your <a href="options-permalink.php">Permalink Settings</a> and click the 'Save Changes' to refresh your permalinks, otherwise your links may not work properly.</b></label>			 
						</td>
					</tr>
				</table>
				
				<?php submit_button('Save Options'); ?>
				
			</form>
		
		</div>

	</div>
<?php 
}

/**
 * Validate inputs for post type options form
 */
function ssd_cpt_validate_display_options($input) {
	
	if( get_option('ssd_cpt_display_options') ){
		
		$displays = get_option('ssd_cpt_display_options');
		
		foreach ($displays as $key => $value) {
			if(isset($input[$key])){
				$input[$key] = wp_filter_nohtml_kses($input[$key]);
			}
		}
	
	}
	return $input;
	
}

/**
*  Register Deals Post Type
*/
function ssd_register_deal() {

	$displays = get_option('ssd_cpt_display_options');

	if( $displays['deal_slug'] ){ $slug = $displays['deal_slug']; } else { $slug = 'deal'; }

	$labels = array(
		'name'               => _x( 'Deals', 'post type general name', 'subsolar' ),
		'singular_name'      => _x( 'Deal', 'post type singular name', 'subsolar' ),
		'menu_name'          => _x( 'Deals', 'admin menu', 'subsolar' ),
		'name_admin_bar'     => _x( 'Deals', 'add new on admin bar', 'subsolar' ),
		'add_new'            => _x( 'Add New', 'deal', 'subsolar' ),
		'add_new_item'       => __( 'New Deal', 'subsolar' ),
		'new_item'           => __( 'New Deal', 'subsolar' ),
		'edit_item'          => __( 'Edit Deal', 'subsolar' ),
		'view_item'          => __( 'View Deal', 'subsolar' ),
		'all_items'          => __( 'All Deals', 'subsolar' ),
		'search_items'       => __( 'Search Deals', 'subsolar' ),
		'not_found'          => __( 'No deals found.', 'subsolar' ),
		'not_found_in_trash' => __( 'No deals found in Trash.', 'subsolar' )
		);

	$args = array(
		'labels'              => $labels,
		'public'              => true,
		'exclude_from_search' => true,
		'show_in_nav_menus'   => true,
		'show_in_menu'        => true,
		'query_var'           => true,
		'hierarchical'        => false,
		'menu_position'       => null,
		'supports'            => array( 'comments', 'title', 'editor' ),
		'has_archive'         => false,
		'rewrite' => array( 'slug' => $slug ),
		);

	register_post_type( 'deal', $args );

}

function ssd_create_deal_taxonomies(){

	$displays = get_option('ssd_cpt_display_options');

	if( $displays['deal_category_slug'] ){ $deal_category_slug = $displays['deal_category_slug']; } else { $deal_category_slug = 'deal_category'; }
	if( $displays['deal_company_slug'] ){ $deal_company_slug = $displays['deal_company_slug']; } else { $deal_company_slug = 'deal_company'; }

	$categories_labels = array(
		'name'              => _x( 'Deal Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Deal Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Deal Categories', 'subsolar' ),
		'all_items'         => __( 'All Deal Categories', 'subsolar' ),
		'parent_item'       => __( 'Parent Deal Category', 'subsolar' ),
		'parent_item_colon' => __( 'Parent Deal Category:', 'subsolar' ),
		'edit_item'         => __( 'Edit Deal Category', 'subsolar' ),
		'update_item'       => __( 'Update Deal Category', 'subsolar' ),
		'add_new_item'      => __( 'Add Deal Category', 'subsolar' ),
		'new_item_name'     => __( 'New Deal Category Name', 'subsolar' ),
		'menu_name'         => __( 'Deal Categories', 'subsolar' ),
		);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $categories_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite' => array( 'slug' => $deal_category_slug ),
		);

	register_taxonomy('deal_category', array ('deal'), $args);

	$categories_labels = array(
		'name'              => _x( 'Companies', 'taxonomy general name' ),
		'singular_name'     => _x( 'Company', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Companies', 'subsolar' ),
		'all_items'         => __( 'All Companies', 'subsolar' ),
		'edit_item'         => __( 'Edit Company', 'subsolar' ),
		'update_item'       => __( 'Update Company', 'subsolar' ),
		'add_new_item'      => __( 'Add Company', 'subsolar' ),
		'new_item_name'     => __( 'New Company Name', 'subsolar' ),
		'menu_name'         => __( 'Companies', 'subsolar' ),
		);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $categories_labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite' => array( 'slug' => $deal_company_slug ),
		);

	register_taxonomy('deal_company', array ('deal'), $args);
}
