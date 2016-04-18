<form action="<?php echo esc_url(home_url('/')); ?>" method="get" role="search">
	<div class="input-group">
		<input type="text" name="s" class="form-control" placeholder="<?php esc_attr_e("Search Here", 'couponhut'); ?>">
		<span class="input-group-btn">
			<button type="submit" id="searchsubmit"><i class="fa fa-search"></i></button>
		</span>
	</div>
</form>