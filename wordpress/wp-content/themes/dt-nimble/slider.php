<?php
global $post;
$slider_options = wp_parse_args( get_post_meta( $post->ID, '_dt_slider_layout_options', true ), dt_metabox_slider_layout_options() );
$sliders = get_post_meta( $post->ID, '_dt_slider_layout_slideshows', true );

$args = array(
	'no_found_rows'		=> 1,
    'post_type'         => 'dt_slider',
    'posts_per_page'    => -1,
    'order'             => 'DESC',
    'orderby'           => 'date',     
    'post_status'       => 'publish'
);

if( 'only' == $sliders['select'] )
    $args['post__in'] = $sliders['slideshows'];

if( 'except' == $sliders['select'] )
    $args['post__not_in'] = $sliders['slideshows'];

$sliders = new WP_Query( $args );
$sliders_ids = array();
if( $sliders->have_posts() ) {
    foreach( $sliders->posts as $slider ) {
        $sliders_ids[] = $slider->ID;
    }
}
wp_reset_postdata();

$args = array(
	'no_found_rows'		=> 1,
    'post_type'         => 'attachment',
    'post_mime_type'    => 'image',
    'post_status'       => 'inherit',
    'order'             => 'ASC',
    'orderby'           => 'menu_order',     
    'posts_per_page'    => -1
);

dt_storage( 'where_filter_param', implode(',', $sliders_ids) ); 

add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
$images = new WP_Query( $args );
remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );

$slides_arr = array();
global $current_user, $paged;

if( $images->have_posts() && ($paged >= 0 && $paged <= 1) ) {

    $slide_hw = array(
        'nivo'          => array( 'w' => 960, 'h' => 400 ),
        'carousel'      => array( 'w' => 542, 'h' => 400 ),
        'photo_stack'   => array( 'w' => 239, 'h' => 399 ),
        'fancy_tyle'    => array( 'w' => 960, 'h' => 400 )
    );

    while( $images->have_posts() ) { $images->the_post();
    
        $link = get_post_meta( $post->ID, '_dt_slider_link', true );
        $hide_desc = get_post_meta( $post->ID, '_dt_slider_hdesc', true );
        $link_neww = get_post_meta( $post->ID, '_dt_slider_newwin', true );
        
        $tmp_arr = array();
        if ( ! empty( $post->post_excerpt ) && ! $hide_desc ) {
            $tmp_arr['caption'] = get_the_excerpt();
        }

        if ( ! empty( $post->post_title ) && ! $hide_desc )  
            $tmp_arr['title'] = $post->post_title;
        
        $img = wp_get_attachment_image_src( $post->ID, 'full' );
        if ( $img ) {

			if ( 'fullscreen_slider' != $slider_options['slider'] ) {
				$tmp_arr['src'] = str_replace( array('src="', '"'), '', dt_get_thumb_img(
					array(
					   'img_meta'   => $img,
					   'thumb_opts' => $slide_hw[$slider_options['slider']]
					),
					'%SRC%',
					false
				) );
				$tmp_arr['size_str'] = image_hwstring(
					$slide_hw[$slider_options['slider']]['w'],
					$slide_hw[$slider_options['slider']]['h']
				);
			} else {
				$tmp_arr['src'] = $img[0];
				$tmp_arr['size_str'] = image_hwstring( $img[1], $img[2] );
			}
			$tmp_arr['alt'] = get_post_meta( $post->ID, '_wp_attachment_image_alt', true );
        }
		
		if( $link )
			$tmp_arr['link'] = esc_attr($link);
 
		$tmp_arr['in_neww'] = intval($link_neww);
		
        $slides_arr[] = $tmp_arr;
    }
	wp_reset_postdata();

    $autoslide = intval($slider_options['auto_period']);
    $autoslide_on = $autoslide?'1':'0';
	
	$fs_height = intval($slider_options['fs_height']);
	$fs_bot_spacing = intval($slider_options['fs_bot_spacing']);
	$fs_overlay = intval($slider_options['fs_overlay']);
	
    switch( $slider_options['slider'] ) {
		case 'fullscreen_slider': dt_get_fullscreen_slider( array(
	        'wrap'		        => '
			<div class="dt-slider-container">
				<ul class="fs-slideshow" data-overlay="' . $fs_overlay . '" data-autoslide="' . $autoslide . '" data-autoslide_on="' . $autoslide_on . '" data-height="' . $fs_height . '" data-spacing="' . $fs_bot_spacing . '">
					%SLIDER%
				</ul>
				<div class="fs-controls">
					<a class="go-next"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a>
					<a class="go-prev"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a>
				</div>
			</div>',
			'items_wrap' 		=> '<li>%IMAGE%%CAPTION%</li>',
			'items_arr'			=> $slides_arr
			) ); break;
        case 'nivo': dt_get_nivo_slider( array(
	        'wrap'		        => '<div class="navig-nivo big-slider dt-slider-container"><div class="nivo-directionNav"><a class="nivo-nextNav"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a><a class="nivo-prevNav"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a></div></div><div class="dt-slider-container"><div class="%CLASS%">%SLIDER%</div></div>',
			'items_arr'			=> $slides_arr,
			'items_wrap' 		=> '<div id="slider" class="nivoSlider" data-autoslide="' . $autoslide . '" data-autoslide_on="' . $autoslide_on . '">%IMAGES%</div>%CAPTIONS%'
			) ); break;
        case 'photo_stack': dt_get_photo_stack_slider( array(
            'items_arr' 	=> $slides_arr,
            'wrap'      	=> '<div class="dt-slider-container"><div class="navig-nivo ps"><a class="next"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a><a class="prev"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a></div><div id="ps-slider" class="ps-slider" data-autoslide="' . $autoslide . '" data-autoslide_on="' . $autoslide_on . '"><div id="ps-albums">%SLIDER%</div></div></div>'
            ) ); break;
        case 'fancy_tyle': dt_get_jfancy_tile_slider( array(
            'items_arr' 	=> $slides_arr,
            'wrap'      	=> '<div class="dt-slider-container"><div class="navig-nivo fancy"><a class="jfancytilenav jfancytileForward"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a><a class="jfancytilenav jfancytileBack"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a></div><div id="fancytile-slide" data-autoslide="' . $autoslide . '" data-autoslide_on="' . $autoslide_on . '"><ul>%SLIDER%</ul></div></div>'
			) ); break;
        case 'carousel': dt_get_carousel_homepage_slider( array(
            'items_arr' => $slides_arr,
            'wrap'      => '<div class="navig-nivo caros"><a href="" id="carousel-left"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a><a href="" id="carousel-right"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a></div><div class="dt-slider-container"><div id="carousel-container"><div id="carousel" data-autoslide="' . $autoslide . '" data-autoslide_on="' . $autoslide_on . '">%SLIDER%</div></div></div>',
            ) ); break;
    }

}elseif( !$images->have_posts() && user_can($current_user->ID, 'edit_pages') ) {
?>
    <div class="dt-slider-footer-container" style="color: red; width: 200px; margin: 0 auto; padding: 20px; text-shadow: none; "><?php _e('There are no images in the slider.', LANGUAGE_ZONE); ?></div>
<?php
}
?>
