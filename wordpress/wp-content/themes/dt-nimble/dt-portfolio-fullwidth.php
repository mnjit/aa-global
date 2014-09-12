<?php
/* Template Name: 06. Portfolio (Full-width) */

do_action( 'dt_layout_before_header-portfolio' );

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

            <?php if( !post_password_required() ): ?>

            <?php
            global $post;
            $opts = get_post_meta( $post->ID, '_dt_portfolio_layout_options', true );
            $cats = get_post_meta( $post->ID, '_dt_portfolio_layout_category', true );
			
            dt_category_list( array(
                'post_type'         => 'dt_portfolio',
                'taxonomy'          => 'dt_portfolio_category',
                'select'            => $cats['select'],
                'layout'            => $opts['layout'],
                'layout_switcher'   => ( 'on' == $opts['show_layout_swtch'] ) ? true : false,
                'show'              => ( 'on' == $opts['show_cat_filter'] ) ? true : false,
                'terms'             => isset( $cats['portfolio_cats'] ) ? $cats['portfolio_cats'] : array() 
            ) );
            ?>

            <div class="gallery-inner dt-ajax-content"></div>
            
            <?php else: ?>
            
            <?php echo get_the_password_form(); ?>

            <?php endif; ?>

        </div>

        <?php endwhile; endif; // end main loop ?>
        
    </div>

</div>

<?php get_footer(); ?>