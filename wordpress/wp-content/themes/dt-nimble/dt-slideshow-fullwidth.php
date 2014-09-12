<?php
/* Template Name: 01. Page with Slideshow (Full-width) */

dt_storage( 'is_homepage', true );

do_action( 'dt_layout_before_header-slideshow' );

get_header();
?>

    <?php get_template_part( 'top-bg' ); ?>

    <?php get_template_part( 'nav' ); ?>
	
	<?php $slider_options = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true ); ?>
	
	<?php
	if ( 'fullscreen_slider' == $slider_options['slider'] ) {
		$slider_section_id = 'fs-slideshow';
	} else {
		$slider_section_id = 'slide';
	}
	?>
	<section id="<?php echo $slider_section_id; ?>"></section>	
	
	<?php if ( ! isset( $slider_options['slider'] ) || 'fullscreen_slider' != $slider_options['slider'] || empty( $slider_options['fs_hide_content'] ) ): ?>
	
        <div id="container" class="full-width"><?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?></div>
	
	<?php endif; ?>
	
<?php get_footer(); ?>