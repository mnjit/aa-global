<?php

add_shortcode( 'dt_benefits', 'dt_shortcode_benefits' );
function dt_shortcode_benefits( $atts ) {
    global $post;
    
    $temp = clone $post;
    
    extract(
        shortcode_atts(
            array(
                "ppp"       => 4,
                "title"     => '',
                "orderby"   => 'Date',
                "order"     => 'DESC',
                "class"     => '',
                "except"    => '',
                "only"      => '',
                "column"    => 'half'
            ),
            $atts
        )
    );
    
    if ( 'full-width_three' == $column )
        $column = str_replace('_three', ' third', $column);

    if ( 'full-width_fourth' == $column )
        $column = str_replace('_fourth', ' fourth', $column);

    $output = '';
    
    $args = array(
		'no_found_rows'	=> 1,
        'post_type'     => 'dt_benefits',
        'post_status'   => 'publish',
        'orderby'       => $orderby,
        'order'         => $order,
    );

    if ( $except || $only ) {
        $cats = array_map('trim', explode(',', $except?$except:$only));
        $args['tax_query'] = array( array(
            'taxonomy'  => 'dt_benefits_category',
			'field'     => 'id',
            'terms'     => $cats,
            'operator'  => 'IN'
        ) );
        if( $except )
            $args['tax_query'][0]['oprerator'] = 'NOT IN';
    }
    
    if ( $ppp ) {
        $args['posts_per_page'] = $ppp;
    }
	
    $query = new Wp_Query( $args );

	// caching!
	if ( $query->have_posts() ) {
		
		$images = array();
		foreach ( $query->posts as $p ) {
			$post_meta = get_post_meta( $p->ID, '_dt_benefits_options', true );
			if ( ! empty( $post_meta['retina_image_id'] ) ) {
				$images[] = intval( $post_meta['retina_image_id'] );
			}
			
			if ( has_post_thumbnail( $p->ID ) ) {
				$images[] = get_post_thumbnail_id( $p->ID );
			}
		}
		
		if ( $images ) {
			$i_query = new WP_Query( array(
				'no_found_rows'		=> 1,
				'posts_per_page'	=> -1,
				'post_type'			=> 'attachment',
				'post_status' 		=> 'inherit',
				'post__in'			=> $images
			) );
		}
	}

    if ( $query->have_posts() ) {
        $output .= '<div class="'.$column.$class.'">'."\n";

        if( $title )
           $output .= '<h2>' . $title . '</h2>'."\n";
        
        $output .= '<div class="text-content">'."\n";

        while ( $query->have_posts() ) {
            $query->the_post();

            $output .= '<div class="text-inline">'."\n";

			$post_data = get_post_meta( get_the_ID(), '_dt_benefits_options', true );
			$thmb_id = get_post_thumbnail_id( get_the_ID() );
			$alt = esc_attr( get_the_title() );

			// fill array with images
			$images = array();
			$images['normal'] = has_post_thumbnail( get_the_ID() ) ? dt_get_uploaded_logo( array( '', $thmb_id ) ) : null;
			$images['retina'] = ! empty( $post_data['retina_image_id'] ) ? dt_get_uploaded_logo( array( '', intval( $post_data['retina_image_id'] ) ), 'retina' ) : null;

			// calculate default image
			$default_img = null;
			foreach ( $images as $image ) {
				if ( $image ) { $default_img = $image; break; } 
			}

			// if there are any image - output it
			$image = '';
			if ( $default_img ) {
				$image = dt_get_retina_sensible_image( $images['normal'], $images['retina'], $default_img, 'class="do-ico" alt="' . $alt . '"' );
			}

            $output .= sprintf(
                '<p class="head">%2$s</p><p>%1$s%3$s</p>'."\n",
                $image,
                get_the_title(),
                get_the_content()
            );

            $output .= '</div>'."\n";
        }

        $output .= '</div>'."\n";
		
        $output .= '</div>'."\n";
    }

    $post = $temp;

    return $output;
}

add_action( 'wp_ajax_dt_ajax_editor_benefits', 'dt_shortcode_benefits_ajax_editor' );
function dt_shortcode_benefits_ajax_editor() {
    $html = '';
    
    add_filter( 'dt_admin_page_option_ppp-options', 'dt_shortcbuilder_photos_ppp_filter' );
    add_filter( 'dt_admin_page_option_orderby-options', 'dt_shortcbuilder_photos_orderby_filter' );
    add_filter( 'dt_admin_page_option_order-options', 'dt_shortcbuilder_photos_order_filter' );
    
    $terms = get_categories(
        array(
            'type'                     => 'dt_benefits',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'taxonomy'                 => 'dt_benefits_category',
            'pad_counts'               => false
        )
    );

    ob_start();
?>
    
    <fieldset style="padding-left: 15px;">
         <legend> Title: </legend>
         <input type="text" id="dt_mce_window_benefits_title" name="dt_mce_window_benefits_title" value="" />
    </fieldset>
<?php
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

    $html .= dt_admin_ppp_options(
        array(
            'options'           => array( 'ppp'   => 4 ),
            'box_name'          => 'dt_mce_window_benefits',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );
    
    $html .= dt_admin_order_options(
        array(
            'options'           => array(
                'orderby'   => 'date',
                'order'     => 'DESC'
            ),
            'box_name'          => 'dt_mce_window_benefits',
            'before_element'    => '<fieldset style="padding-left: 15px;">',
            'after_element'     => '</fieldset>'
        ),
        false
    );

    ob_start();
?> 
    
    <fieldset style="padding-left: 15px;">
         <legend> Column: </legend>
         <select name="dt_mce_window_benefits_column" id="dt_mce_window_benefits_column">

        <?php
        $columns = array(
            'one-fourth'        => 'one-fourth',
            'three-fourth'      => 'three-fourth',
            'one-third'         => 'one-third',
            'two-thirds'        => 'two-thirds',
            'half'              => 'half',
            'full-width_three'  => 'full-width(three columns)',
            'full-width_fourth' => 'full-width(four columns)'
        );
        foreach( $columns as $column=>$title ):
        ?>

			<option value="<?php echo $column; ?>"><?php echo $title; ?></option>

        <?php endforeach; ?>

         </select>
    </fieldset>
    
<?php
    $html .= ob_get_clean();

	// generate the response
    $response = json_encode(
		array(
			'html_content'	=> $html
		)
	);

	// response output
    header( "Content-Type: application/json" );
    echo $response;

    // IMPORTANT: don't forget to "exit"
    exit;
}

add_filter( 'jpb_visual_shortcodes', 'dt_benefits_images_filter' );
function dt_benefits_images_filter( $shortcodes ) {
    array_push(
        $shortcodes,
        array(
            'shortcode' => 'dt_benefits',
            'image'     => DT_SHORTCODES_URL . '/images/space.png',
            'command'   => 'dt_mce_command-benefits'
        )    
    );
    return $shortcodes;
}

$tinymce_button = new dt_add_mce_button(
    'dt_mce_plugin_shortcode_benefits',
    'benefits',
    false
);
