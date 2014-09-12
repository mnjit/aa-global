<?php
add_shortcode( 'dt_twitter', 'dt_print_widget_twitter' );
function dt_print_widget_twitter( $atts ) {
    extract(
        shortcode_atts(
            array(
                'title'     => '',
                'username'  => '',
                'ppp'       => 6,
                'textlink'  => '',
                'autoslide' => '',
                'column'    => 'half'
            ),
            $atts
        )
    );

	$title = strip_tags($title);
    $username = strip_tags($username);
	$textlink = strip_tags($textlink);
	$ppp = abs(intval($ppp));
    $autoslide = abs(intval($autoslide));
    
    $args = array(
        'before_widget' => '<div class="' . esc_attr($column) .'">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    );
    
    ob_start();
    the_widget(
        'DT_Twitter_Widget',
        "title=$title&number=$ppp&username=$username&link=$textlink&autoslide=$autoslide",
        $args
    );
    $output = ob_get_clean();
    return $output;
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_twitter',
    'widget-twitter',
    false
);

add_filter( 'jpb_visual_shortcodes', 'dt_widget_twitter_images_filter' );
function dt_widget_twitter_images_filter( $shortcodes ) {
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_twitter',
            'image'     => DT_SHORTCODES_URL . '/images/space.png',
            'command'   => 'dt_mce_command-widget_twitter'
        )    
    );
    return $shortcodes;
}
