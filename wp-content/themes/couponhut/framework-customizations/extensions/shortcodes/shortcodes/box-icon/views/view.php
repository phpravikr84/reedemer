<?php if (!defined('FW')) die( 'Forbidden' ); ?>

<div class="header-bar">
	
	<?php foreach ($atts['icon_box'] as $iconbox) : ?>
		
		<div class="box-icon">
			<i class="<?php echo esc_attr($iconbox['icon'])?>"></i>
			<div class="box-icon-content"><?php echo wp_kses_post($iconbox['icon_content'])?></div>
		</div>
		
	<?php endforeach; ?>
</div>