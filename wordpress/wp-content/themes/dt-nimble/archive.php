<?php
dt_storage( 'have_sidebar', true );
get_header();
?>
    
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
                if( $post )
                    echo get_post_format_string(get_post_format());
                else
                    echo 'Standard';
            endif;
            ?></h1>

            <div class="hr hr-wide gap-big"></div>
			<!-- archive -->
            <?php
            do_action('dt_layout_before_loop', 'index');
			global $wp_query;
			dt_storage( 'post_is_first', 1 );
            if ( have_posts() ) {
                while( have_posts() ) { the_post();
                    get_template_part('content', get_post_format() );
                }

	            if( function_exists('wp_pagenavi') ) {
                    wp_pagenavi();
	            }
            }
            ?>

        </div>

        <?php get_sidebar(); ?>
    
    </div>

<?php get_footer(); ?>