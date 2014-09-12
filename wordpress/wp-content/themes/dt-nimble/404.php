<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <?php get_template_part('parallax'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container">
            <h1><?php _e('Error', LANGUAGE_ZONE); ?></h1>
            <div class="hr hr-wide gap-big"></div>
            
            <p><?php _e('404 &ndash; File not found', LANGUAGE_ZONE); ?></p>
        </div>

        <?php get_sidebar(); ?>
    
    </div>

<?php get_footer(); ?>