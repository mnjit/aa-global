<?php
function dt_style_options_get_image( $params, $img_1, $img_2 = '', $use_second_img = false ) {
    if( (!$img_1 || 'none' == $img_1) && (!$img_2 || 'none' == $img_2) )
        return 'none;';
    
    if( (!$img_1 || 'none' == $img_1) && !$use_second_img ) {
        return 'none;';
    }
    
    $defaults = array(
        'repeat'    => 'repeat',
        'x-pos'     => 0,
        'y-pos'     => 0,
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    $output = get_stylesheet_directory_uri() . $img_1;
    if( $use_second_img && $img_2 ) {
		if( !parse_url($img_2, PHP_URL_SCHEME) ) {
			$output = site_url($img_2);
		}else {
			$output = $img_2;
		}
//        $output = site_url() . $img_2;
    }
    $output = sprintf(
        'url(%s)%s;',
        esc_url($output),
        ($params['important']?' !important':'')
    );
    return $output;
}

function dt_style_options_get_bg_position ( $y, $x ) {
    return sprintf( '%s %s !important;', $y, $x );
}

function dt_style_options_get_opacity ( $opacity = 0 ) {
	$opacity = ($opacity > 0)?$opacity/100:0;
	return $opacity;
}

function dt_style_options_get_rgba_from_hex_color ( $params, $color, $opacity = 0 ) {
    $defaults = array(
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    if( is_array($color) ) {
        $rgb_array = array_map('intval', $color);    
    }else {
        $color = str_replace('#', '', $color);
        $rgb_array = str_split($color, 2);
        if( is_array($rgb_array) && count($rgb_array) == 3 ) {
            $rgb_array = array_map('hexdec', $rgb_array);
        }else {
            return 'inherit';
        }
    }

    return sprintf( 'rgba(%d,%d,%d,%s)', $rgb_array[0], $rgb_array[1], $rgb_array[2], dt_style_options_get_opacity( $opacity ) );
}

function dt_style_options_get_rgba_from_hex_color_for_ie( $params, $color, $opacity = 0 ) {
    $defaults = array(
        'important' => true
    );
    $params = wp_parse_args( $params, $defaults );

    if( is_array($color) ) {
        $hex_color = implode( '', $color );   
    }else{
        $hex_color = str_replace( '#', '', $color );
    }
	
    $hex_opacity = ( $opacity > 0 ) ? dechex( round( $opacity * 2.55 ) ) : '00';
	
	if ( strlen( (string) $hex_opacity ) < 2 )
		$hex_opacity = '0'. $hex_opacity;
	
    return sprintf(
        'progid:DXImageTransform.Microsoft.gradient(startColorstr=#%2$s%1$s,endColorstr=#%2$s%1$s)',
        $hex_color, $hex_opacity
    );
}

function dt_get_shadow_color( $color, $params = ' 1px 1px 0' ) {
	$shadow = 'none';
	if( $color )
		$shadow = $color. $params;
	return $shadow;
}
