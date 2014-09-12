<?php
/* Template Name: 18. OneByOne Slider with blog */

dt_storage( 'is_homepage', ( dt_get_paged_var() <= 1 ) );
dt_storage( 'is_blog', true );
dt_storage( 'have_obo_slider', true );
dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-blog' );

get_header();
?>

    <?php get_template_part( 'top-bg' ); ?>

    <?php get_template_part( 'nav' ); ?>
	
	<?php if ( dt_storage('is_homepage') ) : ?>
	<section id="slide" class="byOne" style="height: ;"></section>
    <?php endif; ?>

	<div id="wrapper">

        <div id="container"<?php echo dt_get_container_class(); ?>>

		<?php
			if ( have_posts() ) {
				while ( have_posts() ) { the_post();
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
				}
			}
		?>

		</div>

	<?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>