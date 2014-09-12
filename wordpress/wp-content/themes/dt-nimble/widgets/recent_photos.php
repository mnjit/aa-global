<?php
/* Begin Widget Class */
class DT_latest_photo_Widget extends WP_Widget {

	public static $default_instance = array(
		'title' 	=> '',
		'show'  	=> 6,
		'order'		=> 'ASC',
		'orderby'	=> 'rand',
		'select'	=> 'all',
		'cats'		=> array(),
	);

	public static $orderby_reference = array();
	public static $order_reference = array( 'DESC', 'ASC' );
	public static $select_reference = array( 'all', 'except', 'only' );

	public static function dt_sanitize_enum( $value, $reference = array() ) {
		if ( !in_array($value, $reference) ) return current($reference);
		return $value;
	}

	/* Widget setup  */
	function __construct() {  
		
		if ( empty(self::$orderby_reference) ) {
			self::$orderby_reference = array(
            	'date'      			=> _x( 'Order by date', 'backend orderby', LANGUAGE_ZONE ),
            	'ID'        			=> _x( 'Order by ID', 'backend orderby', LANGUAGE_ZONE ),
            	'name'      			=> _x( 'Order by name', 'backend orderby', LANGUAGE_ZONE ),
            	'modified'  			=> _x( 'Order by modified', 'backend orderby', LANGUAGE_ZONE ),
            	'rand'      			=> _x( 'Order by rand', 'backend orderby', LANGUAGE_ZONE ),
            	'parent menu_order'		=> _x( 'Order by parent', 'backend orderby', LANGUAGE_ZONE ),
			 ); 
		}

        /* Widget settings. */
		$widget_ops = array( 'description' => __('A widget with photos from your albums', 'dt') );

		/* Widget control settings. */
		$control_ops = array( 'width' => 250, 'height' => 250, 'id_base' => 'dt-latest-photo-widget' );

		/* Create the widget. */
        parent::__construct(
            'dt-latest-photo-widget',
            DT_WIDGET_PREFIX . __('Small photos', LANGUAGE_ZONE),
            $widget_ops,
            $control_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
        $this->dt_hs_group++;
        
        $instance = wp_parse_args( (array) $instance, self::$default_instance );

		extract( $args );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		
		$args = array(
			'no_found_rows'		=> 1,
			'post_type'			=> 'dt_gallery',
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
			'tax_query'         => array( array(
                'taxonomy'      => 'dt_gallery_category',
                'field'         => 'id',
                'terms'         => $instance['cats']
            ) ),
		);
		
		switch( $instance['select'] ) {
            case 'only': $args['tax_query'][0]['operator'] = 'IN'; break;
            case 'except': $args['tax_query'][0]['operator'] = 'NOT IN'; break;
            default: unset( $args['tax_query'] );
        }

        add_filter( 'posts_clauses', 'dt_core_join_left_filter' );
        $g_query = new Wp_Query( $args );
        remove_filter( 'posts_clauses', 'dt_core_join_left_filter' );

		$g_arr = array();
		if ( count( $g_query->posts ) ) {
			foreach ( $g_query->posts as $album ) {
				if ( post_password_required( $album->ID ) ) { continue; }
				$g_arr[] = $album->ID;
			}
		}

		dt_storage( 'where_filter_param', implode( ', ', $g_arr ) );
		
		$args = array(
			'no_found_rows'		=> 1,
			'posts_per_page'	=> $instance['show'],
			'post_type'			=> 'attachment',
			'post_mime_type'	=> 'image',
			'post_status' 		=> 'inherit',
			'orderby'			=> $instance['orderby'],
			'order'				=> $instance['order'],
		);
		
        add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
		$p_query = new Wp_Query( $args );
        remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );
		
        $hs_slideshow_group = 'dt_widget_latphotos_' . intval( $this->dt_hs_group );

		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
			
		echo '<div class="flickr" data-hs_group="' . $hs_slideshow_group . '">';
		
		if ( $p_query->have_posts() ) {
			foreach ( $p_query->posts as $photo ) {

                if ( post_password_required( $photo->post_parent ) ) { continue; }

                $caption = $photo->post_excerpt;
				
				dt_get_thumb_img ( array(
					'img_meta'		=> wp_get_attachment_image_src( $photo->ID, 'full' ),
					'class'			=> 'alignleft-f',
					'title'			=> esc_attr( $caption ),
					'alt'			=> get_post_meta( $photo->ID, '_wp_attachment_image_alt', true ),
					'custom'		=> ' onclick="return hs.expand(this, { slideshowGroup: \'' . $hs_slideshow_group . '\' } )"',
					'thumb_opts'	=> array( 'w' => 69, 'h' => 69 )
				) );
/*				
                if ( $caption && 0 )
                    echo '<div class="highslide-caption">'.$caption.'</div>';
*/
			}
		}
		
		echo '</div><!-- /.flickr -->';
	
		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show'] = absint( $new_instance['show'] );
        $instance['order'] = $this->dt_sanitize_enum( $new_instance['order'], self::$order_reference);
        $instance['orderby'] = $this->dt_sanitize_enum( $new_instance['orderby'], array_keys(self::$orderby_reference) );
        
	    $instance['select'] = $this->dt_sanitize_enum( $new_instance['select'], self::$select_reference );
        
        if ( 'all' == $instance['select'] ) {
    		$instance['cats'] = array();
    	} else if ( !empty( $new_instance['cats'] ) ) {
	        $instance['cats'] = array_map( 'absint', (array) $new_instance['cats'] );
    	} else {
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
		$instance = wp_parse_args( (array) $instance, self::$default_instance );

		// for compatibility
		$instance['order'] = $this->dt_sanitize_enum( $instance['order'], self::$order_reference );
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', LANGUAGE_ZONE); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr($instance['title']); ?>" class="widefat" />
		</p>

		<p>
			<strong><?php _e('Show photos from albums in following categories:', LANGUAGE_ZONE); ?></strong><br />
            <?php 
            $terms = get_terms( 'dt_gallery_category', array('hide_empty' => 1, 'hierarchical' => false) );

            if ( !is_wp_error( $terms ) ) :
            ?>

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

            <span style="color: red;"><?php echo $terms->get_error_message(); ?></span>

            <?php endif; ?>

        </p>
		
		<p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _e('Show:', LANGUAGE_ZONE); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <?php foreach( self::$orderby_reference as $value=>$name ): ?>
                <option value="<?php echo $value; ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        
        </p>
            <?php _e('Sort by:', LANGUAGE_ZONE); ?>
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
		
		<div style="clear: both;"></div>
	<?php
	}
}

/* Register the widget */
function dt_latest_photo_register() {
	register_widget( 'DT_latest_photo_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_latest_photo_register' );
