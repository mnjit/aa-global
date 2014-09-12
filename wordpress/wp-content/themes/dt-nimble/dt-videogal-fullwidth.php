<?php
/* Template Name: 12. Video Gallery (Full-width) */

do_action( 'dt_layout_before_header-video' );

get_header();
?>

<?php get_template_part( 'top-bg' ); ?>

<div id="wrapper">

    <?php get_template_part( 'nav' ); ?>
    
    <div id="container" class="full-width for-gal">

    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // main loop ?>

        <h1><?php the_title(); ?></h1>
        <div class="hr hr-wide gap-big"></div>

        <div class="gallery">
           
            <?php
			$opts = get_post_meta( get_the_ID(), '_dt_video_layout_options', true );
			$cats = get_post_meta( get_the_ID(), '_dt_video_layout_category', true );

			dt_category_list( array(
				'post_type'         => 'dt_video',
				'taxonomy'          => 'dt_video_category',
				'select'            => $cats['select'],
				'layout'            => $opts['layout'],
				'layout_switcher'   => false,
				'show'              => ( 'on' == $opts['show_cat_filter'] ) ? true : false,
				'terms'             => isset( $cats['video_cats'] ) ? $cats['video_cats'] : array() 
			) ); 
			?>
    
			<div class="gallery-inner t-l dt-ajax-content video-gal"></div>
        </div>

        <?php endwhile; endif; // end main loop ?>

    </div>        
</div>

<?php get_footer(); ?>