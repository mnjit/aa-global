<?php
/* Template Name: 17. OneByOne Slider with sidebar */

dt_storage( 'is_homepage', true );
dt_storage( 'have_obo_slider', true );
dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-oboslider' );

get_header();
?>

    <?php get_template_part( 'top-bg' ); ?>

    <?php get_template_part( 'nav' ); ?>

	<section id="slide" class="byOne" style="height: ;"></section>
    
    <div id="wrapper">

        <div id="container"<?php echo dt_get_container_class(); ?>><?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?></div>
        
        <?php get_sidebar(); ?>

    </div>

<?php get_footer(); ?>