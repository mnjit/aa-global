<?php

add_shortcode( 'dt_blog_posts', 'dt_shortcodes_popular_posts' );
function dt_shortcodes_popular_posts( $atts ) {
    extract(
        shortcode_atts(
            array(
				"title"		=> '',
                "ppp"       => 6,
                "select"    => 'all',
                "cats"  	=> '',
                "order"     => 'ASC',
				"orderby"	=> 'modified',
				"column"	=> 'one-fourth',
				"thumbs"	=> 1
            ),
            $atts
        )
    );
	
	if( in_array($thumbs, array('false', false, '0', 0)) )
		$thumbs = 0;
	
	$thumbs = intval($thumbs);
	
    $args = array(
        'before_widget' => '<div class="blog-posts">',
        'after_widget'  => '</div>',
        'before_title'  => '',
        'after_title'   => ''
    );
    
	if( 'full-width_three' == $column )
        $column = str_replace('_three', ' third', $column);

    if( 'full-width_fourth' == $column )
        $column = str_replace('_fourth', ' fourth', $column);
	
    ob_start();
    the_widget(
        'DT_popular_posts_Widget',
        array( 
			'title'     => '',
			'order'     => $order,
			'show'      => $ppp,
            'orderby'   => $orderby,
            'select'    => $select,
			'thumb'		=> $thumbs,
            'cats'      => array_map('intval', explode(',', str_replace(' ', '', $cats)))
		),
        $args
    );
    $output = ob_get_clean();
	
	return '<div class="'. esc_attr($column). ' thumbs_'. $thumbs. '">'. ($title?'<h2>'. $title. '</h2>':''). $output. '</div>';
}

add_action( 'wp_ajax_dt_shortcodes_ajax_popular_posts', 'dt_shortcodes_ajax_popular_posts' );
function dt_shortcodes_ajax_popular_posts() {
    $terms = array();
	
	$full_terms = get_terms( 'category', array( 'hide_empty'    => 1, 'hierarchical'  => false ) );
	
	if( $full_terms && !is_wp_error($full_terms) ) {
		foreach( $full_terms as $term ) {
			$terms[] = array( 'name' => $term->name, 'id' => $term->term_id );
		}
	}
	
	// generate the response
    $response = json_encode(
		array(
			'terms'	=> $terms
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_widget_popular_posts', // shortcode mce plugin name
    'widget-popular-posts', // shortcode directory
    false // ? :)
);

add_filter('jpb_visual_shortcodes', 'dt_widget_popular_posts_images_filter');
function dt_widget_popular_posts_images_filter( $shortcodes ) {
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_blog_posts',
            'image'     => DT_SHORTCODES_URL . '/images/space.png',
            'command'   => 'dt_mce_command-widget_popular_posts'
        )    
    );
    return $shortcodes;
}
