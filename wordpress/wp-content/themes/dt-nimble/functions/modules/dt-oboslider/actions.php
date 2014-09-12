<?php

// custom mediauploader tab action
function dt_a_obo_slider_mu() {
    $errors = array();

    if ( !empty($_POST) ) {
        $return = media_upload_form_handler();

        if ( is_string($return) )
            return $return;
        if ( is_array($return) )
            $errors = $return;
    }

    wp_enqueue_style( 'media' );
    wp_enqueue_script('admin-gallery');
    
    return wp_iframe( 'dt_obo_slider_media_form', $errors );
}
add_action( 'media_upload_dt_obo_slider_media', 'dt_a_obo_slider_mu' );

// admin slider list thumbnail column action
function dt_a_obo_slider_col_thumb($column_name, $id){
	if($column_name === 'dt_obo_slider_thumbs'){
		dt_admin_thumbnail( $id );
    }
}
add_action('manage_posts_custom_column', 'dt_a_obo_slider_col_thumb', 5, 2);

// admin list category column action
function dt_a_obo_slider_col_cat($column_name, $id){
    if( 'dt_obo_slider_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_obo_slider' == $post_type ) {
            $taxonomy = 'dt_obo_slider_category';
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
add_action( 'manage_posts_custom_column', 'dt_a_obo_slider_col_cat', 5, 2 );

// mod some jetpack features
if ( function_exists( 'dt_remove_jetpack_sharebuttons' ) ) {
	add_action( 'dt_layout_before_header-oboslider', 'dt_remove_jetpack_sharebuttons' );
}
