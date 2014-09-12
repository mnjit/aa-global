<?php dt_storage('have_sidebar', true); ?>
<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container">
            <h1><?php if( is_category() || is_tax() ):
                _e( 'Category archive: ', LANGUAGE_ZONE );
                echo single_cat_title( null, false );
            elseif( is_tag() ):
                _e( 'Tag archive: ', LANGUAGE_ZONE );
                echo single_tag_title( null, false );
            elseif( is_author() ):
                $curauth = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
                _e( 'Author archive: ', LANGUAGE_ZONE );
                echo $curauth->nickname;
            elseif( is_date() ):
                _e( 'Date archive: ', LANGUAGE_ZONE );
                echo single_month_title( ' ', false );
            else:
                global $post;
                _e( 'Archive: ', LANGUAGE_ZONE );
            endif;
            ?></h1>
            <div class="hr hr-wide gap-big"></div>
			
			<?php
            do_action('dt_layout_before_loop', 'index');
            if ( have_posts() ) {
				
				/* Add apropriet class to portfolio/gallery/category in search
				 * Filter "dt_portfolio_default_classes" located in functions.php
				 * Function defined in /modules/helpers/template-helper.php
				 */
				add_filter( 'dt_portfolio_default_classes', 'dt_search_portfolio_class_filter' );

				// some init stuff
				$add_data = array(
					'init_layout'		=> '2_col-list',
					'template_layout'	=> 'sidebar',
					'thumb_w'			=> 344,
					'thumb_h'			=> 220
				);
				dt_storage( 'add_data', $add_data );

                while ( have_posts() ) {
					the_post();
					get_template_part( 'content', 'dt-albums' );
                }

	            if ( function_exists( 'wp_pagenavi' ) ) {
                    wp_pagenavi();
	            }
            } else {
                echo '<p>'.__('Nothing found', LANGUAGE_ZONE).'</p>';
            }
            ?>

        </div>

        <?php get_sidebar(); ?>
    
    </div>

	<script type="text/javascript">jQuery(document).ready( function() { add_i_height(); } );</script>

<?php get_footer(); ?>