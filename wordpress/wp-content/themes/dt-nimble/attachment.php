<?php get_header(); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container"<?php echo dt_get_container_class(); ?>>
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>

            <?php
            global $post;
            $big = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
			$big[3] = image_hwstring( $big[1], $big[2] );
			
			if( $big[1] > 960 ) {
				$thumb = dt_get_resized_img($big, array('w' => 960));
			
				printf('<a class="alignleft highslide" href="%1$s" onclick="return hs.expand(this)"><img src="%2$s" %3$s alt="%4$s" /></a>',// 
					$big[0], $thumb[0], $thumb[3], get_the_excerpt()
				);
			}else {
				printf('<img class="alignleft" src="%1$s" %2$s alt="%3$s" />',
					$big[0], $big[3], get_the_excerpt()
				);
			}
			
			the_content();
			if( dt_is_page_soc_buttons_enabled('photo') ) {
				dt_get_like_buttons( get_the_ID() );
			}
            ?>

            <?php
                endwhile;
            endif;
            ?>

        </div>
    
    </div>

<?php get_footer(); ?>