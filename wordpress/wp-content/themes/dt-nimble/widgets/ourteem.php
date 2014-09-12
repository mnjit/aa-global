<?php
/* Begin Widget Class */
class DT_ourteam_Widget extends WP_Widget {
    public $dt_defaults = array( 
		'title'     => '',
		'order'     => 'ASC',
		'show'      => 6,
        'desc'      => true,
        'orderby'   => 'modified',
        'select'    => 'all',
        'autoslide' => 0,
        'cats'      => array()
    );
    
	/* Widget setup  */
	function __construct () {  

        /* Widget settings. */
		$widget_ops = array( 'description' => _x( 'A widget with your team', 'widget ourteem', LANGUAGE_ZONE ) );

		/* Create the widget. */
        parent::__construct(
            'dt-ourteam-widget',
            DT_WIDGET_PREFIX . _x( 'Our team', 'widget ourteem', LANGUAGE_ZONE ),
            $widget_ops
        );
	}

	/* Display the widget  */
	function widget( $args, $instance ) {
        
		extract( $args );

        $instance = wp_parse_args( (array) $instance, $this->dt_defaults );

		/* Our variables from the widget settings. */
		$title = apply_filters('widget_title', $instance['title'] );
        $autoslide = $instance['autoslide'];
        $autoslide_on = $autoslide ? 1 : 0;

		global $wpdb;
        
        $args = array(
			'no_found_rows'		=> 1,
			'posts_per_page'	=> $instance['show'],
            'post_type'         => 'dt_team',
            'post_status'       => 'publish',
            'orderby'           => $instance['orderby'],
            'order'             => $instance['order'],
            'tax_query'         => array( array(
                'taxonomy'      => 'dt_team_category',
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
					'post__in'			=> $images
				) );
			}
		}
		
		echo $before_widget ;

		// start
		echo $before_title . $title . $after_title;
?>
        <div class="reviews-t coda-team">
<?php      
        if( $p_query->have_posts() ):
            
			// remove jetpack share buttons filter
			remove_filter( 'the_content', 'sharing_display', 19 );
			
            $data = array();
            foreach( $p_query->posts as $teammate ) {
                $teammate_data = get_post_meta( $teammate->ID, '_dt_team_info', true );
                $position = isset($teammate_data['position'])?$teammate_data['position']:'';
                $age = isset($teammate_data['age'])?'<br />' . $teammate_data['age']:'';

                $thumb_id = get_post_thumbnail_id($teammate->ID);
                if( has_post_thumbnail( $teammate->ID ) ) {
                    $thumb_meta = wp_get_attachment_image_src($thumb_id, 'full');
                }else {
                    $thumb_meta = null;
                }
				
				// get alt
				$img_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
				if ( !$img_alt ) { $img_alt = get_the_title($teammate->ID); }
				
                ob_start();
?>
                    <div class="team-wrap">
<?php
                dt_get_thumb_img( array(
                    'img_meta'      => $thumb_meta,
					'alt'			=> $img_alt,
                    'use_noimage'   => true,
                    'img_class'     => 'alignleft',
                    'thumb_opts'    => array( 'w' => 80, 'h' => 100 )
                    ),
                    '<img %SRC% %IMG_CLASS% %SIZE% %ALT% />'
                );
?>
                    <span class="head"><?php echo $teammate->post_title; ?></span>
                    
<?php               if( isset($position) || isset($age) ): ?>

                    <p class="mid-gray"><span><?php echo $position . $age; ?></span></p>

<?php               endif; ?>

                    <div class="team-description"><?php echo apply_filters( 'the_content', strip_shortcodes( $teammate->post_content ) ); ?></div>
                    </div>
<?php
                $str = ob_get_clean();
                $data[] = array( $str );
            }
            $auto_data = sprintf( 'data-autoslide="%s" data-autoslide_on="%s"', $autoslide, $autoslide_on ); 
            dt_get_coda_slider( array(
                'wrap'      => '<div class="list-carousel coda bx"><ul class="slider1" '.$auto_data.'>%SLIDER%</ul></div>',
                'item_wrap' => '<li>%1$s</li>', 
                'data'      => $data
            ) );
        endif;
?>

        </div>

<?php
		echo $after_widget;
	}

	/* Update the widget settings  */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
        $instance['show'] = abs(intval($new_instance['show']));
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
            'ID'        => _x( 'Order by ID', 'widget ourteem', LANGUAGE_ZONE ),
            'author'    => _x( 'Order by author', 'widget ourteem', LANGUAGE_ZONE ),
            'title'     => _x( 'Order by title', 'widget ourteem', LANGUAGE_ZONE ),
            'date'      => _x( 'Order by date', 'widget ourteem', LANGUAGE_ZONE ),
            'modified'  => _x( 'Order by modified', 'widget ourteem', LANGUAGE_ZONE ),
            'rand'      => _x( 'Order by rand', 'widget ourteem', LANGUAGE_ZONE ),
            'menu_order'=> _x( 'Order by menu', 'widget ourteem', LANGUAGE_ZONE )
        );

        ?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _ex( 'Title:', 'widget ourteem', LANGUAGE_ZONE ); ?></label>
            <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" class="widefat" />
		</p>
		<p>
			<strong><?php _ex( 'Show teammates from following categories:', 'widget ourteem', LANGUAGE_ZONE ); ?></strong><br />
            <?php 
            $terms = get_terms( 'dt_team_category', array(
                'hide_empty'    => 1,
                'hierarchical'  => false 
            ) );

            if ( ! is_wp_error( $terms ) && ! empty( $terms ) ): ?>

            <div class="dt-widget-switcher">

            <?php dt_core_mb_draw_radio_switcher(
                    $this->get_field_name( 'select' ),
                    $instance['select'],
                    array(
                        'all'       => array( 'desc' => _x( 'All', 'widget ourteem', LANGUAGE_ZONE ) ),
                        'only'      => array( 'desc' => _x( 'Only', 'widget ourteem', LANGUAGE_ZONE ) ),
                        'except'    => array( 'desc' => _x( 'Except', 'widget ourteem', LANGUAGE_ZONE ) )
                    )
                );
            ?>

            </div>

            <div class="hide-if-js">

                <?php foreach ( $terms as $term ): ?>

                <input id="<?php echo $this->get_field_id( $term->term_id ); ?>" type="checkbox" name="<?php echo $this->get_field_name( 'cats' ); ?>[]" value="<?php echo $term->term_id; ?>" <?php checked( in_array( $term->term_id, $instance['cats'] ) ); ?>/>
                <label for="<?php echo $this->get_field_id( $term->term_id ); ?>"><?php echo $term->name; ?></label><br />

                <?php endforeach; ?>

            </div>

            <?php else: ?>

            <span style="color: red;"><?php _ex( 'There is no categories', 'widget ourteem', LANGUAGE_ZONE ); ?></span>

            <?php endif; ?>

        </p>
		<p>
            <label for="<?php echo $this->get_field_id( 'orderby' ); ?>"><?php _ex( 'Show:', 'widget ourteem', LANGUAGE_ZONE ); ?></label>
            <select id="<?php echo $this->get_field_id( 'orderby' ); ?>" name="<?php echo $this->get_field_name( 'orderby' ); ?>">
                <?php foreach( $p_orderby as $value=>$name ): ?>
                <option value="<?php echo $value; ?>" <?php selected( $instance['orderby'], $value ); ?>><?php echo $name; ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        </p>
            <?php echo _ex( 'Sort by:', 'widget ourteem', LANGUAGE_ZONE ); ?>
            <label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="ASC" type="radio" <?php checked( $instance['order'], 'ASC' ); ?> /><?php _ex( 'Ascending', 'widget ourteem', LANGUAGE_ZONE ); ?>
			</label>
			<label>
            <input name="<?php echo $this->get_field_name( 'order' ); ?>" value="DESC" type="radio" <?php checked( $instance['order'], 'DESC' ); ?> /><?php _ex( 'Descending', 'widget ourteem', LANGUAGE_ZONE ); ?>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'show' ); ?>"><?php _ex( 'How many:', 'widget ourteem', LANGUAGE_ZONE ); ?></label>
            <input id="<?php echo $this->get_field_id( 'show' ); ?>" name="<?php echo $this->get_field_name( 'show' ); ?>" value="<?php echo esc_attr( $instance['show'] ); ?>" size="3" />
	    </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'autoslide' ); ?>"><?php _ex( 'Autoslide:', 'widget ourteem', LANGUAGE_ZONE ); ?></label>
            <input id="<?php echo $this->get_field_id( 'autoslide' ); ?>" name="<?php echo $this->get_field_name( 'autoslide' ); ?>" value="<?php echo esc_attr( $instance['autoslide'] ); ?>" size="4" />
			<em><?php _ex( 'milliseconds<br /> (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")', 'widget ourteem', LANGUAGE_ZONE ); ?></em>
	    </p>
		
		<div style="clear: both;"></div>
	<?php
	}
}

/* Register the widget */
function dt_ourteam_register() {
	register_widget( 'DT_ourteam_Widget' );
}

/* Load the widget */
add_action( 'widgets_init', 'dt_ourteam_register' );
?>