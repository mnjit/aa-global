<?php

add_shortcode( 'accordion', 'dt_shortcode_accordion' );
function dt_shortcode_accordion( $atts, $content = null ) {
    extract( shortcode_atts( array( "title" => '' ), $atts ) );

    if ( $title ) { $title = '<h2>' . esc_attr($title) . '</h2>'; }
    return $title . '<div class="basic list1b">' . do_shortcode( $content ) . '</div>';
}

add_shortcode( 'acc_item', 'dt_shortcode_accordion_item' );
function dt_shortcode_accordion_item( $atts, $content = null ) {
    extract( shortcode_atts( array( "title" => '', 'selected' => false ), $atts) );
    
    if ( $title )
        $title = '<a class="accheader' . ( $selected ? ' selected' : '' ) . '"><i class="q_a"></i>' . $title . '</a>';

    $output = '';
    //returns
    return $output.'<div class="accord' . ( $selected ? ' selected' : '' ) . '">' . $title . '<div>' . force_balance_tags( do_shortcode( $content ) ) . '</div></div>';
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_accordion',
    'accordion',
    false
);
