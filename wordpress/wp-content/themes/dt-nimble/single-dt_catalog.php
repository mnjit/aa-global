<?php get_header(); ?>
<?php dt_storage('have_sidebar', true); ?>
    
    <?php get_template_part('top-bg'); ?>
    
    <?php get_template_part('parallax'); ?>
    
    <div id="wrapper">
        
        <?php get_template_part('nav'); ?>
        
        <div id="container">
            
            <?php if( have_posts() ): while( have_posts() ): the_post(); ?>
            
                <h1><?php the_title(); ?></h1>
                <div class="hr hr-wide gap-big"></div>

            <?php
            global $post;
            $post_opts = get_post_meta($post->ID, '_dt_catalog-post_options', true);

            if( !isset($post_opts['hide_media']) || (isset($post_opts['hide_media']) && !$post_opts['hide_media']) ) {
                $args = array(
                    'post_type'         => 'attachment',
                    'post_status'       => 'inherit',
                    'posts_per_page'    => -1,
                    'post_parent'       => $post->ID,
                    'post_mime_type'    => 'image',
                    'orderby'           => 'menu_order',
                    'order'             => 'ASC'
                );
                if( !empty($post_opts['hide_thumbnail']) )
                    $args['post__not_in'] = array( get_post_thumbnail_id() );

                $dt_tmp_query = new WP_Query( $args );
                if( $dt_tmp_query->have_posts() ) {
                    $slides = array();
                    foreach( $dt_tmp_query->posts as $slide ) {
                        $video = get_post_meta( $slide->ID, '_dt_catalog_video_link', true );
                        $tmp_arr = array();

                        $tmp_arr['caption'] = $slide->post_excerpt;
                        if ( ! $video ) {
                            $slide_src = dt_get_resized_img( wp_get_attachment_image_src( $slide->ID, 'full' ), array( 'w' => 710 ) );
							$tmp_arr['alt'] = get_post_meta( $slide->ID, '_wp_attachment_image_alt', true );
                            $tmp_arr['src'] = $slide_src[0];
                            $tmp_arr['size_str'] = $slide_src[3];
                        } else {
                            $tmp_arr['is_video'] = true; 
                            $tmp_arr['src'] = $video; 
                            $tmp_arr['size_str'] = array( 710, 1024 );
                        }
                        $slides[] = $tmp_arr;
                    }
                    dt_get_anything_slider( array( 'id' => 'slider2', 'items_arr' => $slides ) );
                }
            }
            ?>
                
                <?php $opts = get_post_meta($post->ID, '_dt_catalog-goods_options', true); ?>
				
				<?php if( !empty($opts['price']) ): ?>
                
				<span class="price"><?php _e('Price: ', LANGUAGE_ZONE); echo esc_html($opts['price']); ?></span>
				
				<?php endif; ?>
                
                <?php
				the_content();
				
				if( dt_is_page_soc_buttons_enabled('catalog') ) {
					dt_get_like_buttons( get_the_ID() );
				}
				?>

                <?php if( !empty($opts['p_link']) ): ?>
                
                    <a href="<?php echo esc_url($opts['p_link']); ?>" class="button" title=""><span><i class="dol"></i><?php _e('Make purchase!', LANGUAGE_ZONE); ?></span></a>
                
                <?php endif; ?>

                <p class="gap"></p>
                <?php
                $rel_works = get_post_meta($post->ID, '_dt_catalog_related', true);
                if( isset($rel_works['show_related']) && $rel_works['show_related'] ):
                    if( 'same' == $rel_works['related'] ) {
                        $rel_works['related'] = wp_get_post_terms(
                            $post->ID,
                            'dt_catalog_category',
                            array('fields' => 'ids')
                        );
                    }
                    if( !empty($rel_works['related']) ):
                ?>

                <p class="hr hr-narrow gap-small"></p>
                
                <div class="gap"></div>
                <div class="full-width w-photo">
                    <h2><?php _e('Related Items', LANGUAGE_ZONE); ?></h2>
            
                    <?php
                    if( 'same' == $rel_works['related'] ) {
                        $rel_works['related'] = wp_get_post_terms(
                            $post->ID,
                            'dt_catalog_category',
                            array('fields' => 'ids')
                        );
                    }
                    $dt_tmp_query = new WP_Query( array(
                        'posts_per_page'    => -1,
                        'post_type'         => 'dt_catalog',
                        'post_status'       => 'publish',
                        'post__not_in'      => array($post->ID),
                        'tax_query'         => array( array(
                            'taxonomy'  => 'dt_catalog_category',
                            'field'     => 'id',
                            'terms'     =>  $rel_works['related'],
                            'operator'  => 'IN'
                        ) )    
                    ) );
                    if( $dt_tmp_query->have_posts() ) {
                        $thumb_arr = dt_core_get_posts_thumbnails( $dt_tmp_query->posts );
                        $items = array();
                        foreach( $dt_tmp_query->posts as $rel_post ) {
                            $item = array();
                            $img = dt_get_resized_img(
                                dt_get_thumb_meta($thumb_arr['thumbs_meta'], 'full', $rel_post->ID),
                                array('w' => 223, 'h' => 140, 'use_noimage' => true)
                            );
                            $item['src'] = $img[0];
                            $item['size_str'] = $img[3];
                            $item['post_id'] = $rel_post->ID;
							
							$img_id = get_post_thumbnail_id( $rel_post->ID );
					
							// get alt
							$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
							if ( !$img_alt ) { $img_alt = get_the_title( $rel_post->ID ); }
							
							$item['desc'] = apply_filters('get_the_excerpt', $rel_post->post_excerpt);
							$item['title'] = apply_filters('the_title', $rel_post->post_title, $rel_post->ID);
							$item['alt'] = esc_attr($img_alt );

                            $items[] = $item;
                        }
						
						$args = array( 'items_arr' => $items, 'id' => '', 'class' => 'list-carousel recent bx', 'ul_class' => 'slider1' );
						$args['wrap'] = '<div class="%CLASS% bx">%SLIDER%</div>';
				
						if( ! empty( $rel_works['show_desc'] ) || ! empty( $rel_works['show_title'] ) ) {

							$title = '';
							if( ! empty( $rel_works['show_title'] ) ) {
								$title = '<h3><a href="%LINK%" class="head">%TITLE%</a></h3>';
							}
							
							$desc = '';
							if( ! empty( $rel_works['show_desc'] ) ) {
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

                <?php endif; endif; ?>
                
                <?php comments_template(); ?>

            <?php
                endwhile;
            endif;
            ?>
        
        </div>

        <?php dt_widget_area('sidebar', null, 'sidebar_4'); ?>
    
    </div>

<?php get_footer(); ?>