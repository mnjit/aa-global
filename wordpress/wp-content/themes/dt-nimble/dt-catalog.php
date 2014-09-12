<?php
/* Template Name: 14. Catalog */

dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-catalog' );

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
		$opts = get_post_meta( get_the_ID(), '_dt_catalog_layout_options', true );
		$cats = get_post_meta( get_the_ID(), '_dt_catalog_layout_category', true );

		dt_category_list( array(
			'post_type'         => 'dt_catalog',
			'taxonomy'          => 'dt_catalog_category',
			'select'            => $cats['select'],
			'layout'            => '2_col-list',
			'show'              => ( 'on' == $opts['show_cat_filter'] ) ? true : false,
			'layout_switcher'   => false,
			'terms'             => isset( $cats['catalog_cats'] ) ? $cats['catalog_cats'] : array()
		) );
		?>
 
        <div class="dt-ajax-content"></div>

		</div>

		<?php endwhile; endif; // end main loop ?>

	</div>

	<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>