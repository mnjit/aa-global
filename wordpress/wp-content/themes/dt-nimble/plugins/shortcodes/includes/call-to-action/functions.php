<?php

add_shortcode( 'call_to_action', 'dt_shortcode_call_to_action' );
function dt_shortcode_call_to_action( $atts, $content = null ) {
	//extracts our attrs . if not set set default
    extract( shortcode_atts( array(
        'url'       	=> '',
        'blank'     	=> '',
        'size'      	=> '',
		'button_text'	=> '',
        'colour'    	=> ''
    ), $atts ) );

	$button = '</div>';
	if ( $url ) {
		$optional = '';
		$optional .= ' icon="none"';
		$optional .= $blank?' blank="true"':'';
		$optional .= $size?' size="'. $size. '"':'';
		$optional .= $colour?' colour="'. $colour. '"':'';

		$button .= do_shortcode( sprintf( '[button_icon url="%s"%s]%s[/button_icon]', $url, $optional, $button_text ) );
	}

    return '<div class="about"><div class="about-cont"><div class="about-iiner">' . do_shortcode( trim( $content ) ) . $button . '</div></div>'; 
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_call_to_action',
    'call-to-action',
    false
);
