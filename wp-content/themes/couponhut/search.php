<?php
get_header();
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('page-wrapper'); ?>>

	<div class="container">
		
		<div class="row">
			<div class="col-sm-8 col-md-9 <?php echo fw_ssd_get_option('sidebar-switch') == 'left' ? 'col-sm-push-4 col-md-push-3' : '' ?>">
				<?php if (have_posts()) : ?>

					<div class="section-title">
						<h3><?php esc_html_e('Search Results For: ', 'couponhut') ?><?php the_search_query(); ?></h3>
					</div>

				<?php while (have_posts()) : the_post(); ?>

				<article class="post-wrapper row cols-np">

					<div class="col-sm-4">
						<a href="<?php echo esc_url(get_permalink());?>">
							<div class="post-meta-date">
								<i class="icon-Calendar"></i>
								<?php echo get_the_date(); ?>
							</div>
							<div class="post-image">
								<?php the_post_thumbnail( 'ssd_blog-thumb' ); ?>
							</div><!-- end post-image -->
						</a>

					</div><!-- end col-sm-4 -->

					<div class="col-sm-8">
						<div class="post-content">
							<div class="post-title">
								<a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a>
							</div>
							<div class="post-meta">
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
								<i class="icon-Folder"></i><span class="post-meta-categories"><?php echo wp_kses_post($terms_string); ?></span>
								<i class="icon-Speach-Bubble"></i><span class="post-meta-comments"><?php comments_popup_link(esc_html__('0 Comments', 'couponhut'), esc_html__('1 Comment', 'couponhut'), esc_html__('% Comments', 'couponhut'), 'comments-number'); ?></span>
							</div>
							<div class="post-excerpt">
								<?php the_excerpt(); ?>
								<p class="read-more-p"><a href="<?php echo esc_url(get_permalink()); ?>" class="more"><?php  esc_html_e('Continue Reading', 'couponhut'); ?><i class="fa fa-arrow-right"></i></a></p>
							</div>
						</div><!-- end post-content -->
					</div><!-- end col-sm-8 -->
					
								
				</article>

			
			<?php endwhile; 

			fw_ssd_paging_nav();

			else: ?>

			<div class="no-posts-wrapper">
				<h3><?php esc_html_e('No posts found', 'couponhut') ?></h3>
			</div>

			<?php endif; ?>	

			</div><!-- end col-sm-8 col-md-9 -->
			<?php get_sidebar('blog'); ?>
			
		</div>

	</div><!-- end container-fluid -->

	

</div><!-- end post -->




<?php get_footer(); ?>