<?php

/* Begin Widget Class */
class DT_popular_posts_Widget extends WP_Widget {
    static $dt_hs_group = 0;
    
	function __construct() {  
		$widget_ops = array( 'description' => __('Popular Posts', LANGUAGE_ZONE) );

        parent::__construct(
            'dt-popular_posts-widget',
            DT_WIDGET_PREFIX . __('Popular Posts', LANGUAGE_ZONE),
            $widget_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {		
		extract( $args );

		/* Our variables from the widget settings. */
        
		$defaults = array( 
			'title'     => '',
			'order'     => 'ASC',
			'show'      => 6,
            'orderby'   => 'modified',
            'select'    => 'all',
			'thumb'		=> true,
            'cats'      => array()
		);

        $instance = wp_parse_args( (array) $instance, $defaults );

		$title = apply_filters('widget_title', $instance['title'] );
		
        $args = array(
			'no_found_rows'			=> 1,
			'posts_per_page'	    => intval($instance['show']),
            'post_status'           => 'publish',
            'orderby'               => $instance['orderby'],
            'order'                 => $instance['order'],
            'no_found_rows'         => true,
            'ignore_sticky_posts'   => true,
            'tax_query'             => array( array(
                'taxonomy'          => 'category',
                'field'             => 'id',
                'terms'             => $instance['cats']
            ) )
        );

        switch( $instance['select'] ) {
            case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
            case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
            default: unset( $args['tax_query'] );
        }
        
        add_filter('posts_clauses', 'dt_core_join_left_filter');
        $query = new WP_Query( $args ); 
        remove_filter('posts_clauses', 'dt_core_join_left_filter');
		
		// caching!
		if ( $query->have_posts() ) {
			
			// get posts thumbnails id's
			$images = array();
			foreach ( $query->posts as $p ) {
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
		
        if ( $query->have_posts() ): 

		    echo $before_widget ;

		    // start
		    if( $title ) echo $before_title . $title . $after_title;
            $count = 0;
            while( $query->have_posts() ): $query->the_post(); $count++;
				$img = '';
				if( $instance['thumb'] && has_post_thumbnail() ) {
					$img_id = get_post_thumbnail_id();
					
					// get alt
					$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
					if ( !$img_alt ) { $img_alt = get_the_title(); }
					
					$img = dt_get_thumb_img( array(
						'alt'			=> $img_alt,
						'img_meta'		=> wp_get_attachment_image_src( $img_id, 'full' ),
						'href'			=> get_permalink(),
						'thumb_opts' 	=> array( 'w' => 50, 'h' => 50 )
						),
						'<a %HREF% class="alignleft img-post view" ><img %SRC% %SIZE% %ALT% /></a>',
						false
					);
				}
				
			?>

                <div class="post<?php echo (1 == $count?' ':''); ?>">
					<div class="post-bg">
						<?php echo $img; ?>
						<div class="post-inner">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						
							<div class="goto-post">
							<span class="ico-link date"><?php echo get_the_date(get_option('date_format'), get_the_ID()); ?></span>
<?php                        
                dt_get_comments_link(
                    '<span class="ico-link comments">%COUNT%</span>',
                    array( 'no_coments' => '' )
                );
?>							</div>
						</div>
					</div>
                </div>

                <?php
            endwhile;

        echo $after_widget;

        endif;

        wp_reset_postdata();
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['show'] = intval($new_instance['show']);
		$instance['thumb'] = isset($new_instance['thumb']);
        $instance['order'] = $new_instance['order'];
        $instance['orderby'] = $new_instance['orderby'];
        $instance['cats'] = array_map('intval', (array) $new_instance['cats']);

        if( !empty($new_instance['cats']) ) {
            $instance['select'] = $new_instance['select'];
        }else {
            $instance['select'] = 'all';
        }    
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 
			'title'     => '',
			'order'     => 'ASC',
			'show'      => 6,
            'orderby'   => 'date',
            'select'    => 'all',
			'thumb'		=> true,
            'cats'      => array()
		);
			
        $instance = wp_parse_args( (array) $instance, $defaults );

        $p_orderby = array(
            'ID'        => _x( 'Order by ID', 'backend orderby', LANGUAGE_ZONE ),
            'author'    => _x( 'Order by author', 'backend orderby', LANGUAGE_ZONE ),
            'title'     => _x( 'Order by title', 'backend orderby', LANGUAGE_ZONE ),
            'date'      => _x( 'Order by date', 'backend orderby', LANGUAGE_ZONE ),
            'modified'  => _x( 'Order by modified', 'backend orderby', LANGUAGE_ZONE ),
            'rand'      => _x( 'Order by rand', 'backend orderby', LANGUAGE_ZONE ),
            'menu_order'=> _x( 'Order by menu', 'backend orderby', LANGUAGE_ZONE )
        );

        ?>
        
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
		
        <p>
			<strong><?php _e('Show Posts from following categories:', LANGUAGE_ZONE); ?></strong><br />
            <?php 
            $terms = get_terms( 'category', array(
                'hide_empty'    => 1,
                'hierarchical'  => false 
            ) );

            if( !is_wp_error($terms) ): ?>

            <div class="dt-widget-switcher">

            <?php dt_core_mb_draw_radio_switcher(
                    $this->get_field_name( 'select' ),
                    $instance['select'],
                    array(
                        'all'       => array( 'desc' => __('All', LANGUAGE_ZONE) ),
                        'only'      => array( 'desc' => __('Only', LANGUAGE_ZONE) ),
                        'except'    => array( 'desc' => __('Except', LANGUAGE_ZONE) )
                    )
                );
            ?>
            
            </div>

            <div class="hide-if-js">

                <?php foreach( $terms as $term ): ?>

                <input id="<?php echo $this->get_field_id($term->term_id); ?>" type="checkbox" name="<?php echo $this->get_field_name('cats'); ?>[]" value="<?php echo $term->term_id; ?>" <?php checked( in_array($term->term_id, $instance['cats']) ); ?>/>
                <label for="<?php echo $this->get_field_id($term->term_id); ?>"><?php echo $term->name; ?></label><br />

                <?php endforeach; ?>

            </div>

            <?php else: ?>

            <span style="color: red;"><?php _e('There is no categories', LANGUAGE_ZONE); ?></span>

            <?php endif; ?>

        </p>

		<p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Show:', LANGUAGE_ZONE); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <?php foreach( $p_orderby as $value=>$name ): ?>
                <option value="<?php echo $value; ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        </p>
            <?php echo _e('Sort by:', LANGUAGE_ZONE);?>
            <label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="ASC" type="radio" <?php checked( $instance['order'], 'ASC' ); ?> /><?php _e('Ascending', LANGUAGE_ZONE); ?>
			</label>
			<label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="DESC" type="radio" <?php checked( $instance['order'], 'DESC' ); ?> /><?php _e('Descending', LANGUAGE_ZONE); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e('How many:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr($instance['show']); ?>" size="3" />
	    </p>
		
		<p>
			<input id="<?php echo $this->get_field_id('thumb'); ?>" type="checkbox" name="<?php echo $this->get_field_name('thumb'); ?>" <?php checked($instance['thumb']); ?>/>
			<label for="<?php echo $this->get_field_id('thumb'); ?>"><?php _e('Show featured images', LANGUAGE_ZONE); ?></label>
		</p>
		
		<div style="clear: both;"></div>
        
	<?php
	}

    function flush_widget_cache() {
		wp_cache_delete('dt_widget_popular_posts', 'dt_widget');
	}

}

/* Register the widget */
function dt_popular_posts_register() {
	register_widget( 'DT_popular_posts_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_popular_posts_register' );

?>
