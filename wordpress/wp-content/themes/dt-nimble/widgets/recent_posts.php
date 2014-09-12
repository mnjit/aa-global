<?php
class DT_recent_post extends WP_Widget {
	function __construct() {
        parent::__construct(
            'dt_recent_posts',
            DT_WIDGET_PREFIX . __('Recent Posts', LANGUAGE_ZONE)
        );
	}

	function form($instance) {
		// widget controls

        $defaults = array(
            'title' 	=> '',
			'thumb'		=> true,
            'show'  	=> 5
        );
        $instance = wp_parse_args( $instance, $defaults );
        $instance = array_map( 'esc_attr', $instance );

		?>

		<p>
			<label for="<?php echo $this->get_field_id('title') ?>"><?php echo __( 'Title:', LANGUAGE_ZONE ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title') ?>" name="<?php echo $this->get_field_name('title') ?>" type="text" value="<?php echo $instance['title']; ?>"/>
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id('show') ?>"><?php echo __( 'Number of posts to show:', LANGUAGE_ZONE ) ?></label>
			<input id="<?php echo $this->get_field_id('show') ?>" name="<?php echo $this->get_field_name('show') ?>" type="text" value="<?php echo $instance['show']; ?>" size="3" />
		</p>
		
		<p>
			<input id="<?php echo $this->get_field_id('thumb'); ?>" type="checkbox" name="<?php echo $this->get_field_name('thumb'); ?>" <?php checked($instance['thumb']); ?>/>
			<label for="<?php echo $this->get_field_id('thumb'); ?>"><?php _e('Show featured images', LANGUAGE_ZONE); ?></label>
		</p>

	<?php

	}

	function update($new_instance, $old_instance) {
		// processes widget options to be saved
		$instance = $old_instance;
        $instance['title'] = strip_tags( $new_instance['title'] );
        $instance['thumb'] = isset($new_instance['thumb']);
		
        $new_instance['show'] *= 1;
		$instance['show'] = ($new_instance['show'] > 0)?$new_instance['show']:5;
        
        return $instance;
	}

	function widget($args, $instance) {
		// outputs the content of the widget
		extract( $args );
		
        $defaults = array(
            'title' 	=> '',
			'thumb'		=> true,
            'show'  	=> 5
        );
        $instance = wp_parse_args( $instance, $defaults );
        
		$title = apply_filters( 'widget_title', $instance['title'] );
	        
        $posts = new WP_Query( array(
			'no_found_rows'			=> 1,
            'post_status'           => 'publish',
            'posts_per_page'        => $instance['show'],
            'ignore_sticky_posts'   => true,
            'no_found_rows'         => true
        ) );
		
		// caching!
		if ( $posts->have_posts() ) {
			
			// get posts thumbnails id's
			$images = array();
			foreach ( $posts->posts as $p ) {
				if ( has_post_thumbnail( $p->ID ) ) {
					$images[] = get_post_thumbnail_id( $p->ID );
				}
			}

			// get all images in once
			if ( $images ) {
				$i_query = new WP_Query( array(
					'no_found_rows'		=> 1,
					'posts_per_page'	=> -1,
					'post_type'			=> 'attachment',
					'post_status' 		=> 'inherit',
					'post__in'			=> $images
				) );
			}
		}
		
		echo $before_widget;
		
		if( $title )
			echo $before_title . $title . $after_title;
		
		$last = $posts->found_posts;
		
		if( $posts->have_posts() ) {
		    $i = 1;
			foreach( $posts->posts as $post_item ):
                $class = '';
                if( $i == 1 ) {
                    $class = ' first';
                }elseif( $i == $last ) {
                    $class = ' last';
                }

                $title = get_the_title($post_item->ID);
                if( !$title ) {
                    $title = __('No title', LANGUAGE_ZONE);
                }
				
				$img = '';
				if ( $instance['thumb'] && has_post_thumbnail( $post_item->ID ) ) {
					$img_id = get_post_thumbnail_id( $post_item->ID );
					$img_meta =  wp_get_attachment_image_src( $img_id, 'full' );
					
					// get alt
					$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					if ( !$img_alt ) { $img_alt = get_the_title( $post_item->ID ); }
					
					$img = dt_get_thumb_img( array(
						'alt'			=> $img_alt,
						'img_meta'		=> $img_meta,
						'href'			=> get_permalink($post_item->ID),
						'thumb_opts' 	=> array('w' => 50, 'h' => 50)
						),
						'<a %HREF% class="alignleft img-post view" ><img %SRC% %SIZE% %ALT% /></a>',
						false
					);
				}
                ?>

                <div class="post<?php echo $class ; ?>">
                    <div class="post-bg">
						<?php echo $img; ?>
						<div class="post-inner">
							<a href="<?php echo get_permalink($post_item->ID); ?>"><?php echo $title; ?></a>
							<div class="goto-post">
								<span class="ico-link date"><?php echo get_the_date(get_option('date_format'), $post_item->ID); ?></span>
<?php                        
                dt_get_comments_link(
                    '<span class="ico-link comments">%COUNT%</span>',
                    array( 'no_coments' => '' ),
                    $post_item->ID
                );
?>
							</div>
						</div>
					</div>
                </div>
            <?php

            $i++;
		    endforeach;	
		}
		echo $after_widget;
	}
}

function dt_recent_posts_register() {
	register_widget('DT_recent_post');
}

add_action( 'widgets_init', 'dt_recent_posts_register' );
