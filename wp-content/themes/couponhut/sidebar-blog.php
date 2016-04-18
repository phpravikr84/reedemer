<?php if ( is_active_sidebar( 'sidebar-blog' ) ) : ?>

    <div class="col-sm-4 col-md-3 <?php echo fw_ssd_get_option('sidebar-switch') == 'left' ? 'col-sm-pull-8 col-md-pull-9' : '' ?>">
		<div class="sidebar">
			 <?php dynamic_sidebar( 'sidebar-blog' ); ?>
		</div><!-- end sidebar -->	
	</div><!-- end col-sm-4 col-md-3 -->

<?php endif; ?>