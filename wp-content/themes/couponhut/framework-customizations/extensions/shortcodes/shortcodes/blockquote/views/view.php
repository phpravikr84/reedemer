<?php if (!defined('FW')) die( 'Forbidden' ); ?>
<blockquote>
	<p><?php echo wp_kses_post($atts['content']) ?></p>
	<footer><cite><?php echo wp_kses_post($atts['cite']) ?></cite></footer>
</blockquote>