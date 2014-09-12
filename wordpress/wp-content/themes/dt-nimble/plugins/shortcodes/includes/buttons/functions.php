<?php
add_shortcode( 'button_icon', 'dt_shortcode_button_icon' );
function dt_shortcode_button_icon( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'url'       => '#',
        'icon'      => 'address-book',
        'blank'     => '',
        'size'      => '',
        'colour'    => ''
    ), $atts ) );

    if ( 'true' == $blank || true == $blank || '1' == $blank || 't' == $blank ) { $blank = ' target="_blank"'; }

    $ico_path = DT_SHORTCODES_URL . '/includes/buttons/images/';
    $icon_url = $ico_path . $icon . '.png';
    $content = str_replace( array( '<br/>', '<p>', '</p>', '<br>' ), '', $content );

	$wrap_class = array( 'but-wrap' );
	if ( $colour ) { $wrap_class[] = $colour; }

	$link_class = array( 'button' );
	if ( $size ) { $link_class[] = $size; }

    $icon_img = '';
    if ( 'none' != $icon ) { $icon_img = '<img src="' . esc_url( $icon_url ) . '" width="20" height="20" title="" alt="' . $icon . '" />'; }

    $output = '<div class="' . esc_attr( implode( ' ', $wrap_class ) ) . '"><a href="' . esc_url( $url ) . '" class="' . esc_attr( implode( ' ', $link_class ) ) . '"' . $blank . '><span>' . $icon_img . trim( $content ) . '</span></a></div>';

    return $output;
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_buttons',
    'buttons',
    false
);
