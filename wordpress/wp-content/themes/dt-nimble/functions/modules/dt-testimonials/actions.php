<?php

// admin testimonials list category column action
function dt_a_testimonials_col_cat($column_name, $id){
    if( 'dt_testimonials_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_testimonials' == $post_type ) {
            $taxonomy = 'dt_testimonials_category';
        }else {
            return false;
        }

        $categories = '';
        $before = '';
        $after = '';
        $sep = ', ';
        $terms = get_the_terms( $id, $taxonomy );
  
        if( $terms ) {
            foreach ( $terms as $term ) {
                $link = add_query_arg( array( 'post_type' => $post_type, $taxonomy => $term->slug ), admin_url( 'edit.php' ) );
                $term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . ' (' . $term->term_id . ')' . '</a>';
            }
            $categories = $before . join( $sep, $term_links ) . $after;
        }

        echo $categories;

    }
}
add_action('manage_posts_custom_column', 'dt_a_testimonials_col_cat', 5, 2);

add_action( 'dt_layout_before_loop', 'dt_testimonials_layout_init', 10, 1 );
function dt_testimonials_layout_init( $layout ) {
    
    if( 'dt-testimonials' != $layout ) {
        return false;
    }
    
    global $post, $DT_QUERY;
    
	$defaults = array(
		'content_position'	=> 'top',
        'orderby'           => 'date',
        'order'             => 'DESC',
        'ppp'               => ''
    );
	
	$opts = get_post_meta( $post->ID, '_dt_meta_testimonials_options', true );
    $cats = get_post_meta( $post->ID, '_dt_meta_testimonials_list', true );
	
	$opts = wp_parse_args( $opts, $defaults );
   
    if ( !$paged = get_query_var('page') ) {
        $paged = get_query_var('paged');
    }

    $args = array(
        'post_type' => 'dt_testimonials',
        'order'     => $opts['order'],
        'orderby'   => $opts['orderby'],
        'status'    => 'publish',
        'paged'     => $paged
    );

    if ( $opts['ppp'] ) {
        $args['posts_per_page'] = $opts['ppp'];
    }
	
	if ( !isset( $cats['testimonials_cats'] ) ) {
        $cats['testimonials_cats'] = array();
		$cats['select'] = 'all';
    }else {
        $cats['testimonials_cats'] = array_map( 'absint', array_values( $cats['testimonials_cats'] ) );
    }
	
	if ( 'all' != $cats['select'] ) {
		$args['tax_query'] = array( array(
			'taxonomy'  => 'dt_testimonials_category',
			'field'     => 'id',
			'operator'  => 'IN',
			'terms'		=> $cats['testimonials_cats']
		) );
		
		if ( 'except' == $cats['select'] ) {
			$args['tax_query'][0]['operator'] = 'NOT IN';
		}
	}
	
    $DT_QUERY = new WP_Query( $args ); 
    
    if( $DT_QUERY->have_posts() ) {
        $thumb_arr = dt_core_get_posts_thumbnails( $DT_QUERY->posts );
        dt_storage( 'thumbs_array', $thumb_arr['thumbs_meta'] );
    }
	dt_storage( 'post_is_first', 1 );
}
