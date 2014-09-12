<?php

function dt_photos_get_by_albums( array $albums_ids, array $term_ids = array(), $select = 'all' ) {
    
    $args = array(
        'post_type'         => 'dt_gallery',
        'post_status'       => 'publish',
        'posts_per_page'    => -1
    );

    $args['tax_query'] = array( array(
        'taxonomy'  => 'dt_gallery_category',
        'field'     => 'id',
        'operator'  => 'IN'
    ) );

    $args['tax_query'][0]['terms'] = implode(',', array_map('intval', array_values($term_ids)));

    switch( $select ) {
        case 'only': $args['post__in'] = array_values($albums_ids); break;
        case 'except': $args['post__not_in'] = array_values($albums_ids);
    }

    add_filter('posts_clauses', 'dt_core_join_left_filter');
    $query = new WP_Query( $args ); 
    remove_filter('posts_clauses', 'dt_core_join_left_filter');

    $output = array();
    if( $query->have_posts() ) {
        foreach( $query->posts as $album ) {
            $output[] = $album->ID;
        }
    }
    $output = implode(',', $output);

    return $output;
}

function dt_photos_get_by_category( array $ids, $select = 'all' ) {
    global $wpdb;

    $query_str = '';

    $args = array(
        'post_type'     => 'dt_gallery',
        'post_status'   => 'publish'
    );
    
    if( 'all' != $select ) {
        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_gallery_category',
            'field'     => 'id',
            'terms'     => array_values($ids)
        ) );
        
        if( 'only' == $select ) {
            $args['tax_query'][0]['operator'] = 'IN';
        }else {
            $args['tax_query'][0]['operator'] = 'NOT IN';
        }
    }

    add_filter('posts_clauses', 'dt_core_join_left_filter');
    $query = new WP_Query($args);
    remove_filter('posts_clauses', 'dt_core_join_left_filter');

    if( $query->have_posts() ) {
        foreach( $query->posts as $item ) {
            $query_str[] = $item->ID;
        }
        $query_str = implode(',', $query_str);
    }

    return $query_str;
}

?>