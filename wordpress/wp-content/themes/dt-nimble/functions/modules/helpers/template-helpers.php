<?php
/* Add apropriet class to portfolio/gallery/category in search
 * Used in filter "dt_portfolio_classes" (functions.php), search.php
 */
function dt_search_portfolio_class_filter ( $class, $type = '', $place = '' ) {
	if ( isset( $class['2_col']['list']['sidebar']['block'] ) && 'block' == $place ) {
		$new_class = ' item-blog';
		
		if ( 1 === dt_storage( 'post_is_first' ) ) {
			$new_class .= ' first';
			dt_storage( 'post_is_first', -1 );
		}
		$class['2_col']['list']['sidebar']['block'] .= $new_class;
	}
	return $class;
}

function dt_get_next_prev_post( $opts = array() ) {
	global $wpdb, $post;
	if( !$post )
		return false;
		
	$defaults = array(
		'wrap'				=> '<div class="paginator-r inner-navig">%LINKS%</div>',
		'title_wrap'		=> '<span class="pagin-info">%TITLE%</span>',
		'no_link_next'		=> '<a href="#" class="prev no-act" onclick="return false;"><span class="a-l-s">&#8249;</span><span class="a-r-s">&#8249;</span></a>',
		'no_link_prev'		=> '<a href="#" class="next no-act" onclick="return false;"><span class="a-l-s">&#8250;</span><span class="a-r-s">&#8250;</span></a>',
		'title'				=> __('Post %CURRENT% of %MAX%', LANGUAGE_ZONE),
		'next_post_class'	=> 'prev',
		'prev_post_class'	=> 'next',
//		'no_next_class'		=> 'prev no-act',
//		'no_prev_class'		=> 'next no-act',
		'echo'				=> true
	);
	$opts = apply_filters( 'dt_get_next_prev_post_options', wp_parse_args( $opts, $defaults ) );
	$opts = wp_parse_args( $opts, $defaults );
	
	$posts = new WP_Query( array(
		'no_found_rows'		=> true,
		'fields'			=> 'ids',
		'posts_per_page'	=> -1,
		'post_type'			=> get_post_type(),
		'post_status'		=> 'publish',
		'orderby'			=> 'date',
		'order'				=> 'DESC'
	) );
	
	$current = 1;
	foreach( $posts->posts as $index=>$post_id ) {
		if( $post_id == get_the_ID() ) {
			$current = $index + 1;
			break;
		}
	}
	
	$title = str_replace( array('%CURRENT%', '%MAX%'), array( $current, count( $posts->posts ) ), $opts['title'] );
	
	$output = '';
	
	$output .= str_replace( array('%TITLE%'), array($title), $opts['title_wrap'] );
	
	// next link
	ob_start();
	next_post_link('%link', '<span class="a-l-s">&#8249;</span><span class="a-r-s">&#8249;</span>');
	$link = ob_get_clean();
	if( $link ) {
		$output .= str_replace('href=', 'class="'. $opts['next_post_class']. '" href=', $link);
	}else
		$output .= $opts['no_link_next'];

	// previos link
	ob_start();
	previous_post_link('%link', '<span class="a-l-s">&#8250;</span><span class="a-r-s">&#8250;</span>');
	$link = ob_get_clean();
	if( $link ) {
		$output .= str_replace('href=', 'class="'. $opts['prev_post_class']. '" href=', $link);
	}else
		$output .= $opts['no_link_prev'];
	
	$output = str_replace( '%LINKS%', $output, $opts['wrap'] );
	
	if( $opts['echo'] ) {
		echo $output;
		return null;
	}
	return $output;
}

function dt_get_simple_menu( $opts = array() ) {
	$defaults = array(
		'menu_name'		=> 'top-menu',
		'wrap'			=> '<ul class="right-top">%ITEMS%</ul>',
		'item_wrap'		=> '<li><a href="%URL%">%TITLE%</a></li>',
		'echo'			=> true
	);
	$opts = apply_filters( 'dt_get_simple_menu_options', wp_parse_args($opts, $defaults) );
	$opts = wp_parse_args($opts, $defaults);
	
	if( ($locations = get_nav_menu_locations()) && isset($locations[$opts['menu_name']]) ) {
		$menu = wp_get_nav_menu_object( $locations[$opts['menu_name']] );
		
		if( $menu ) {
			$menu_items = wp_get_nav_menu_items($menu->term_id);

			$menu_list = '';
			foreach ( (array) $menu_items as $key => $menu_item ) {
				$title = $menu_item->title;
				$url = $menu_item->url;
				$menu_list .= str_replace( array('%URL%', '%TITLE%'), array($url, $title), $opts['item_wrap'] );
			}
			$menu_list = str_replace( '%ITEMS%', $menu_list, $opts['wrap'] );

			if( $opts['echo'] ) {
				echo $menu_list;
				return false;
			}
			return $menu_list;
		}
	}
	return null;
}

function dt_get_soc_links() {
    $links = of_get_option('social_icons');

    if ( empty( $links ) ) {
        return '';
    }

?>

	<ul class="soc-ico">

<?php
	foreach( $links as $name=>$data ):
		
		if ( 'skype' != $name ) {
			$data['link'] = esc_url( $data['link'] );
		} else {
			$data['link'] = esc_attr( $data['link'] );
		}
?>

		<li><a class="<?php echo $name; ?> trigger" href="<?php echo $data['link']; ?>" target="_blank"><span><?php echo $name; ?></span></a></li>

<?php endforeach; ?>

	</ul>

<?php
}

function dt_get_anything_slider( $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'      => '<div class="%CLASS%">%SLIDER%</div>',
        'class'     => 'slider-shortcode flexslider gal',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if ( empty( $opts['items_arr'] ) )
        return '';

    $output = '';
    foreach( $opts['items_arr'] as $slide ) {

		$slide_link = '';
		if ( ! empty( $slide['link'] ) ) {
			$slide_link = '<div class="link"><a href="' . esc_url( $slide['link'] ) . '"' . ( !empty( $slide['link_neww'] ) ? 'target="_blank"' : '' ) . '></a></div>';
		}

		$caption = '';
        if ( !empty( $slide['caption'] ) ) {			
			$caption = sprintf(
                '<span class="html-caption"><p>%s</p></span>',
                $slide['caption']
            );
		}

        $output .= '<li>'."\n";
        if ( ! isset( $slide['is_video'] ) || $slide['is_video'] == false ) {
            $output .= sprintf(
                '%s<img src="%s" alt="%s" %s />%s',
				$slide_link,
                $slide['src'],
                ( isset( $slide['alt'] ) ? $slide['alt'] : '' ),
                $slide['size_str'],
                $caption
            );
        } else {
            $output .= dt_get_embed( $slide['src'], $slide['size_str'][0], $slide['size_str'][1], false );
        }
        $output .= '</li>';
    }
    $output = '<ul class="anything-slider slides">' . $output . '</ul>';
    
    $output = str_replace( array(
            '%SLIDER%',
            '%CLASS%'
        ), array(
            $output,
            $opts['class']
        ), $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_carousel_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'      => '<div class="%CLASS%">%SLIDER%<a id="prev1" class="prev" href="#"></a><a id="next1" class="next" href="#"></a></div>',
		'item_wrap'	=> '<li><div class="textwidget"><div class="textwidget-photo"><a class="photo" href="%LINK%"><img src="%IMG_SRC%" alt="%ALT%" %IMG_SIZE% /></a></div></div></li>',
        'class'     => 'list-carousel recent',
		'ul_class'	=> 'carouFredSel_1',
        'id'        => '',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach ( $opts['items_arr'] as $item ) {
        $caption = '';
     
        if ( !isset( $item['href'] ) ) {
            if ( isset( $item['post_id'] ) ) {
                $item['href'] = get_permalink( $item['post_id'] );
            } else {
                $item['href'] = '#';
            }
        }
        $output .= str_replace(
			array( '%LINK%', '%IMG_SRC%', '%IMG_SIZE%', '%TITLE%', '%DESC%', '%ALT%' ),
			array( $item['href'], $item['src'], $item['size_str'], isset($item['title'])?$item['title']:'', isset($item['desc'])?$item['desc']:'', isset($item['alt'])?$item['alt']:'' ),
			$opts['item_wrap']
		);
	}
	$ul_id = ! empty( $opts['id'] ) ? ' id="' . $opts['id'] . '"' : '';
	$ul_class = ! empty( $opts['ul_class'] ) ? ' class="' . $opts['ul_class'] . '"' : '';
	
    $output = '<ul' . $ul_id . $ul_class . '>' . $output . '</ul>';
    
    $output = str_replace( array(
            '%SLIDER%',
            '%CLASS%'
        ), array(
            $output,
            $opts['class']
        ), $opts['wrap']
    );

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
    return false;
}

function dt_get_coda_slider( array $opts = array() ) {
    $defaults = array(
        'wrap'      => '<div class="coda-slider-wrapper"><div class="coda-slider preload">%SLIDER%</div></div>',
        'item_wrap' => '<div class="panel"><div class="panel-wrapper">%1$s</div><div class="panel-author">%2$s</div></div>',
        'data'      => array(),
        'wrap_data' => array(),
        'echo'      => true
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( empty($opts['data']) || !is_array($opts['data']) ) {
        return '';
    }

    $output = '';
    foreach( $opts['data'] as $slide ) {
        if( !is_array($slide) ) {
			continue;
        }

        $replace_arr = array();
        for( $i = 0; $i < count( $slide ); $i++ ) {
            $replace_arr[] = '%' . ($i + 1) . '$s';
            if( isset($opts['wrap_data'][$i]) ) {
                $slide[$i] = sprintf( $opts['wrap_data'][$i], $slide[$i] );
            }
        }
        $output .= str_replace( $replace_arr, $slide, $opts['item_wrap'] );
    }
    
    $output = str_replace( array('%SLIDER%'), array( $output ), $opts['wrap'] );

    if( $opts['echo'] ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_carousel_homepage_slider( array $opts = array(), $echo = true ) {
    wp_enqueue_script( 'dt_carouselHome', get_template_directory_uri() . '/js/jquery.featureCarousel.js', array('jquery') );

	$defaults = array(
        'wrap'      => '<div class="navig-nivo caros"><div id="carousel-left"></div><div id="carousel-right"></div></div><section id="%ID%"><div id="carousel-container"><div id="carousel">%SLIDER%</div></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $item_output = $no_capt_class = '';
		$link = '%s';
		
        if ( ! empty( $item['title'] ) ) { 
			if ( ! empty( $item['link'] ) ) {
				$link = '<a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>%s</a>';	
				$item_output .= '<div class="caption-head"><a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>' . sprintf( $link, $item['title'] ) . '</a></div>';
			} else {
				$item_output .= '<div class="caption-head">' . sprintf( $link, $item['title'] ) . '</div>';
			}
		}
		
        if ( ! empty( $item['caption'] ) )
            $item_output .= '<div class="text-capt">' . $item['caption'] . '</div>';
		
		if ( ! $item_output )
			$no_capt_class = ' no-slide-desc';
		
		$item_link = '';
		if ( ! empty( $item['link'] ) ) {
			$item_link = '<div class="link"><a href="' . esc_url( $item['link'] ) . '"' . ( empty( $item['in_neww'] ) ? '' : ' target="_blank"' ) . '></a></div>';
		}
       
		if ( $item_output )
            $item_output = '<div class="carousel-caption'. $no_capt_class. '">' . $item_output . '</div>';
		
		$alt = isset( $item['alt'] ) ? $item['alt'] : '';
        $item_output = '<a href="#"><img class="carousel-image" alt="' . $alt . '" src="' . esc_attr( $item['src'] ) . '" ' . $item['size_str'] . ' /></a><div class="mask"><img alt="" src="' . get_template_directory_uri() . '/images/bg-carousel.png" /></div>' . $item_output;

        $output .= '<div class="carousel-feature">' . $item_output . $item_link . '</div>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_get_photo_stack_slider( array $opts = array(), $echo = true ) {
    wp_enqueue_script( 'dt_photo_stack', get_template_directory_uri().'/js/photo-stack.js', array('jquery') );

    $defaults = array(
        'wrap'      => '<section id="%ID%"><div class="navig-nivo ps"><a class="prev"><span class="a-l"></span><span class="a-r"></span></a><a class="next"><span class="a-l"></span><span class="a-r"></span></a></div><div id="ps-slider" class="ps-slider"><div id="ps-albums">%SLIDER%</div></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    $output = '';
    foreach ( $opts['items_arr'] as $item ) {
        $item_output = $no_capt_class = '';
        $link = '%s';
		
		if ( ! empty( $item['link'] ) ) {
			$link = '<a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>%s</a>';	
		}
		
        if ( ! empty( $item['title'] ) )
            $item_output .= '<div class="ps-head">' . sprintf( $link, $item['title'] ) . '</div>';

        if ( ! empty( $item['caption'] ) )
            $item_output .= '<div class="ps-cont">' . $item['caption'] . '</div>';
		
        if ( $item_output )
            $item_output = '<div class="ps-desc">' . $item_output . '</div>'; 
		else
			$no_capt_class = ' no-slide-desc';
			
		if ( ! empty( $item['link'] ) ) {
			$item_output .= '<div class="link">'. sprintf( $link, '' ). '</div>';
		}
		
		if ( $item_output )
			$item_output = '<div class="slide-desc'. $no_capt_class. '">'. $item_output. '</div>';
		
		$alt = isset( $item['alt'] ) ? $item['alt'] : '';
        $item_output = '<img class="carousel-image" alt="' . $alt . '" src="' . esc_attr( $item['src'] ) . '" ' . $item['size_str'] . ' />' . $item_output;

        $output .= '<div class="ps-album"><div class="ps-album-inner">' . $item_output . '</div></div>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

// jfancy slider helper
function dt_get_jfancy_tile_slider( array $opts = array(), $echo = true ) {
    wp_enqueue_script( 'dt_jfancy_tile', get_template_directory_uri().'/js/jquery.jfancytile.js', array('jquery') );

    $defaults = array(
        'wrap'      => '<section id="%ID%"><div class="navig-nivo fancy"></div><div id="fancytile-slide"><ul>%SLIDER%</ul><div class="mask"></div></div></section>',
        'class'     => '',
        'id'        => 'slide',
        'items_arr' => array()
    );
    $opts = wp_parse_args( $opts, $defaults );    
    $output = '';
    foreach( $opts['items_arr'] as $item ) {
        $item_output = $no_capt_class = '';
        $link = '%s';
/*		
		if( !empty($item['link']) ) {
			$link = '<a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>%s</a>';	
		}
*/		
        if( !empty($item['title']) )
            $item_output .= '<div class="caption-head">' . sprintf( $link, $item['title'] ) . '</div>';

        if( !empty($item['caption']) )
            $item_output .= '<div class="text-capt">' . $item['caption'] . '</div>';
		
		if( !$item_output )
			$no_capt_class = ' no-slide-desc';
			
		$item_link = '';
		if( !empty($item['link']) ) {
			$item_link = '<div class="link"><a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '></a></div>';	
		}
		
//Ha-ha! Danil made an error here: if slide desc was empty, link was not displaying (even if there was one)
		if( $item_output ) {
            $item_output = $item_link. '<div class="html-caption'. $no_capt_class. '">' . $item_output . '</div>';
		} else {
			$item_output = $item_link;
		}
		
		$alt = isset( $item['alt'] ) ? $item['alt'] : '';
        $item_output = '<img alt="' . $alt . '" src="' . esc_attr( $item['src'] ) . '" ' . $item['size_str'] . ' />' . $item_output;

        $output .= '<li>' . $item_output . '</li>';
    }

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );

    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

// nivo slider helper
function dt_get_nivo_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'          => '<div class="navig-nivo big-slider"><div class="nivo-directionNav"><a class="nivo-prevNav"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a><a class="nivo-nextNav"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a></div></div><section id="%ID%"><div class="%CLASS%">%SLIDER%</div></section>',
        'class'         => 'slider-wrapper theme-default',
        'id'            => 'slide',
        'items_wrap'    => '<div id="slider" class="nivoSlider">%IMAGES%</div>%CAPTIONS%',
        'items_arr'     => array()
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( empty($opts['items_arr']) )
        return '';

    $output = '';
    $images = $caption = '';
    $i = 1;

    foreach( $opts['items_arr'] as $item ) {
        $capt = $capt_class = $no_capt_class = '';
		$link = '%s';
	/*	
		if( !empty($item['link']) ) {
			$link = '<a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>%s</a>';	
		}
	*/	
        if( !empty($item['title']) ) {
			if( !empty($item['link']) ) {
				$capt .= '<div class="caption-head"><a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>' . sprintf( $link, $item['title'] ) . '</a></div>';	
			} else {
	            $capt .= '<div class="caption-head">' . sprintf( $link, $item['title'] ) . '</div>';
			}
		}

        if( !empty($item['caption']) )
            $capt .= '<div class="text-capt">' . $item['caption'] . '</div>';
		
		if( !$capt )
			$no_capt_class = ' no-slide-desc';
			
		$item_link = '';
		if( !empty($item['link']) ) {
			$item_link = ' data-link="'. esc_url($item['link']).'" data-target="'. (empty($item['in_neww'])?'':'_blank').'"';
		}
		
		if( $capt ) {
			$capt_class = 'caption-' . $i;
			$caption .= '<div class="nivo-html-caption '. $capt_class. $no_capt_class . '"><div class="html-caption">'. $capt. '</div></div>';
			$capt_class = '.'. $capt_class;
		}
		
		$alt = isset( $item['alt'] ) ? $item['alt'] : '';
        $images .= '<img '. $item_link .' src="' . $item['src'] . '" alt="' . $alt . '" title="' . $capt_class . '" ' . $item['size_str'] . ' />';
        $i++;
    }

    $output .= str_replace( array('%IMAGES%', '%CAPTIONS%'), array($images, $caption), $opts['items_wrap'] );

    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );


    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

// supper fullscreen slider!
function dt_get_fullscreen_slider( array $opts = array(), $echo = true ) {
    $defaults = array(
        'wrap'          => '<section id="fs-slideshow"><ul class="fs-slideshow">%SLIDER%</ul><div class="fs-controls"><a class="go-next"><span class="a-l">&#8250;</span><span class="a-r">&#8250;</span></a><a class="go-prev"><span class="a-l">&#8249;</span><span class="a-r">&#8249;</span></a></div></section>',
        'class'         => 'slider-wrapper theme-default',
        'id'            => 'slide',
        'items_wrap'    => '<li>%IMAGE%%CAPTION%</li>',
        'items_arr'     => array()
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( empty($opts['items_arr']) )
        return '';

    $output = '';

    foreach( $opts['items_arr'] as $item ) {
        $capt = $capt_class = $no_capt_class = $caption = '';
		
        if( !empty($item['title']) ) {
			if( !empty($item['link']) ) {
				$capt .= '<div class="fs-title"><a href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '>' . $item['title'] . '</a></div>';	
			} else {
	            $capt .= '<div class="fs-title">' . $item['title'] . '</div>';
			}
		}

        if( !empty($item['caption']) )
            $capt .= '<div class="fs-desc">' . $item['caption'] . '</div>';
/*		
		if( !$capt )
			$no_capt_class = ' no-slide-desc';
*/			
		$item_link = '';
		if( !empty($item['link']) ) {
			$item_link = '<a class="fs-link" href="'. esc_url($item['link']). '"'. (empty($item['in_neww'])?'':' target="_blank"'). '></a>';
		}

		if( $capt ) {
			$caption = '<div class="fs-caption' . $capt_class . $no_capt_class . '">'. $capt . '</div>';
		}

		$caption = $caption . $item_link;
		$alt = isset( $item['alt'] ) ? $item['alt'] : '';
        $image = '<img src="' . $item['src']  . '" alt="' . $alt . '"' . $item['size_str'] . ' />';
		
		$output .= str_replace( array( '%IMAGE%', '%CAPTION%' ), array( $image, $caption ), $opts['items_wrap'] );
    }


    $output = str_replace(
        array( '%SLIDER%', '%CLASS%', '%ID%' ),
        array( $output, $opts['class'], $opts['id'] ),
        $opts['wrap']
    );


    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

// OneByOne slider helper
function dt_get_obo_slider( array $items = array(), $echo = true ) {
    
	if( empty($items) )
        return '';

	$presets_class = apply_filters( 'dt_get_obo_slider-preset_class', '', of_get_option( 'of-preset', 'blue' ) );
	
    $output = $stylesheet = '';
    $i = 1;
	
    foreach( $items as $item ) {
		
		$opts = $item['options'];
		unset( $item['options'] );
		
		if( 'after' == $opts['text_depth'] ) {
			$j = count($item) + 1;
			$z_index = count($item) + 5;
		}else {
			$j = count($item);
			$z_index = count($item) + 5;
		}

		$item_output = '';
		
		// get images
		foreach( $item as $image ) {
			
			$stylesheet .= "
				.dt-image{$i}_{$j} {
					left: {$image['pos_left']}px;
					top: {$image['pos_top']}px;
					z-index: {$j} !important;
					position: absolute;
				}
			";
			
			$item_output .= '<img src="'. $image['src']. '" '. $image['size_str']. ' class="dt-image'. $i. '_'. $j. '" alt="'. esc_attr($image['title']). '" />';
			
			$j--;
		}
		
		$desc = '<div class="dt-obo-content dt-obo-content_' . $i . $presets_class . '">'. $opts['post_content']. '</div>';
		
		if( 'after' == $opts['text_depth'] ) {
			$item_output = $desc. $item_output;
		}else {
			$item_output .= $desc;
		}
		
		$stylesheet .= "			
			.dt-obo-content_{$i} {
				width: {$opts['text_width']}px;
				left: {$opts['text_left']}px;
				top: {$opts['text_top']}px;
				z-index: {$z_index} !important;
				position: absolute;
			}
		";
		
		$output .= '<div class="oneByOne_item" data-ease="' . esc_attr($opts['animation']) . '">'. $item_output. '</div>';		
        $i++;
		
    }
	
	$stylesheet = '<style type="text/css">'. $stylesheet. "</style>\n";
	
	$output = $stylesheet. '<div id="banner">'. $output. '</div>';
	
    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_details_link( $post_id = null, $class = 'button' ) {
    if( empty($post_id) ) {
        global $post;
        $post_id = $post->ID;
    }
    $url = get_permalink($post_id);
    if( $url ) {
        printf(
            '<div class="but-wrap"><a href="%s" class="%s"><span><i class="more"></i>%s</span></a></div>',
            $url, $class, __('Details', LANGUAGE_ZONE)
        );
    }
}

// edit post link
function dt_edit_link( $text = null, $post_id = null, $class = 'button' ) {
    if( current_user_can('edit_posts')) {
        global $post;
        if( empty($post_id) && $post ) {
            $post_id = $post->ID;
        }
        
		if ( empty( $text ) ) { $text = _x( 'Edit', 'default edit button title', LANGUAGE_ZONE ); }
		
        if( !empty($class) )
            $class = sprintf( ' class="%s"', esc_attr($class) );

        printf( '<div class="but-wrap"><a href="%s"' . $class . ' ><span>%s</span></a></div>',
            get_edit_post_link($post_id),
            $text
        );
    }
}

function dt_category_list( array $opts ) {
    $defaults = array(
        'taxonomy'          => null,
        'post_type'         => null,
        'layout'            => null,
        'terms'             => array(),
        'select'            => 'all',
        'layout_switcher'   => true,
        'count_attachments' => false,
        'show'              => true,
        'post_ids'          => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    
    if( !($opts['taxonomy'] && $opts['post_type'] && $opts['layout'] && ($opts['show'] || $opts['layout_switcher'])) ) {
        return '';
    }
    
    if( $opts['show'] || $opts['layout_switcher'] ):

        $layout = explode('-', $opts['layout']);

        if( $opts['show'] ) {
            $list = dt_get_category_list( array(
                'taxonomy'          => $opts['taxonomy'],
                'post_type'         => $opts['post_type'],
                'terms'             => $opts['terms'],
                'count_attachments' => $opts['count_attachments'],
                'select'            => $opts['select'],
                'post_ids'          => $opts['post_ids'],
                'hash'              => '#%TERM_ID%/%PAGE%/' . (isset($layout[1])?$layout[1]:'list')
            ), false );
        }else
            $list = false;
    ?>
    
<div class="navig-category<?php echo !$list?' no-category':''; ?>">
    
    <?php
    
    echo $list;

    if( isset($layout[1]) && $opts['layout_switcher'] ) {
        dt_get_layout_switcher( array(
            'type'      => $layout[0],
            'current'   => $layout[1],
            'hash'      => '#all/1/%s'
        ) );
    }
    ?>

</div>

    <?php
    endif;
}

function dt_get_retina_sensible_image ( $logo, $r_logo, $default, $custom = '' ) {
	if ( empty( $default ) ) { return ''; }

	if ( ! ( empty( $logo ) || empty( $r_logo ) ) && dt_is_retina_on() ) {
		$output = dt_get_thumb_img(
			array(
				'img_meta'		=> $logo,
				'thumb_opts'	=> array( 'w' => $logo[1], 'h' => $logo[2], 'zc' => 0, 'force_zc' => 1, 'r_src' => $r_logo[0] )
			),
			'<img %SRC% %SIZE% ' . $custom . ' />', false
		);
	} else {
		$img_meta = $logo ? $logo : $default;
		
		if ( ! isset( $img_meta['size'] ) && isset( $img_meta[1], $img_meta[2] ) ) { $img_meta['size'] = image_hwstring( $img_meta[1], $img_meta[2] ); }
		$output = sprintf( '<img src="%s" %s %s />', $img_meta[0], $img_meta['size'], $custom );
	}
	return $output;
}

/* Set some responsivness flag based on option "misc-off_responsivness" */
function dt_is_responsive() {
	return absint( ! of_get_option( 'misc-off_responsivness', 0 ) );
}

/* Set some retina flag based on option "misc-retina_images" */
function dt_is_retina_on() {
	return absint( of_get_option( 'misc-retina_images', 1 ) );
}
?>