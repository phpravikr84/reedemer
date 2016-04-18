<?php 
$ajax_class = fw_ssd_get_option('ajax-switch') ? 'is-ajax-sort-deals' : '';
?>
<div class="sort-deals <?php echo $ajax_class; ?>">
	<?php 

	$filter_items = array(
		'rating' => esc_html__('Most appreciated', 'couponhut'),
		'expiring' => esc_html__('Expiring soon', 'couponhut'),
		'popular' => esc_html__('Popular', 'couponhut'),
		'newest' => esc_html__('Newest', 'couponhut'),
		);

	$filter_items_final = array(); // will be filled with only the selected sorting tabs from the option panel

	$default_sort = fw_ssd_get_option('default-sort-deals-tab');

	foreach ($filter_items as $key => $value) {
		if ( in_array($key, fw_ssd_get_option('sort-deals-tab')) ) {
			$filter_items_final[$key] = $value;
		}
	}

	/* Print Sorting Tabs */

	foreach ($filter_items_final as $key => $value) :

		if ( isset($_GET['sort']) ) {

			if ( $_GET['sort'] == $key ) {
				$filter_class = 'btn-sort current';
			} else {
				$filter_class = 'btn-sort';
			}

		} elseif ( $key == $default_sort ) {
			$filter_class = 'btn-sort current';
		} else {
			$filter_class = 'btn-sort';
		}
		?>
		<a href="<?php echo add_query_arg('sort', $key);?>" class="<?php echo $filter_class; ?>"><?php echo $value?></a>
	<?php
	endforeach;
	?>

</div><!-- end sort-deals -->