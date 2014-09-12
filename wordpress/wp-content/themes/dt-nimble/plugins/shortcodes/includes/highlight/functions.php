<?php

add_shortcode( 'highlight', 'dt_shortcode_highlight' );
function dt_shortcode_highlight( $atts, $content = null ) {
	
	//extracts our attrs . if not set set default
	extract( shortcode_atts( array(
		'color' => 'light'
	), $atts ) );
	
	switch( $color ) {
		case 'blue':
			$class = 'highlight-blue';
			break;
		
		case 'orange':
			$class = 'highlight-orange';
			break;
		
		case 'green':
			$class = 'highlight-green';
			break;
		
		case 'purple':
			$class = 'highlight-purple';
			break;
		
		case 'pink':
			$class = 'highlight-pink';
			break;
		
		case 'red':
			$class = 'highlight-red';
			break;
		
		case 'grey':
			$class = 'highlight-grey';
			break;
		
		case 'light':
			$class = 'highlight-light';
			break;
		
		case 'black':
			$class = 'highlight-black';
			break;
			
		case 'yellow':
			$class = 'highlight-yellow';
			break;
	}
	return '<span class="dt-highlight '.$class.'">' . trim( $content ) . '</span>';
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_highlight',
    'highlight',
    false
);
