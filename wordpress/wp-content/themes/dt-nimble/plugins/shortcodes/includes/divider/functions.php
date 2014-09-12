<?php

add_shortcode( 'dt_divider', 'dt_shortcode_divider' );
function dt_shortcode_divider( $atts, $content = null ) {
    extract( shortcode_atts( array(
		'style' => 'wide'
    ), $atts));
    
    switch( $style ) {
        case 'wide': $class = 'hr hr-wide gap-big'; break;
        case 'narrow': $class = 'hr hr-narrow gap-small'; break;
        case 'double-gap': $class = 'double-gap'; break;
        default: $class = 'gap';
    }
    
    $output = '<div class="' . esc_attr( $class ) . '"></div>';
    
    return $output; 
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_divider',
    'divider',
    false
);
