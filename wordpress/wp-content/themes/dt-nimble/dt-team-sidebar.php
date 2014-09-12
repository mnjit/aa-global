<?php
/* Template Name: 22. Team Page with Sidebar */

dt_storage( 'have_sidebar', true );

get_header();
?>

<?php get_template_part( 'top-bg' ); ?>

<div id="wrapper">

<?php get_template_part( 'nav' ); ?>

<div id="container"<?php echo dt_get_container_class(); ?>>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // main loop ?>

	<h1><?php the_title(); ?></h1>
	<div class="hr hr-wide gap-big"></div>
	
	<?php			
	$page_options = get_post_meta( get_the_ID(), '_dt_meta_team_options', true );

	if ( isset( $page_options['content_position'] ) ) {
		$cont_pos = $page_options['content_position'];
	} else {
		$cont_pos = 'top';
	}
	
	$have_content = (bool) get_the_content();
	
	if ( 'top' == $cont_pos && $have_content ) {
		the_content();
		?><div class="hr gap-small"></div><?php
	}

	do_action( 'dt_layout_before_loop', 'dt-team' );
	global $DT_QUERY;

	if ( $DT_QUERY->have_posts() ) {
		?><div class="team-list"><?php
		// custom loop
		while ( $DT_QUERY->have_posts() ): $DT_QUERY->the_post();
			$post_id = get_the_ID();
			
			$teammate_data = get_post_meta( $post_id, '_dt_team_info', true );
			$teammate_meta = array();
			
			if ( !empty( $teammate_data['position'] ) ) {
				$teammate_meta[] = $teammate_data['position'];
			}
			
			if ( !empty( $teammate_data['age'] ) ) {
				$teammate_meta[] = $teammate_data['age'];
			}
		?><div class="team-wrap">
			<?php
			if ( has_post_thumbnail( $post_id ) ){
				$img_id = get_post_thumbnail_id( $post_id );
				
				// get alt
				$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
				if ( !$img_alt ) { $img_alt = get_the_title( $post_id ); }
				
				dt_get_thumb_img( array(
						'alt'			=> $img_alt,
						'img_meta'		=> wp_get_attachment_image_src( $img_id, 'full' ),
						'thumb_opts'	=> array( 'w' => 80, 'h' => 100 ) 
					),
					'<img class="alignleft" %SRC% %SIZE% %ALT%/>'
				);
			}
			
			if ( $author = get_the_title() ): ?><span class="head"><?php echo $author; ?></span><?php endif;
			
			if ( ! empty( $teammate_meta ) ): ?>
			<p class="mid-gray"><span><?php echo implode( '<br />', $teammate_meta ); ?></span></p>
			<?php endif; 
			?><div class="team-description"><?php the_content(); ?></div>
		</div>
		<?php
		endwhile; // custom loop
		wp_reset_postdata();
		?></div><?php
		
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

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>