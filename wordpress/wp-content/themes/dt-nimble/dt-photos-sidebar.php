<?php
/* Template Name: 09. Photos with Sidebar */

dt_storage( 'have_sidebar', true );

do_action( 'dt_layout_before_header-photos' );

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
			if ( ! post_password_required() ) {
				global $post;
				$opts = get_post_meta( get_the_ID(), '_dt_photos_layout_options', true );
				$cats = get_post_meta( get_the_ID(), '_dt_photos_layout_albums', true );
				
				$args = array(
					'post_type'         => 'dt_gallery',
					'taxonomy'          => 'dt_gallery_category',
					'select'            => $cats['select'],
					'layout'            => $opts['layout'],
					'count_attachments' => true,
					'show'              => ( 'on' == $opts['show_cat_filter'] ) ? true : false,
					'layout_switcher'   => false
				);

				$args['terms'] = array();
				if ( 'albums' == $cats['type'] && isset( $cats['albums'] ) && ( 'all' != $cats['select'] ) ) {
					global $wpdb;
						
					$terms_str = implode( ',', array_values( $cats['albums'] ) );

					$terms = $wpdb->get_results( "
						SELECT $wpdb->term_taxonomy.term_id AS ID    
						FROM $wpdb->posts
						JOIN $wpdb->term_relationships ON $wpdb->term_relationships.object_id = $wpdb->posts.ID
						JOIN $wpdb->term_taxonomy ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
						WHERE $wpdb->posts.post_type = 'dt_gallery'
						AND $wpdb->posts.post_status = 'publish'
						AND $wpdb->posts.ID IN ($terms_str)
						GROUP BY $wpdb->term_taxonomy.term_id
					" );
					
					if ( $terms ) {
						foreach ( $terms as $term ) {
							$args['terms'][] = intval( $term->ID );    
						}
					}
					$args['post_ids'] = $cats['albums'];
				} elseif ( isset( $cats['albums_cats'] ) && ( 'all' != $cats['select'] ) ) {
					$args['terms'] = $cats['albums_cats'];
				}

				dt_category_list( $args );
				?>

				<div class="gallery-inner t-l dt-ajax-content"></div>

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