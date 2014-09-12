<?php get_header(); ?>

    <?php get_template_part('top-bg'); ?>
    
    <?php get_template_part('parallax'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container" class="full-width for-gal in">
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
            
            <h1><?php the_title(); ?></h1>
            
            <?php if ( ! post_password_required() ): ?>

            <?php
			// prev/next post arrows (setting located in theme options - misc)
			if ( of_get_option( 'misc-show_next_prev_portfolio' ) ) {
				dt_get_next_prev_post( array( 'title' => __( 'Project %CURRENT% of %MAX%', LANGUAGE_ZONE ) ) );
			}
			?>

            <div class="hr hr-wide gap-big"></div>

            <?php
            global $post;
            $dt_tmp_query = new WP_Query();
            $post_opts = get_post_meta( get_the_ID(), '_dt_portfolio_options', true );
			?>
			
			<?php if ( ! isset( $post_opts['hide_media'] ) || ! $post_opts['hide_media'] ): ?>
			
			<?php
			$args = array(
				'post_type'         => 'attachment',
				'post_status'       => 'inherit',
				'posts_per_page'    => -1,
				'post_parent'       => $post->ID,
				'post_mime_type'    => 'image',
				'orderby'           => 'menu_order',
				'order'             => 'ASC'
			);
			if ( $post_opts['hide_thumbnail'] )
				$args['post__not_in'] = array( get_post_thumbnail_id() );

			$dt_tmp_query->query( $args );
			if ( $dt_tmp_query->have_posts() ) {
				$slides = array();
				foreach ( $dt_tmp_query->posts as $slide ) {
					$video = get_post_meta( $slide->ID, '_dt_portfolio_video_link', true );
					$tmp_arr = array();
					
					$alt = get_post_meta( $slide->ID, '_wp_attachment_image_alt', true );
					$tmp_arr['caption'] = $slide->post_excerpt;
					if ( ! $video ) {
						$slide_src = dt_get_resized_img( wp_get_attachment_image_src( $slide->ID, 'full' ), array( 'w' => 710 ) );
						$tmp_arr['src'] = $slide_src[0];
						$tmp_arr['size_str'] = $slide_src[3];
						$tmp_arr['alt']	= $alt;
					} else {
						$tmp_arr['is_video'] = true; 
						$tmp_arr['src'] = $video; 
						$tmp_arr['size_str'] = array( 710, 1024 );
					}
					
					$slides[] = $tmp_arr;
				}
				dt_get_anything_slider( array( 'items_arr' => $slides ) );
			}

			?>
            <div class="full-left">

			<?php endif; ?>

                <?php
                the_content();

                if( !$post_opts['hide_meta'] ) {
                    dt_get_taxonomy_link(
                        'dt_portfolio_category',
                        '<span class="ico-link categories">' . __('', LANGUAGE_ZONE) . '%CAT_LIST%</span>'
                    );
                }

				if( dt_is_page_soc_buttons_enabled('portfolio') ) {
					dt_get_like_buttons( get_the_ID() );
				}
                ?>

            <?php if( !isset($post_opts['hide_media']) || (isset($post_opts['hide_media']) && !$post_opts['hide_media']) ): ?>
            </div>
			<?php endif; ?>

            <?php
            else:
                echo get_the_password_form();
            endif;// post protected
            endwhile; endif;//have posts ?>

        <p class="gap"></p>

        <?php
        $rel_works = get_post_meta($post->ID, '_dt_portfolio_related', true);
        if( isset($rel_works['show_related']) && $rel_works['show_related'] && !post_password_required() ):
        ?>

        <p class="hr hr-narrow gap-small"></p>

        <div class="gap"></div>
        <div class="full-width w-photo">
            <h2><?php _e( 'Related Projects', LANGUAGE_ZONE ); ?></h2>

            <?php
            if ( 'same' == $rel_works['related'] ) {
                $rel_works['related'] = wp_get_post_terms(
                    $post->ID,
                    'dt_portfolio_category',
                    array( 'fields' => 'ids' )
                );
            }
            $dt_tmp_query->query( array(
                'posts_per_page'    => -1,
                'post_type'         => 'dt_portfolio',
                'post_status'       => 'publish',
                'post__not_in'      => array( $post->ID ),
                'tax_query'         => array( array(
                    'taxonomy'  => 'dt_portfolio_category',
                    'field'     => 'id',
                    'terms'     => $rel_works['related'],
                    'operator'  => 'IN'
                ) )  
            ) );

            if ( $dt_tmp_query->have_posts() ) {
                $thumb_arr = dt_core_get_posts_thumbnails( $dt_tmp_query->posts );
                $items = array();
                foreach( $dt_tmp_query->posts as $rel_post ) {
                    $item = array();
                    $img = dt_get_resized_img(
                        dt_get_thumb_meta( $thumb_arr['thumbs_meta'], 'full', $rel_post->ID ),
                        array( 'w' => 225, 'h' => 140 )
                    );
					$img_id = get_post_thumbnail_id( $rel_post->ID );
					
					// get alt
					$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					if ( !$img_alt ) { $img_alt = get_the_title( $rel_post->ID ); }
					
                    $item['src'] = $img[0];
                    $item['size_str'] = $img[3];
                    $item['post_id'] = $rel_post->ID;
					$item['desc'] = apply_filters('get_the_excerpt', $rel_post->post_excerpt);
					$item['title'] = apply_filters('the_title', $rel_post->post_title, $rel_post->ID);
                    $item['alt'] = esc_attr( $img_alt );
					
                    $items[] = $item;
                }
				
				$args = array( 'items_arr' => $items, 'id' => 'foo1', 'ul_class' => 'slider1' );
				$args['wrap'] = '<div class="%CLASS% bx">%SLIDER%</div>';
				
				if ( ! empty( $rel_works['show_desc'] ) || ! empty( $rel_works['show_title'] ) ) {
					
					$title = '';
					if ( ! empty( $rel_works['show_title'] ) ) {
						$title = '<h3><a href="%LINK%" class="head">%TITLE%</a></h3>';
					}
					
					$desc = '';
					if ( ! empty( $rel_works['show_desc'] ) ) {
						$desc = '<p>%DESC%</p>';
					}
					
					$args['item_wrap'] = '
					<li>
						<div class="textwidget">
							<div class="textwidget-photo">
								<a class="photo" href="%LINK%"><img src="%IMG_SRC%" alt="%ALT%" %IMG_SIZE% /></a>
							</div>
							<div class="widget-info">
								<div class="info">
									' . $title . $desc . '
								</div>
							</div>
						</div>
					</li>
					';
					
				}
                dt_get_carousel_slider( $args );
            }
            ?>
    
        </div>

        <?php endif; ?>

        <?php comments_template(); ?>

        </div><!-- #container -->
    
    </div><!-- #wrapper -->

<?php get_footer(); ?>