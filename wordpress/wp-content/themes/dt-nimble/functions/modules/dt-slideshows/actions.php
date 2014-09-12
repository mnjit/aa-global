<?php

// custom mediauploader tab action
function dt_a_slider_mu() {
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
    
    return wp_iframe( 'dt_slider_media_form', $errors );
}
add_action( 'media_upload_dt_slider_media', 'dt_a_slider_mu' );

// admin slider list thumbnail column action
function dt_a_slider_col_thumb($column_name, $id){
	if ( $column_name === 'dt_slider_thumbs' ) {
		dt_admin_thumbnail( $id );
    }
}
add_action('manage_posts_custom_column', 'dt_a_slider_col_thumb', 5, 2);

// mod some jetpack features
if ( function_exists( 'dt_remove_jetpack_sharebuttons' ) ) {
	add_action( 'dt_layout_before_header-slideshow', 'dt_remove_jetpack_sharebuttons' );
}
