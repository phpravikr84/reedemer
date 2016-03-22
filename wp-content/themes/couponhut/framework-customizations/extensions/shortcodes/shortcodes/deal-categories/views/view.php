<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<h4 class="list-menu-title"><?php esc_html_e('Categories', 'couponhut'); ?><i class="fa fa-chevron-down"></i></h4>

<?php 
$hidden_cats = !empty($atts['hide_categories']) ? $atts['hide_categories'] : array();

$term_args = array( 
	'hide_empty' => 0 
	);

if ( $hidden_cats ){
	$term_args['exclude_tree'] = $hidden_cats;
}

if ( !empty($atts['show_parents_only']) ) {
	$term_args['parent'] = 0;
}

$deal_cats = get_terms('deal_category', $term_args );

 if ( ! empty( $deal_cats ) && ! is_wp_error( $deal_cats ) ){
	echo '<ul class="nav nav-stacked list-menu">';
	foreach ( $deal_cats as $deal_cat ) {
		if ( taxonomy_exists('deal_category') ) {
			
			echo '<li>';

			if ( get_field('icon', "{$deal_cat->taxonomy}_{$deal_cat->term_id}") ) {
				$icon_class = get_field('icon', "{$deal_cat->taxonomy}_{$deal_cat->term_id}");
				echo '<a href="' . get_term_link($deal_cat) . '"><i class="' . $icon_class . '"></i><span>' . $deal_cat->name . '<span class="number-counter">' . $deal_cat->count . '</span></span></a>';
			} else {
				echo '<a href="' . get_term_link($deal_cat) . '"><span>' . $deal_cat->name . '<span class="number-counter">' . $deal_cat->count . '</span></span></a>';
			}	
			
			echo '</li>';
	}
		
	}
	echo '</ul>';
}
?>

