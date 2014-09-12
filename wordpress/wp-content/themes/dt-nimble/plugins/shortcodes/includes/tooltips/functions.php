<?php

add_shortcode( 'tooltip', 'dt_shortcode_tooltip' );
function dt_shortcode_tooltip( $atts, $content = null ) {
	extract( shortcode_atts( array(
		"title" => ''
	), $atts ) ); 

    return '<span class="tooltip">' . $title . '<span class="tooltip_c">' . trim( $content ) . '<span class="tooltip-b"></span></span></span>';
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_tooltips',
    'tooltips',
    false
);
