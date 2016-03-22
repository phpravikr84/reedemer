<?php 
function fw_ssd_custom_styles(){
  $logo_padding = esc_attr(fw_ssd_get_option('top_logo_padding'));
  $color_main = esc_attr(fw_ssd_get_option('color-main'));
  $color_secondary = esc_attr(fw_ssd_get_option('color-secondary'));
  $color_fill = esc_attr(fw_ssd_get_option('color-fill'));
  $color_secondary_light = esc_attr(fw_ssd_get_option('color-secondary-light'));
?>

<style type="text/css">
/* Logo */ 
.navigation-wrapper .site-logo {
	padding: <?php echo $logo_padding; ?>;
}

/* Main Color */

.main-navigation a:hover {
	color: <?php echo $color_main; ?>; 
}
.main-navigation .current-menu-item > a {
	color: <?php echo $color_main; ?>;
}
.menu-item-has-children > a > i {
	color: <?php echo $color_main; ?>;
}
.single-deal-expires-text {
	color: <?php echo $color_main; ?>; 
}
.single-deal-countdown i {
	color: <?php echo $color_main; ?>; 
}
.single-post-meta i {
	background-color: <?php echo $color_main; ?>;
}
.single-taxonomy-icon {
	color: <?php echo $color_main; ?>; 
}
.featured-deals-slider .jscountdown-wrap {
	border-bottom: 2px solid <?php echo $color_main; ?>;
}
.discount-ribbon {
	background-color: <?php echo $color_main; ?>;
}
.dropdown-menu > li > a:focus,
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus,
.dropdown-menu > li > a:hover,
.dropdown-menu > li > a:focus, .dropdown-menu > li > a:hover {
	background-color: <?php echo $color_main; ?>;
}
.list-menu-title i {
	color: <?php echo $color_main; ?>;
}
.list-menu > li > a {
	border-left: 0 solid <?php echo $color_main; ?>;
}
.list-menu > li > a:hover, .list-menu > li > a:focus {
	border-left: 4px solid <?php echo $color_main; ?>;
}
.deal-prices .deal-save-price span {
	color: <?php echo $color_main; ?>;
}
.card-deal-meta-expiring .jscountdown-wrap {
	color: <?php echo $color_main; ?>;
}
.footer .tagcloud a {
	background-color: <?php echo $color_main; ?>;
}
.footer .tagcloud a:after {
	border-color: transparent transparent transparent <?php echo $color_main; ?>;
}
.ui-slider-handle {
	background-color: <?php echo $color_main; ?>;
}
.daily-deal-widget-wrapper .jscountdown-wrap {
	border-bottom: 2px solid <?php echo $color_main; ?>;
}
.daily-deal-title a:hover {
	color: <?php echo $color_main; ?>; 
}

/* Secondary Color */

a:hover, a:active {
	color: <?php echo $color_secondary; ?>;
}
::-moz-selection {
	background: <?php echo $color_secondary; ?>;
}
::selection {
	background: <?php echo $color_secondary; ?>;
}
.input-group-btn {
	background-color: <?php echo $color_secondary; ?>; 
}
.single-taxonomy-website i {
	color: <?php echo $color_secondary; ?>;
}
.header-screen-search input[type="text"] {
	border-bottom: 2px solid <?php echo $color_secondary; ?>;
}
.btn:hover, input[type="submit"]:hover,
input[type="button"]:hover, .btn:active, input[type="submit"]:active,
input[type="button"]:active, .btn.current, input.current[type="submit"],
input.current[type="button"], button[type='submit']:hover, button[type='submit']:active, button[type='submit'].current, input[type='submit']:hover, input[type='submit']:active, input[type='submit'].current {
	background: <?php echo $color_secondary; ?>;
	border: 4px solid <?php echo $color_secondary; ?>; 
}
.btn.btn-social:hover > i, input.btn-social[type="submit"]:hover > i,
input.btn-social[type="button"]:hover > i {
	color: <?php echo $color_secondary; ?>; 
}
.btn.btn-color, input.btn-color[type="submit"],
input.btn-color[type="button"], .btn.btn-color:focus, input.btn-color[type="submit"]:focus,
input.btn-color[type="button"]:focus, button[type='submit'], button[type='submit']:focus, input[type='submit'], input[type='submit']:focus {
	background: <?php echo $color_secondary; ?>;
	border: 4px solid <?php echo $color_secondary; ?>; 
}
.highlight {
	background-color: <?php echo $color_secondary; ?>;
}
blockquote {
	border-color: <?php echo $color_secondary; ?>;
}
.fw-accordion .fw-accordion-title.ui-state-active {
	border-bottom: 2px solid <?php echo $color_secondary; ?>; 
}
.fw-tabs-container .fw-tabs ul {
	border-bottom: 2px solid <?php echo $color_secondary; ?>; 
}
.fw-tabs-container .fw-tabs ul li.ui-state-active {
	background: <?php echo $color_secondary; ?>; 
}
.see-more i {
	color: <?php echo $color_secondary; ?>;
}
.see-more:hover span {
	color: <?php echo $color_secondary; ?>;
}
.btn-dropdown[aria-expanded="true"], .btn-dropdown[aria-expanded="true"]:hover {
	background-color: <?php echo $color_secondary; ?>;
}
.list-menu .number-counter {
	background-color: <?php echo $color_secondary; ?>;
}
.modal-body {
	border-bottom: 4px dashed <?php echo $color_secondary; ?>; 
}
.btn-card-deal {
	background-color: <?php echo $color_secondary; ?>;
}
.card-deal-categories a:hover {
	color: <?php echo $color_secondary; ?>; 
}
.grid-item h2 {
	color: <?php echo $color_secondary; ?>;
}
.sort-deals .btn-sort.current {
	border: 2px solid <?php echo $color_secondary; ?>; 
}
.sort-deals .btn-sort:hover {
	background-color: <?php echo $color_secondary; ?>; 
}
.page-numbers:hover, .page-numbers:focus, .page-numbers:active, .page-numbers.current {
	background-color: <?php echo $color_secondary; ?>;
}
.download-deal-link a {
	border-bottom: 1px solid <?php echo $color_secondary; ?>;
}
.days-slider-numbers {
	color: <?php echo $color_secondary; ?>;
}
.widget_deal_categories .overlay-color, .widget_deal_companies .overlay-color {
	background-color: <?php echo $color_secondary; ?>; 
}
.widget_twitter a {
	color: <?php echo $color_secondary; ?>; 
}

/* Color Fill */

.main-navigation .sub-menu a:hover {
	color: <?php echo $color_fill; ?>; 
}
.main-navigation .sub-menu .current-menu-item > a {
	color: <?php echo $color_fill; ?>; 
}
.box-icon i {
	background-color: <?php echo $color_fill; ?>; 
}
.poster-block a:before {
	border: 1px solid <?php echo $color_fill; ?>;
}
.featured-deals-slider .deal-slide-categories {
	color: <?php echo $color_fill; ?>; 
}
.post-meta-date i {
	color: <?php echo $color_fill; ?>; 
}
.overlay-color {
	background-color: <?php echo $color_fill; ?>; 
}
.tags-list a:hover, .tagcloud a:hover {
	background-color: <?php echo $color_fill; ?>; 
}
.tags-list a:hover:after, .tagcloud a:hover:after {
	border-color: transparent transparent transparent <?php echo $color_fill; ?>; 
}
.widget > ul li:before {
	color: <?php echo $color_fill; ?>;
}
.widget-title {
	border-left: 3px solid <?php echo $color_fill; ?>; 
}
.widget-list a:hover {
	color: <?php echo $color_fill; ?>; 
}
.widget-list .widget-list-number-counter {
	background-color: <?php echo $color_fill; ?>; 
}
.widget_twitter li:before {
	color: <?php echo $color_fill; ?>;
}

/* Main Color Light */
.btn.btn-color:hover, input.btn-color[type="submit"]:hover,
input.btn-color[type="button"]:hover, button[type='submit']:hover, input[type='submit']:hover {
  background-color: <?php echo $color_secondary_light; ?>;
  border: 4px solid <?php echo $color_secondary_light; ?>;
}

/* Typography */

<?php
$body_font = fw_ssd_get_option('body_font');
$heading_font = fw_ssd_get_option('heading_font');

?>
body,
.days-slider-days-text {
	<?php echo fw_ssd_typography_css($body_font) ?>
}

h1,
h2,
h3,
h4,
h5,
h6,
.main-navigation,
.days-slider-numbers {
	<?php echo fw_ssd_typography_css($heading_font) ?>
}

/* Custom CSS */

<?php echo esc_attr(fw_ssd_get_option('custom-css')); ?>

</style>


<?php
}

add_action( 'wp_head', 'fw_ssd_custom_styles', 100 );

?>