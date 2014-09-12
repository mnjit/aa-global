<?php

add_shortcode( 'dt_recent_photos', 'dt_print_widget_recent_photos' );
function dt_print_widget_recent_photos( $atts ) {
    extract(
        shortcode_atts(
            array(
                'ppp'       => 6,
                'title'     => '',
                'column'    => 'half',
                'orderby'   => 'date',
                'order'     => 'DESC',
                'only'      => '',
                'except'    => '',  
            ),
            $atts
        )
    );

	$title = strip_tags( $title );
	$ppp = absint( $ppp );
    $order = DT_latest_photo_Widget::dt_sanitize_enum( $order, DT_latest_photo_Widget::$order_reference );
    $orderby = DT_latest_photo_Widget::dt_sanitize_enum( $orderby, array_keys(DT_latest_photo_Widget::$orderby_reference) );
    
    $args = array(
        'before_widget' => '<div class="' . esc_attr($column) .'">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    );

    $select = 'all';
    $cats =  array();
    
    if( $except ) {
        $select = 'except';
        $cats = array_map('trim', explode(',', $except));
    }

    if( $only ) {
        $select = 'only';
        $cats = array_map('trim', explode(',', $only));
    }

    $params = array(
        'title'     => $title,
        'show'      => $ppp,
        'order'     => $order,
        'orderby'   => $orderby,
        'select'    => $select,
    );

    if ( $cats ) {
        $params['cats'] = $cats;
    }

    ob_start();
    
    the_widget( 'DT_latest_photo_Widget', $params, $args );
    
    $output = ob_get_clean();
    
    return $output;
}

/**
 * Get list of dt_gallery categories.
 */
function dt_shortcode_widget_small_photos_get_category_list() {
    $terms = get_categories(
        array(
            'type'                     => 'dt_gallery',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'taxonomy'                 => 'dt_gallery_category',
            'pad_counts'               => false
        )
    );
    
    if( is_wp_error($terms) ) $terms = array();

    $html = '';

    ob_start();
    
    // print select list
    dt_admin_select_list(
        array(
            'rad_butt_name'     => 'show_type_gallery',
            'checkbox_name'     => 'show_gallery',
            'terms'             => &$terms,
            'con_class'         => 'dt_mce_gal_list',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>',
            'before_title'      => '<legend>',
            'after_title'       => '</legend>'
        )    
    );

    $html .= ob_get_clean();

    add_filter( 'dt_admin_page_option_orderby-options', 'dt_shortcbuilder_photos_orderby_filter' );
    add_filter( 'dt_admin_page_option_order-options', 'dt_shortcbuilder_photos_order_filter' );

    $html .= dt_admin_order_options(
        array(
            'options'           => array(
                'orderby'               => 'date',
                'order'                 => 'DESC',
                'orderby_white_list'    => array_keys(DT_latest_photo_Widget::$orderby_reference),
            ),
            'box_name'          => 'dt_small_photos',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );

    // generate the response
    $response = json_encode(
        array(
            'html_content'  => $html
        )
    );

    // response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_dt_shortcode_small_photos_get_category_list', 'dt_shortcode_widget_small_photos_get_category_list' );

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_recent_photos',
    basename( dirname(__FILE__) )
);

add_filter( 'jpb_visual_shortcodes', 'dt_widget_recent_photos_images_filter' );
function dt_widget_recent_photos_images_filter( $shortcodes ) {
    global $ShortcodeKidPath;
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_recent_photos',
            'image'     => DT_SHORTCODES_URL . '/images/space.png',
            'command'   => 'dt_mce_command-widget_recent_photos'
        )    
    );
    return $shortcodes;
}
