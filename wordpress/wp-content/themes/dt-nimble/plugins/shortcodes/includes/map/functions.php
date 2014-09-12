<?php

add_shortcode( 'google_map', 'dt_shortcode_google_map' );
function dt_shortcode_google_map( $atts, $content = null ) {
    return '<div class="map">' . trim( $content ) . '</div>';
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_google_map',
    'map',
    false
);
