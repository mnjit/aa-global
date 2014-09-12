<?php

add_shortcode( 'dt_contact', 'dt_shortcode_widget_contact' );
function dt_shortcode_widget_contact( $atts ) {
    extract(
        shortcode_atts(
            array(
                'title'     => '',
                'text'      => '',
                'captcha'   => false,
                'column'    => 'half'
            ),
            $atts
        )
    );
    
    $args = array(
        'before_widget' => '<div class="' . esc_attr( $column ) .'">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    );

    ob_start();

    $params = array( 
        "title"             => strip_tags( $title ),
        "text"              => strip_tags( $text ),
        "enable_captcha"    => (bool) $captcha
    );

    the_widget( 'DT_contact_Widget', $params, $args );

    $output = ob_get_clean();
    return $output;
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_contact',
    'widget-contactform',
    false
);

add_filter( 'jpb_visual_shortcodes', 'dt_contact_widget_images_filter' );
function dt_contact_widget_images_filter( $shortcodes ) {
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_contact',
            'image'     => DT_SHORTCODES_URL . '/images/space.png',
            'command'   => 'dt_mce_command-widget_contact'
        )    
    );
    return $shortcodes;
}

