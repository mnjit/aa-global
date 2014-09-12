<?php

function dt_core_parents_where_filter( $where ) {
    if( function_exists('dt_storage') ) {
        global $wpdb;
    	$param = dt_storage('where_filter_param');
    	dt_storage('where_filter_param', false);
	    if( $param ) {
            $where .= sprintf( " AND $wpdb->posts.post_parent IN(%s)", strip_tags( $param ) );
        }else {
            $where .= ' AND 1=0';
        }
    }    
    return $where;
}

function dt_core_join_left_filter( $parts ) {
    if( isset($parts['join']) && !empty($parts['join']) ) {
        $parts['join'] = str_replace( 'INNER', 'LEFT', $parts['join']);
    }
    return $parts;
}

function dt_core_media_item_remove_insert_button( $args = array() ) {
	if( isset($args['send']) )
		$args['send'] = false;
	return $args;
}

function dt_inset_into_post_filter ( $html, $id, $caption, $title, $align, $url ) {
	if ( isset( $url ) && false === strpos( $html, 'rel' ) ) {
		$html = str_replace( 'href=', 'class="highslide" onclick="return hs.expand(this)" href=', $html );
	}
	return $html;
}
add_filter( 'image_send_to_editor', 'dt_inset_into_post_filter', 10, 6 );
