<?php
// Admin Send Deal Mail
$email_to = fw_ssd_get_option('new-deal-email');
// Allow deal submit without registration
$allow_no_reg = fw_ssd_get_option('member-submit-switch');

if ( function_exists('um_profile_id') || $allow_no_reg ) : 

	if ( function_exists('um_profile_id') && !um_profile_id() ) {
		wp_redirect(home_url('login/'));
		exit;
	}

if ( $email_to ) {
	acf_form_head();
}

/* Template Name: Submit Deal */
get_header();
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>

	<div class="container">

		<div class="row">

			<div class="col-sm-12">
				<?php if ( get_the_title() ) : ?>
					<div class="section-title-block">
						<h1 class="section-title"><?php esc_html_e('New Deal', 'couponhut') ?></h1>
					</div><!-- end section-title-block -->
				<?php endif;?>
			</div>

			<div class="col-sm-8">
				
				
				<?php
				if ( $email_to ) {

					ob_start(); ?>
					<div class="acf-hidden">
						<input type="hidden" name="deal_submit" size="30" id="deal_submit" autocomplete="off">
					</div>

					<?php
					$html_after_fields = ob_get_contents();
					ob_end_clean();

					ob_start(); ?>
					<div class="acf-field">
						<div class="acf-label">
							<label for="post_title"><?php esc_html_e('Title', 'couponhut'); ?></label for="post_title">
						</div>
						<div class="acf-input">
							<input type="text" name="post_title" size="30" id="post_title" autocomplete="off">
						</div>
					</div>

					<div class="acf-field">
						<div class="acf-label">
							<label for="post_content"><?php esc_html_e('Content', 'couponhut'); ?></label for="post_content">
						</div>
						<div class="acf-input">
							<textarea type="text" name="post_content" size="30" rows="8" id="post_content"></textarea>
						</div>
					</div>

					<?php
					$html_before_fields = ob_get_contents();
					ob_end_clean();
					$options = array(
						'post_id' => 'new_post',
						'new_post' => array(
							'post_type'   	 => 'deal',
							 'post_status'   => 'pending'
							),
						'html_before_fields' => $html_before_fields,
						'html_after_fields' => $html_after_fields,
						'uploader' => 'basic',
						'submit_value' => __("Create", 'couponhut'),
						'updated_message' => __("Your deal was submitted successfully! Please wait for it to be approved.", 'couponhut'),
						);
					acf_form($options);

				} else if( current_user_can( 'manage_options' ) ) { ?>
				
				<p><?php esc_html_e('Please enter an email in the "New Deal Email" field in the Theme Options Panel.', 'couponhut') ?></p>

				<?php
				} else { ?>

				<p><?php esc_html_e('No administrator email found. Please contact the owner of the website.', 'couponhut') ?></p>

				<?php
				}
				?>
			</div>

		</div>

	</div><!-- end container -->
	
</div><!-- end post -->

<?php get_footer(); ?>

<?php 
// Neiher "Ultimate Member" plugin or "deal submit without registration" is activated
else:
	get_header();
?>
	<div class="no-posts-wrapper">
		<h3><?php esc_html_e('Please Allow Deal Submit Without Registration from Theme Settings > Deals or leave it disabled and activate the Ultimate Member Plugin so that the theme can activate the user registration functionality.', 'couponhut'); ?></h3>
	</div>
<?php
get_footer();
exit;

endif;

?>