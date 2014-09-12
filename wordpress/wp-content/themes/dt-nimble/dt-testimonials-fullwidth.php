<?php
/* Template Name: 19. Testimonials Full-width Page */

get_header();
?>

<?php get_template_part('top-bg'); ?>

<?php get_template_part('nav'); ?>

<div id="container" class="full-width">
	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // main loop ?>

	<h1><?php the_title(); ?></h1>
	<div class="hr hr-wide gap-big"></div>

	<?php
	$page_options = get_post_meta( get_the_ID(), '_dt_meta_testimonials_options', true );

	if ( isset( $page_options['content_position'] ) ) {
		$cont_pos = $page_options['content_position'];
	} else {
		$cont_pos = 'top';
	}

	$have_content = get_the_content();
	
	if ( 'top' == $cont_pos && $have_content ) {
		the_content();
		?><div class="hr gap-small"></div><?php
	}
	
	do_action( 'dt_layout_before_loop', 'dt-testimonials' );
	global $DT_QUERY;
	if ( $DT_QUERY->have_posts() ) {
		$posts_count = 0;
		// custom loop
		while ( $DT_QUERY->have_posts() ): $DT_QUERY->the_post();
			$posts_count++;
			$post_id = get_the_ID();
			$opts = get_post_meta( $post_id, '_dt_testimonials_author', true );
			
			$post_classes = array( 'dt-testimon' );
			if ( 1 == $posts_count ) {
				$post_classes[] = 'first';
			}
		?><div class="<?php echo implode( ' ', $post_classes ); ?>">
			<div class="panel-wrapper"><?php the_content(); ?></div>
			<div class="panel-author"><?php
					if ( has_post_thumbnail( $post_id ) ){
						dt_get_thumb_img( array(
								'img_meta'		=> wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' ),
								'thumb_opts'	=> array( 'w' => 30, 'h' => 30 ) 
							),
							'<img class="alignleft" %SRC% %SIZE% %ALT%/>'
						);
					}
					
					if ( $author = get_the_title() ): ?><p class="author-name"><?php echo $author; ?></p><?php endif;
					
					if ( ! empty( $opts['position'] ) ): ?><span class="author-position"><?php echo $opts['position']; ?></span><?php endif; 
			?></div>
		</div>
		<?php
		endwhile; // custom loop
		wp_reset_postdata();
		
		if ( function_exists( 'wp_pagenavi' ) ) {
			wp_pagenavi( $DT_QUERY );
		}
	}

	if ( 'bottom' == $cont_pos && $have_content ) {
		the_content();
	}
	?>

	<?php endwhile; endif; // end main loop ?>
	
</div>

<?php get_footer(); ?>