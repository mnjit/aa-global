<?php

add_shortcode( 'framed_video', 'dt_shortcode_video' );
function dt_shortcode_video( $atts, $content = null ) {
	extract( shortcode_atts( array(
        "column"    => 'half'
	), $atts ) ); 

    $sizes_full = array(
        'one-fourth'    => array( 209 ),
        'three-fourth'  => array( 709 ),
        'one-third'     => array( 291 ),
        'two-thirds'    => array( 627 ),
        'half'          => array( 459 ),
        'full-width'    => array( 959 )
    );

    $sizes = array(
        'one-fourth'    => array( 147 ),
        'three-fourth'  => array( 523 ),
        'one-third'     => array( 209 ),
        'two-thirds'    => array( 459 ),
        'half'          => array( 336 ),
        'full-width'    => array( 711 )
    );
    
    $video_width = null;

    if( !dt_storage('have_sidebar') && isset($sizes_full[$column]) )
        $video_width = current($sizes_full[$column]);
    elseif( dt_storage('have_sidebar') && isset($sizes[$column]) )
        $video_width = current($sizes[$column]);

    return '<div class="' . esc_attr( $column ) . '"><div class="videos">' . dt_get_embed( $content, $video_width, null, false ) . '</div></div>';
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_video',
    'framed-video',
    false
);
