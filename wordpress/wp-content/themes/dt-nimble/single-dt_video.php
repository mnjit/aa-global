<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
        
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container" class="full-width">
            
            <?php if ( have_posts() ): while( have_posts() ): the_post(); ?>

            <?php
            $opts = get_post_meta( get_the_ID(), '_dt_video_options', true );
            if ( ! empty( $opts['video_link'] ) ):
            ?>
			
			<div class="videos" style="float: left !important; margin: 5px 20px 5px 0;"> 

				<?php dt_get_embed( $opts['video_link'], $opts['width'], $opts['height'] ); ?>

			</div>

            <?php endif; ?>

			<?php
			the_excerpt();
			
			dt_get_taxonomy_link(
				'dt_video_category',
				'<p>' . __('Category: ', LANGUAGE_ZONE) . '%CAT_LIST%</p>'
			);
			
			if( dt_is_page_soc_buttons_enabled('video') ) {
				dt_get_like_buttons( get_the_ID() );
			}
			?>
            
            <?php endwhile; endif; ?>
        
        </div><!-- #container -->
    
    </div><!-- #wrapper -->

<?php get_footer(); ?>