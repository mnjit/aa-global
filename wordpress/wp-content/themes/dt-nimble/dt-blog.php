<?php
/* Template Name: 05. Blog */

dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-blog' );

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
			do_action( 'dt_layout_before_loop', 'dt-blog' );
			global $DT_QUERY;
			if ( $DT_QUERY->have_posts() ) {
				while ( $DT_QUERY->have_posts() ) {
					$DT_QUERY->the_post();
					get_template_part( 'content', get_post_format() );
				}

				if ( function_exists( 'wp_pagenavi' ) ) {
					wp_pagenavi( $DT_QUERY );
				}
			}
			wp_reset_postdata();
            ?>

            <?php endwhile; endif; // end main loop ?>

        </div>
        
        <?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>