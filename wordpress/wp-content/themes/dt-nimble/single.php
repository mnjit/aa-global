<?php dt_storage('have_sidebar', true); ?>

<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <?php get_template_part('parallax'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container">
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
            
			<?php if ( get_the_title() ) : ?>
            
				<h1><?php the_title(); ?></h1>
            
			<?php endif; ?>
			
			<?php
			if( of_get_option('misc-show_next_prev_post') ) {
				dt_get_next_prev_post();
			}
			?>
            <?php if( !post_password_required() ): ?> 
           
				<div class="hr hr-wide gap-small"></div>

            <?php
				get_template_part('single', 'dt_blog');

			else: ?>
					<div class="hr hr-wide gap-small"></div>
					<?php echo get_the_password_form(); ?>
			<?php endif;// password protection

                endwhile;
            endif;
            ?>
           
        </div>

        <?php dt_widget_area( 'sidebar', null, 'sidebar_3' ); ?>
    
    </div>

<?php get_footer(); ?>