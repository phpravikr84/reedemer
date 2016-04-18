<?php

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not load this page directly. Thanks!');

if ( post_password_required() ) { ?>
<p class="password-protected"><?php esc_html_e("This post is password protected. Enter the password to view comments.",'couponhut'); ?></p>
<?php
return;
}
?>

<?php if ( have_comments() ) :

	/* Display Comments */
	if ( ! empty($comments_by_type['comment']) ) : ?>

		<div class="commentslist-container bg-color">

			<h3 id="comments"><?php esc_html_e('Recent Comments', 'couponhut'); ?></h3>

			<ul class="commentlist">
				<?php wp_list_comments('type=comment&callback=fw_ssd_comments'); ?>
			</ul>

		</div>

		<?php endif; // end display comments

		/* Display pings */
		if ( ! empty($comments_by_type['pings']) ) : ?>
		<h3 id="pings">Trackbacks and Pingbacks</h3>

		<ul class="pinglist">
			<?php wp_list_comments('type=pings&callback=sdesigns_list_pings'); ?>
		</ul>
		<?php endif; // end display pings

		/* Pagination check */
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>

		<div class="page-nav">
			<span class="nav-prev"><?php previous_comments_link( __("Older comments", 'couponhut' ) ) ?></span>
			<span class="nav-next"><?php next_comments_link( __("Newer comments", 'couponhut' ) ) ?></span>
		</div>

		<?php endif; // end pagination check

		/* Check if comments are closed */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'couponhut' ) ) : ?>

		<!-- If comments are closed. -->
		<p class="alert alert-info"><?php esc_html_e("Comments are closed", 'couponhut'); ?>.</p>

	<?php endif;


	if ( comments_open() ) :

		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'fields' => apply_filters( 'comment_form_default_fields', array(

			'author' =>
			'<p class="comment-form-author col-sm-12 col-md-4"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
			'" size="30"' . $aria_req . ' placeholder="' .
			( $req ? '*' : '' ) .
			' ' . __( 'Name', 'couponhut' ) . '" /></p>',

			'email' =>
			'<p class="comment-form-email col-sm-12 col-md-4"><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
			'" size="30"' . $aria_req . ' placeholder="' .
			( $req ? '*' : '' ) .
			' ' . __( 'Email', 'couponhut' ) . '" /></p>',

			'url' =>
			'<p class="comment-form-url col-sm-12 col-md-4">' .
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
			'" size="30" placeholder="' . __( 'Website', 'couponhut' ) . '" /></p>'
			)
		),

		'comment_field' => '<p class="comment-form-comment col-sm-12"><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true" placeholder="' . esc_html__('Comment', 'couponhut' ) . '"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'couponhut' ), wp_login_url( apply_filters( 'the_permalink', esc_url(get_permalink()) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'couponhut' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', esc_url(get_permalink()) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply' => esc_html__('Leave a Comment', 'couponhut'),
		'title_reply_to' => esc_html__('Leave a Reply to %s', 'couponhut'),
		'cancel_reply_link' => esc_html__('Cancel Reply', 'couponhut'),
		'label_submit' => esc_html__('Post Comment', 'couponhut')
		);

	comment_form($fields);











	endif; // if you delete this the sky will fall on your head ?>
