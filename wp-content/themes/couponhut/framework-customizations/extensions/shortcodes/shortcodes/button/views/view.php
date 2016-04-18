<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php 
$btn_class = '';

if ( $atts['color'] ) {

	$btn_class .= 'btn-color';

	if ( $atts['color'] != 'default' ) {
		$btn_class .= ' btn-' . $atts['color'];
	}
	
}

?>
<a href="<?php echo esc_url($atts['link']) ?>" target="<?php echo esc_attr($atts['target']) ?>" class="btn <?php echo esc_attr($btn_class); ?>">
	<span><?php echo wp_kses_post($atts['label']); ?></span>
</a>