<?php
/* Template Name: 15. Homepage with Blog */

dt_storage( 'is_homepage', ( dt_get_paged_var() <= 1 ) );
dt_storage( 'is_blog', true );
dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-blog' );

get_header();
?>

	<?php get_template_part( 'top-bg' ); ?>

	<?php get_template_part( 'nav' ); ?>
	
	<?php $slider_options = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true ); ?>
	
	<?php
	if ( dt_storage('is_homepage') ) :
		if ( 'fullscreen_slider' == $slider_options['slider'] ) {
			$slider_section_id = 'fs-slideshow';
		} else {
			$slider_section_id = 'slide';
		}
	?>
	<section id="<?php echo $slider_section_id; ?>"></section>
	<?php endif; // if homepage ?>
	
	<?php if ( 'fullscreen_slider' != $slider_options['slider'] || empty( $slider_options['fs_hide_content'] ) ): ?>
	
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

	<?php endif; ?>

<?php get_footer(); ?>