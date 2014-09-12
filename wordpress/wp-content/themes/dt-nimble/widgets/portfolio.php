<?php
/* Begin Widget Class */
class DT_portfolio_Widget extends WP_Widget {
    public $dt_defaults = array( 
		'title'     	=> '',
		'thumb_height'	=> '',
		'order'     	=> 'ASC',
		'show'      	=> 6,
        'desc'      	=> true,
        'orderby'   	=> 'modified',
        'select'    	=> 'all',
        'autoslide' 	=> 0,
        'cats'      	=> array()
    );

	/* Widget setup  */
	function __construct() {  
        /* Widget settings. */
		$widget_ops = array( 'description' => __('A widget with portdolio', LANGUAGE_ZONE) );

		/* Create the widget. */
        parent::__construct(
            'dt-portfolio-widget',
            DT_WIDGET_PREFIX . __('Portfolio', LANGUAGE_ZONE),
            $widget_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
        
		extract( $args );

        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters( 'widget_title', $instance['title'] );
        $autoslide = $instance['autoslide'];
        $autoslide_on = $autoslide ? 1 : 0;
		
		global $wpdb;
        
        $args = array(
			'no_found_rows'		=> 1,
			'posts_per_page'	=> $instance['show'],
            'post_type'         => 'dt_portfolio',
            'post_status'       => 'publish',
            'orderby'           => $instance['orderby'],
            'order'             => $instance['order'],
            'tax_query'         => array( array(
                'taxonomy'      => 'dt_portfolio_category',
                'field'         => 'id',
                'terms'         => $instance['cats']
            ) ),
        );

        switch( $instance['select'] ) {
            case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
            case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
            default: unset( $args['tax_query'] );
        }

        add_filter('posts_clauses', 'dt_core_join_left_filter');
        $p_query = new WP_Query( $args ); 
        remove_filter('posts_clauses', 'dt_core_join_left_filter');
		
		// caching!
		if ( $p_query->have_posts() ) {
			
			$images = array();
			foreach ( $p_query->posts as $p ) {
				if ( has_post_thumbnail( $p->ID ) ) {
					$images[] = get_post_thumbnail_id( $p->ID );
				}
			}
			
			if ( $images ) {
				$i_query = new WP_Query( array(
					'no_found_rows'		=> 1,
					'posts_per_page'    => -1,
					'post_type'			=> 'attachment',
					'post_status' 		=> 'inherit',
					'orderby'			=> 'menu_order',
					'post__in'			=> $images
				) );
			}
		}
		
        // for usage as shortcode 
        if ( ! isset( $img_size ) ) {
			$h = 130;
			if ( $instance['thumb_height'] ) { $h = $instance['thumb_height']; }
            $img_size = array( 210, $h );
        }
		
		if ( ! isset( $img_size_origin ) ) {
			$img_size_origin = $img_size;
		} else {
			$p = $img_size[1] / $img_size[0];
			$img_size_origin[1] = round( $img_size_origin[0] * $p ); 
		}
		
        if ( ! isset( $lines ) ) { $lines = 1; }
         
		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
        ?>	
        
        <div class="list-carousel recent bx dt-portf">
            <ul class="slider1" data-autoslide="<?php echo $autoslide; ?>" data-autoslide_on="<?php echo $autoslide_on; ?>">

        <?php
        if ( $p_query->have_posts() ) {

            $class = ' first';
            $lements_arr = array();
            while( $p_query->have_posts() ) {
				$p_query->the_post();
                
				$thumb_id = get_post_thumbnail_id( get_the_ID() );
                if ( ! has_post_thumbnail( get_the_ID() ) ) {
					$args = array(
						'posts_per_page'    => 1,
						'no_found_rows'		=> 1,
						'post_type'			=> 'attachment',
						'post_mime_type'	=> 'image',
						'post_parent'       => get_the_ID(),
						'post_status' 		=> 'inherit'
					);
					$images = new WP_Query( $args );
					if ( $images->have_posts() ) { $thumb_id = $images->posts[0]->ID; }
                }
                $thumb_meta = wp_get_attachment_image_src( $thumb_id, 'full' );

                ob_start(); 
            ?>
                <div class="textwidget<?php echo $class; ?>">
					<?php
					$img = dt_get_thumb_img( array(
						'class'         => 'photo',
						'alt'			=> get_post_meta( $thumb_id, '_wp_attachment_image_alt', true ),
						'img_meta'      => $thumb_meta ? $thumb_meta : null,
						'use_noimage'   => true,
						'title'         => get_the_title(),
						'href'          => get_permalink(),
						'thumb_opts'    => array( 'w' => $img_size_origin[0], 'h' => $img_size_origin[1] )
						),
						"\n".'<div class="textwidget-photo">'."\n".'<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% ' . image_hwstring( $img_size[0], $img_size[1] ) . ' %ALT% /></a>'."\n".'</div>'."\n"
					);

					if ( $instance['desc'] ):
					?>
                        <div class="widget-info">    
                            <h3><a href="<?php echo get_permalink(); ?>" class="head"><?php echo get_the_title(); ?></a></h3>
                            <p><?php echo strip_tags( get_the_excerpt() ); ?></p>
                        </div>
                    <?php endif; ?>
                </div>    
                <?php
                $items_arr[] = ob_get_clean();
				$class = '';
            } // while have posts
			wp_reset_postdata();
        } // if have posts

        $items_arr = array_chunk( $items_arr, $lines );
        foreach( $items_arr as $chunk ) {
            echo "\n" . '<li>' . "\n" . implode( "\n", $chunk ) . "\n" . '</li>' . "\n"; 
        }
        ?>

			</ul>
        </div>

        <?php
		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['show'] = abs( intval( $new_instance['show'] ) );
		
		$thumb_height = abs( intval( $new_instance['thumb_height'] ) );
        $instance['thumb_height'] = $thumb_height ? $thumb_height : '';
        
		$instance['order'] = strip_tags($new_instance['order']);
        $instance['orderby'] = strip_tags($new_instance['orderby']);
        $instance['cats'] = array_map('intval', (array) $new_instance['cats']);
        $instance['select'] = !empty($instance['cats'])?strip_tags($new_instance['select']):'all';
        $instance['autoslide'] = abs(intval($new_instance['autoslide']));
        $instance['desc'] = (bool) $new_instance['desc'];
		return $instance;
	}

	/**
	 * Displays the widget settings controls on the widget panel.
	 * Make use of the get_field_id() and get_field_name() function
	 * when creating your form elements. This handles the confusing stuff.
	 */
	function form( $instance ) {

		/* Set up some default widget settings. */
        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );
			
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
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>
        <p>
			<strong><?php _e( 'Show Projects from following categories:', LANGUAGE_ZONE ); ?></strong><br />
            <?php 
            $terms = get_terms( 'dt_portfolio_category', array(
                'hide_empty'    => 1,
                'hierarchical'  => false 
            ) );

            if ( ! is_wp_error( $terms ) ): ?>

            <div class="dt-widget-switcher">

            <?php dt_core_mb_draw_radio_switcher(
                    $this->get_field_name( 'select' ),
                    $instance['select'],
                    array(
                        'all'       => array( 'desc' => __( 'All', LANGUAGE_ZONE ) ),
                        'only'      => array( 'desc' => __( 'Only', LANGUAGE_ZONE ) ),
                        'except'    => array( 'desc' => __( 'Except', LANGUAGE_ZONE ) )
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

            <span style="color: red;"><?php _e( 'There is no portfolio items assigned to any category', LANGUAGE_ZONE ); ?></span>

            <?php endif; ?>

        </p>
        <p>
			<label for="<?php echo $this->get_field_id( 'desc' ); ?>"><?php _e('Show hovering description:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'desc' ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'desc' ); ?>" <?php checked( $instance['desc'] ); ?> />
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
			<label for="<?php echo $this->get_field_id( 'thumb_height' ); ?>"><?php _e( 'Thumbnail Height:', LANGUAGE_ZONE ); ?></label>
            <input id="<?php echo $this->get_field_id( 'thumb_height' ); ?>" name="<?php echo $this->get_field_name( 'thumb_height' ); ?>" value="<?php echo esc_attr( $instance['thumb_height'] ); ?>" size="3" maxlength="3" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _e('How many:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr($instance['show']); ?>" size="2" maxlength="2" />
	    </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoslide' ); ?>"><?php _e('Autoslide:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'autoslide' ); ?>" name="<?php echo $this->get_field_name( 'autoslide' ); ?>" value="<?php echo esc_attr($instance['autoslide']); ?>" size="6" maxlength="6" />
			<em>milliseconds<br /> (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")</em>
	    </p>
		
		<div style="clear: both;"></div>
	<?php
	}
}

/* Register the widget */
function dt_portfolio_register() {
	register_widget( 'DT_portfolio_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_portfolio_register' );
?>
