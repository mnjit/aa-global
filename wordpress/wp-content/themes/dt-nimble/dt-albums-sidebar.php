<?php
/* Template Name: 11. Albums with Sidebar */

dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-albums' );

get_header();
?>

<?php get_template_part( 'top-bg' ); ?>

<div id="wrapper">

    <?php get_template_part( 'nav' ); ?>

    <div id="container"<?php echo dt_get_container_class(); ?>>

    	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); // main loop ?>

        <h1><?php the_title(); ?></h1>
        <div class="hr hr-wide gap-big"></div>

        <div class="gallery">
           
            <?php
			if ( ! post_password_required( get_the_ID() ) ) {

				$opts = get_post_meta( get_the_ID(), '_dt_albums_layout_options', true );
				$cats = get_post_meta( get_the_ID(), '_dt_albums_layout_albums', true );

				$args = array(
					'post_type'         => 'dt_gallery',
					'taxonomy'          => 'dt_gallery_category',
					'select'            => $cats['select'],
					'layout'            => $opts['layout'],
					'layout_switcher'   => ( 'on' == $opts['show_layout_swtch'] ) ? true : false,
					'show'              => ( 'on' == $opts['show_cat_filter'] ) ? true : false,
				);

				$args['terms'] = array();
				if ( 'albums' == $cats['type'] && isset( $cats['albums'] ) && ( 'all' != $cats['select'] ) ) {
					$args['terms'] = array();
					$args['post_ids'] = $cats['albums'];
				} elseif ( isset( $cats['albums_cats'] ) && ( 'all' != $cats['select'] ) ) {
					$args['terms'] = $cats['albums_cats'];
				}
				
				dt_category_list( $args ); 
			?>

			<div class="gallery-inner dt-ajax-content"></div>

			<?php
			} else {
				echo get_the_password_form();
			}
			?>
        </div>

    <?php endwhile; endif; // end main loop ?>

    </div>
        
    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>