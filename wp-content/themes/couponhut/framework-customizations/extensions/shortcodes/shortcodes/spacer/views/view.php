<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<?php
$height = ( isset( $atts['height'] ) ) ? ' style="height: ' . esc_attr($atts['height']) . 'px"' : '';
?>

<div class="spacer"<?php echo $height; ?>></div>