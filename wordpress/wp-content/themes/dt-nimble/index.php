<?php
dt_storage( 'have_sidebar', true );
dt_storage( 'is_index', true );
?>
<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container"<?php echo dt_get_container_class(); ?>>
            <h1><?php _e('Blog', LANGUAGE_ZONE); ?></h1>
            <div class="hr hr-wide gap-big"></div>

            <?php
            do_action('dt_layout_before_loop', 'index');
            if( have_posts() ) {
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
