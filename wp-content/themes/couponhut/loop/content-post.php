<article class="single-post-wrapper">

	<?php if ( has_post_thumbnail() ) : ?>

	<div class="single-post-featured-image">
		<?php the_post_thumbnail( 'ssd_single-post-image' ); ?>
	</div><!-- single-post-featured-image -->

	<?php endif; ?>

	<div class="single-post-content">
		<?php 
		if ( is_single() ) { ?>
			<h1 class="single-post-title"><?php the_title(); ?></h1>
		<?php
		} else { ?>
			<h1 class="single-post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
		<?php
		}
		?>
			
		<div class="single-post-meta">
			<?php
			$terms = wp_get_post_terms( $post->ID, 'category' );
			$terms_html_array = array();

			foreach($terms as $term) {
				$term_name = $term->name;
				$term_link = get_term_link( $term->slug, $term->taxonomy );
				array_push($terms_html_array, "<a href={$term_link} class='italics' >{$term_name}</a>");
			}

			$terms_string = implode(', ',$terms_html_array);
			?>
			<i class="icon-Calendar"></i><span class="single-post-meta-value"><?php echo get_the_date(get_option('date_format')); ?></span>
			<i class="icon-Male"></i><span class="single-post-meta-value"><?php the_author(); ?></span>
			<i class="icon-Folder"></i><span class="single-post-meta-value"><?php echo wp_kses_post($terms_string); ?></span>
			<i class="icon-Speach-Bubble"></i><span class="single-post-meta-value"><?php comments_popup_link(esc_html__('0 Comments', 'couponhut'), esc_html__('1 Comment', 'couponhut'), esc_html__('% Comments', 'couponhut'), 'comments-number'); ?></span>
		</div>
		<div class="single-post-main-content">
			<?php 
				if ( fw_ssd_get_option('post-content-switch') == 'excerpt' ) {
					the_excerpt();	
				} else {
					the_content();
				}
			 ?>
		</div>
		<?php

		wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'unyson' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );

		if ( has_tag() ): ?>

		<div class="post-meta tags-list">
			<?php the_tags('',''); ?>
		</div><!-- end post-meta -->

		<?php endif; ?>
		
	</div><!-- end single-post-content -->
				
</article>