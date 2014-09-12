<?php
/**
 * Core functions library.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

function dt_widget_area( $position, $post_id = null, $area_name = '' ) {
    global $post;

	$param = '';
	$data = false;
	$arr = explode( '-', $position );
	$position = $arr[0];
	if( isset($arr[1]) )
		$param = $arr[1];

    if( empty($post) && empty($area_name) ) {
        if( 'sidebar' == $position )
            $area_name = 'sidebar_1';
        else
            $area_name = 'sidebar_2';
    }elseif( empty($post_id) ) {
        $post_id = $post->ID;
    }

    if( empty($area_name) ) {
        $data = get_post_meta( $post_id, '_dt_layout_' . $position . '_options', true ); 
        if( $data ) {
            $area_name = isset($data['sidebar'])?$data['sidebar']:'';
        }else {
            if( 'sidebar' == $position )
                $area_name = 'sidebar_1';
            else
                $area_name = 'sidebar_2';
        }    
    }

	$area_name = apply_filters( 'dt_widget_area_name', $area_name, $position, $post_id, $data, $param );

	ob_start();
	dynamic_sidebar( $area_name );
	$sidebar = ob_get_clean();
	wp_reset_postdata();

	echo apply_filters('dt_widget_area', $sidebar, $position, $post_id, $area_name, $data, $param);
	return true;
}

function dt_get_comments_link( $wrap = '', $opts = array(), $post_id = null ) {
    global $post;
    
    $custom_id = true;
    $comments_number = 0;

    if( empty($post_id) ) {
        $post_id = $post->ID;
        $custom_id = false;
    }

    if( empty($wrap) ) {
        $wrap = '<a href="%HREF%" class="comments_count">%COUNT%</a>';
    }

    $defaults = array(
        'text'          => array(
			_x( 'no comments', 'comments link', LANGUAGE_ZONE ),
			_x( '1 comment', 'comments link', LANGUAGE_ZONE ),
			_x( '% comments', 'comments link', LANGUAGE_ZONE )
		),
        'no_coments'    => _x( 'Comments closed for this post', 'comments link', LANGUAGE_ZONE )    
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( !comments_open($post_id) ) {
        echo $opts['no_coments'];
        return false;
    } 
    
    $comments_number = get_comments_number($post_id);
    $link_target = 'comment-form';
    if( $comments_number )
        $link_target = 'comments';

    $wrap = str_replace( '%HREF%', get_permalink($post_id).'#'.$link_target, $wrap );

    $str = explode( '%COUNT%', $wrap );

    if( isset($str[0]) ) {
        echo $str[0];
    }

    if( !$custom_id ) {
        comments_number( $opts['text'][0], $opts['text'][1], $opts['text'][2] );
    }else {
        if( !$comments_number )
            echo $opts['text'][0];
        elseif( 1 == $comments_number )
            echo $opts['text'][1];
        else
            echo str_replace( '%', $comments_number, $opts['text'][2] );
    }
        
    if( isset($str[1]) ) {
        echo $str[1];
    }

    return true;
}

function dt_get_taxonomy_link( $taxonomy = 'category', $wrap = '', $post_id = null ) {
    global $post;

    if( empty($post_id) ) {
        $post_id = $post->ID;
    }

    if( empty($wrap) ) {
        $wrap = '<span class="blog_category">%CAT_LIST%</span>';
    }

    $categories = get_the_term_list(
        $post_id,
        $taxonomy,
        '',
        __( ', ', LANGUAGE_ZONE )
    );
    if( $categories ) {
        echo str_replace( '%CAT_LIST%', $categories, $wrap );
        return true;
    }
    return false;
}

// content or excerpt - this is the question
function dt_content_question( $content ) {
    if( false !== strpos($content, '<!--more-->')) {
        return true;
    }
    return false;
}

function dt_the_content( $more_link_text = '', $stripteaser = '', $opts = array() ) {
    global $post, $more;
    $more = 0;
	if( is_search() || is_archive() || !dt_content_question($post->post_content) ){
		the_excerpt();
    }else {
    	the_content( $more_link_text, $stripteaser );
    } 
}

function dt_get_date_link( $opts = array() ) {
    $defaults = array(
        'echo'          => true,
        'wrap'          => '<a href="%HREF%" class="%CLASS%">%DATE%</a>',
        'link_type'     => 'permalink',
        'time_format'   => get_option('date_format'),
		'time'			=> null,
        'class'         => 'date'
    );
    $opts = wp_parse_args( $opts, $defaults );

    switch( $opts['link_type'] ) {
        case 'permalink':
            $href = get_permalink();
            break;
        case 'archive':
            // implement in future
        default:
            $href = '#';
    }
	
	if ( ! $opts['time'] ) {
    	$date = get_the_date( $opts['time_format'] );
	} else {
		$date = $opts['time'];
	}

    if( $opts['wrap'] ) {
        $output = str_replace(
            array( '%HREF%', '%DATE%', '%CLASS%' ),
            array( $href, $date, $opts['class'] ),
            $opts['wrap']
        );
    }else {
        $output = '';
    }

    if( !$opts['echo'] ) {
        return $output;
    }else {
        print( $output );
    }
    return '';
}

function dt_get_author_link( $opts = array() ) {
    global $authordata;
    if ( !is_object( $authordata ) ) {
        return false;
    }

    $defaults = array(
        'echo'          => true,
        'wrap'          => '<a %HREF% %TITLE% %CLASS% %REL%>%AUTHOR%</a>',
        'class'         => 'author',
        'rel'           => 'author'
    );
    $opts = wp_parse_args( $opts, $defaults );

    $class = !empty($opts['class'])?'class="'.esc_attr($opts['class']).'"':'';
    $rel = !empty($opts['rel'])?'rel="'.esc_attr($opts['rel']).'"':'';
    $href = sprintf( 'href="%s"', get_author_posts_url($authordata->ID, $authordata->user_nicename) );
    $title = sprintf( 'title="%s"', esc_attr( sprintf( _x( 'Posts by %s', 'author link', LANGUAGE_ZONE ), get_the_author() ) ) );
    
    $output = str_replace(
        array( '%HREF%', '%TITLE%', '%CLASS%', '%REL%', '%AUTHOR%' ),
        array( $href, $title, $class, $rel, get_the_author() ),
        $opts['wrap']
    );
    $output = apply_filters( 'the_author_posts_link', $output );

    if( $opts['echo'] ) {
        print( $output );
    }
    return $output;
}

//TODO: delete? rwrite?
//	return image href
function dt_image_href( array $params ){
    // get img id
    if( isset($params['image_id']) ) {
        $img_id = $params['image_id'];
    }elseif( isset($params['post_id']) ) {
        $img_id = get_post_thumbnail_id( $params['post_id'] );
    }else
        return false;
        
    $o_width = isset( $params['width'] )?intval($params['width']):0;
    $o_height = isset( $params['height'] )?intval($params['height']):0;
    
    // get img src
    $img_meta = wp_get_attachment_image_src($img_id, 'large');
        
    // format image url
    if( $img_meta ){
        $img_src = $img_meta[0];
    }else{
        $img_src = get_template_directory_uri(). '/images/noimage.jpg'; // noimage image
    }
    
	$src = explode( $_SERVER['HTTP_HOST'], $img_src );
    
	if( isset($src[1]) ) {
		$img_src = $src[1];
	}else {
		$img_src = $img_src;
	}
	
    if( isset($params['upscale']) && false == $params['upscale']){
        // get img metadata( height, width )
        if( $o_width > $img_meta[1] ){
            $o_width = $img_meta[1];
        }
    }
    
    $args = '&zc=1&q=90';//isset($params['no_limits'])?'&no_limits=true':'';
    
    $url_base = get_template_directory_uri(). '/timthumb.php?src=';
    $w = $o_width?'&w='.$o_width:'';
    $h = $o_height?'&h='.$o_height:'';

    $output = $url_base . $img_src . $w . $h. $args;
    
    if ( !isset($params['full_list']) || !$params['full_list'] ) {
        return esc_url($output);
    }else {
        return array( 
            'href'	=>esc_attr($output),
            'size'	=>array(
                'width'		=>$img_meta[1],
                'height'	=>$img_meta[2]
            )
        );
    }
}
	
// get thumbnail
// input array()
// return array()
function dt_get_thumbnail( array $o ) {
    $img_id = false;
    $result = $img_size = array();
    $width = isset($o['width'])?intval($o['width']):0;
    $height = isset($o['height'])?intval($o['height']):0;
    $zc_align = isset($o['zc_align'])?$o['zc_align']:'c';
    $quality = isset($o['quality'])?$o['quality']:90;
    
    // get image id
    if( isset($o['post_id']) ){
        $img_id = get_post_thumbnail_id( intval($o['post_id']) );
    }elseif( isset($o['img_id']) ) {
        $img_id = intval( $o['img_id'] );
    }elseif( isset($o['src']) ) {
        $u_dir = wp_upload_dir();
        $img_path = str_replace($u_dir['baseurl'], $u_dir['basedir'], $o['src']);
        
        // if no such file - return false
        if( !@file_exists($img_path) ) {
            return false;
        }
        
        $img_id = true;
        $src_size = @getimagesize($img_path);
        if( is_array($src_size) ) {
            $img_size[] = $o['src'];
            $img_size[] = $src_size[0];
            $img_size[] = $src_size[1];
            $match_size = array( 'full', false );
        }else {
            return false;
        }
        unset($src_size);
    }else {
        return false;
    }
    
    // if no img_id - get first image from gallery
    if( empty($img_id) ) {
        
        global $post;
        if( empty($o['post_id']) ) {
            $o['post_id'] = $post->ID;
        }
        
        $args = array(
            'numberposts'       => 1,
            'order'             => 'ASC',
            'post_mime_type'    => 'image',
            'post_parent'       => $o['post_id'],
            'post_status'       => null,
            'post_type'         => 'attachment' //may use orderby
        );

        $attachments = get_children( $args );
        if( $attachments ) {
            $attachment = current($attachments);
            $img_id = $attachment->ID;
        }
    }
    
    // get image size
    if( empty($img_size) ) {
        $match_size = array( 'full', false );
        $img_size = wp_get_attachment_image_src($img_id, $match_size[0]);
        
        // if there is no images atall
        if( false == $img_size ) {
            $img_size = array(
                get_template_directory_uri().'/images/noimage.jpg',
                $width,
                $height
            );
            $match_size[1] = false;
        }
    }
    
    // construct result
    if( false === $match_size[1] ) {
        // get post options here
        $args = array(
//            'src'   => str_replace(site_url(), '', $img_size[0]),
            'q'     => $quality,
            'a'     => $zc_align
        );
        
		$src = explode($_SERVER['HTTP_HOST'], $img_size[0]);
    
		if( isset($src[1]) ) {
			$args['src'] = $src[1];
		}else {
			$args['src'] = $img_size[0];
		}
		
        // proportional downscale
        if( !isset($o['upscale']) || false == $o['upscale']) {
            if( $img_size[1] > $width || $img_size[2] > $height ) {
                $proportional_sizes = wp_constrain_dimensions(
                    $img_size[1],
                    $img_size[2],
                    $width,
                    $height
                );
          
                $width = $proportional_sizes[0];
                $height = $proportional_sizes[1];
            }else {
                $width = $img_size[1];
                $height = $img_size[2];
            }
        }else {
        // zoom + crop
            $args['zc'] = 1;
        }
        
        if( $width > 0 ) {
            $args['w'] = $width;
        }else {
            $proportional_sizes = wp_constrain_dimensions(
                $img_size[1],
                $img_size[2],
                $width,
                $height
            );
            $width = $proportional_sizes[0];
        }
        
        if( $height > 0 ) {
            $args['h'] = $height;
        }else {
            $proportional_sizes = wp_constrain_dimensions(
                $img_size[1],
                $img_size[2],
                $width,
                $height
            );
            $height = $proportional_sizes[1];
        }
        
        $result = array(
            'thumnail_img'  => esc_attr(add_query_arg(
                $args,
                get_template_directory_uri().'/timthumb.php'
            )),
            'width'         => $width,
            'height'        => $height
        );
    }else {
        $result = array(
            'thumnail_img'  => esc_attr($img_size[0]),
            'width'         => $img_size[1],
            'height'        => $img_size[2]
        );
    }
    
    $result['size_str'] = "width=\"{$result['width']}\" height=\"{$result['height']}\"";

    return $result;	
}

function dt_get_thumb_meta( $thumbs, $size = "full", $post_id = null ) {
    global $post;
    if( !$post_id ) {
        $post_id = $post->ID;
    }

    if( empty($thumbs) || !is_array($thumbs) || !isset($thumbs[$post_id]) ) {
        return false; 
    }
    
	if ( ! is_array( $thumbs[ $post_id ] ) || ! isset( $thumbs[ $post_id ]['data'] ) ) {
		return wp_get_attachment_image_src( $thumbs[ $post_id ], $size ) ;
	}
	
	$uploadsdir = wp_upload_dir();
    $file = $thumbs[$post_id]['data']['file'];
    $width = $thumbs[$post_id]['data']['width'];
    $height = $thumbs[$post_id]['data']['height'];

    if( 'full' != $size && isset($thumbs[$post_id]['data']['sizes'][$size]) ) {
	    $orig_file = end( explode('/', $file) );
	    $file = str_replace( $orig_file, $thumbs[$post_id]['data']['sizes'][$size]['file'], $file );
        $width = $thumbs[$post_id]['data']['sizes'][$size]['width'];
        $height= $thumbs[$post_id]['data']['sizes'][$size]['height'];
    }

    $file = $uploadsdir['baseurl'] . '/' . $file; 
    
    return array( $file, $width, $height, image_hwstring($width, $height) );
}

function dt_constrain_dim( $w0, $h0, &$w1, &$h1, $change = false ) {
    $prop_sizes = wp_constrain_dimensions( $w0, $h0, $w1, $h1 );
     
    if( $change ) {
        $w1 = $prop_sizes[0];
        $h1 = $prop_sizes[1];
    }
    return array( $w1, $h1 );
}

/**
 * add timthumb with args to img url
 * evaluate new width and height
 * $img - image meta array ($img[0] - image url, $img[1] - width, $img[2] - height)
 * $opts - options array, supports w, h, zc, a, q (see timthumb documentation)
 * @params: $img = array(), $opts = array()
 * return: array
 */
function dt_get_resized_img( $img, $opts = array() ) {
    if( !is_array($img) ) {
        $img[0] = get_template_directory_uri() . '/images/noimage.jpg';
        $img[1] = $img[2] = 1000;
        $img[3] = image_hwstring( $img[1], $img[2] );
    }
    
    if( empty($opts) || !is_array($opts) ) {
        return $img;
    }

    $defaults = array( 'w' => 0, 'h' => 0 , 'zc' => 1, 'force_zc' => 0 );
    $opts = wp_parse_args( $opts, $defaults );

    $w = $opts['w'];
    $h = $opts['h'];

    if ( ( $img[1] > $w ) && ( $img[2] > $h ) ) {
        if (
			( 3 == $opts['zc'] ) ||
            empty ( $w ) ||
            empty ( $h )
		) {
            dt_constrain_dim( $img[1], $img[2], $w, $h, true );
        }
    } elseif ( empty ( $w ) || empty ( $h ) ) {
        $prop = $img[1]/$img[2];
        
        if( empty ( $w ) ) {
            $w = $h*$prop;
        }else {
            $h = $w/$prop;
        }
    } elseif ( ! $opts['zc'] && ! $opts['force_zc'] ) {
        return array( $img[0], $img[1], $img[2], image_hwstring( $img[1], $img[2] ) );
    }
    
    $args['src'] = dt_clean_thumb_url( $img[0] );

    if( isset($opts['zc']) ) {
        $args['zc'] = $opts['zc'];
    }
    
    if( !empty($opts['w']) ) {
        $args['w'] = $opts['w'];
    }

    if( !empty($opts['h']) ) {
        $args['h'] = $opts['h'];
    }

    if( isset($opts['a']) ) {
        $args['a'] = $opts['a'];
    }

    if( isset($opts['q']) ) {
        $args['q'] = $opts['q'];
    }
	
	if( isset($opts['r_src']) && ! empty($opts['r_src']) ) {
        $args['r_src'] = dt_clean_thumb_url( $opts['r_src'] );
    }
	
    return array(
        esc_url( add_query_arg($args, get_template_directory_uri().'/timthumb.php') ),
        $w,
        $h,
        image_hwstring($w, $h)
    );
}

function dt_clean_thumb_url ( $src ) {
	// HTTP_HOST replaced with SERVER_NAME upon the recommendation of Miltiadis Koutsokeras
	$src_arr = explode( $_SERVER['HTTP_HOST'], $src );	

    if ( isset( $src_arr[1] ) ) {
		if ( is_multisite() && get_current_blog_id() > 1 ) {
			$blog_path = get_blog_details( get_current_blog_id() )->path;
			
			// some dirty ugly stupid trick
			if ( '/' == $blog_path ) {
				$blog_path = '%%';
				$src_arr[1] = '%%' . $src_arr[1];
			}
			
			// if this is not a theme image
			if ( false !== strpos( $src_arr[1], '/files/' ) ) {
				$src_arr[1] = str_replace( $blog_path, '/wp-content/blogs.dir/' . get_current_blog_id() . '/', $src_arr[1] );
			// else - strip off blog path
			} else {
				$src_arr[1] = str_replace( $blog_path, '', $src_arr[1] );
			}
		}
        $src = $src_arr[1];
    }
	return $src;
}

function dt_storage( $field_name = null, $data = null, $default = null ) {
    static $storage = array();

    if( empty($field_name) && empty($data) ) {
        return $storage; 
    }

    if( !empty($field_name) && (null === $data) && isset($storage[$field_name]) ) {
        return $storage[$field_name];
    }

    if( !empty($field_name) && !(null === $data) ) {
        $storage[$field_name] = $data;
        return true;
    }
    return $default;
}

function dt_get_thumb_img( $opts = array(), $wrap = '', $echo = true ) {
    global $post;
    
    // get default href and src for thumbnail
    if( !isset($opts['img_meta']) ) {
        $big = dt_get_thumb_meta( dt_storage( 'thumbs_array' ) );
    }else {
        $big = $opts['img_meta'];
    }

    // this is question
    if ( isset($opts['thumb_opts']) && (!empty($big) || !empty($opts['use_noimage'])) ) {
        $img = dt_get_resized_img( $big, $opts['thumb_opts'] );
    } elseif ( ! isset ( $opts['thumb_opts'] ) ) {
		$img = $big;
		$img[3] = image_hwstring( $img[1], $img[2] );
	} else {
        $big[0] = '#';
        $img[0] = $img[3] = null;
    }

    if( empty($wrap) ) {
        $wrap = '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE% %ALT% /></a>';
    }

    $defaults = array(
        'class'         => 'post thumbnail',
		'alt'			=> isset($post)?$post->post_title:'',
        'custom'        => '',
        'img_class'     => '',
        'img_meta'      => '',
        'thumb_opts'    => array(),
        'title'         => isset($post)?$post->post_title:'',
        'size'          => $img[3],
        'href'          => $big[0],
        'src'           => $img[0]
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( !$opts['src'] ) {
        return false;
    }

    $output = str_replace(
        array( '%HREF%', '%CLASS%', '%TITLE%', '%CUSTOM%', '%SRC%', '%IMG_CLASS%', '%SIZE%', '%ALT%' ),
        array(
            'href="' . esc_url( $opts['href'] ) . '"',
            'class="' . esc_attr( $opts['class'] ) . '"',
            'title="' . esc_attr( $opts['title'] ) . '"',
            strip_tags( $opts['custom'] ),
            'src="' . esc_url( $opts['src'] ) . '"',
            'class="' . esc_attr( $opts['img_class'] ) . '"',
            $opts['size'],
			'alt="' . esc_attr( $opts['alt'] ) . '"'
        ),
        $wrap
    );

    if( $echo ) {
        echo $output;
    }
    return $output;
} 

function dt_prepare_category_list_data( array $opts ) {
    $defaults = array(
        'taxonomy'          => null,
        'post_type'         => null,
        'terms'             => array(),
        'count_attachments' => false,
        'all_btn'           => true,
        'other_btn'         => true,
        'select'            => 'all',
        'post_ids'          => array()
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( !($opts['taxonomy'] && $opts['post_type'] && is_array($opts['terms'])) ) {
        return false;
    }
    
    $post_ids_str = '';
    $posts_terms_count = array();

    if( !empty($opts['post_ids']) ) {
        $opts['post_ids'] = array_map( 'intval', array_values($opts['post_ids']) );
        // check if posts exists
        $check_posts = new WP_Query( array('posts_per_page' => -1, 'post_status' => 'publish', 'post_type' => $opts['post_type'], 'post__in' => $opts['post_ids']) );
        if( $check_posts->have_posts() ) {
            $opts['post_ids'] = array();
            foreach( $check_posts->posts as $exist_post ) {
                $opts['post_ids'][] = $exist_post->ID;
            }
        }else {
            return false;
        }
        $post_ids_str = implode(',', $opts['post_ids']);
        $posts_terms = wp_get_object_terms( $opts['post_ids'], $opts['taxonomy'], array('fields' => 'all_with_object_id') );
            
        if( is_wp_error($posts_terms) ) {
            return false;
        }

        $opts['terms'] = array();
        foreach( $posts_terms as $post_term ) {
            if( !isset($posts_terms_count[$post_term->term_id]) ) {
                $posts_terms_count[$post_term->term_id] = 0;
            }
            
            $posts_terms_count[$post_term->term_id]++;
            if( 'except' == $opts['select'] && ($post_term->count - $posts_terms_count[$post_term->term_id]) <= 0 ) {
                $opts['terms'][] = $post_term->term_id;
            }elseif( 'only' == $opts['select'] ) {
                $opts['terms'][] = $post_term->term_id;
            }
        }		
    }

	$args = array(
        'type'          => $opts['post_type'],
        'hide_empty'    => 1,
        'hierarchical'  => 0,
        'taxonomy'      => $opts['taxonomy'],
        'pad_counts'    => false,
        'orderby'       => 'slug',
        'order'         => 'ASC',
    );

	if ( isset( $opts['terms']['child_of'] ) ) {
		$args['child_of'] = $opts['terms']['child_of'];
		$args['hide_empty'] = 0;
		unset( $opts['terms']['child_of'] );
	}
	
	if ( 'only' == $opts['select'] && empty( $opts['post_ids'] ) ) {
		$opts['other_btn'] = false;
	}
	
    // get all or selected categories
    $terms = $terms_all = get_categories( $args );
	$terms_all_arr = array();

	if ( ! empty( $opts['terms'] ) ) {
		$terms_arr = array_map( 'intval', array_values( $opts['terms'] ) );
		$terms_str = implode( ',', $terms_arr );

		foreach ( $terms as $index=>$trm ) {
			$terms_all_arr[] = $trm->term_id;
			if ( 'except' == $opts['select'] && in_array( $trm->term_id, $terms_arr ) ) {
				unset( $terms[ $index ] );
			} else if ( 'only' == $opts['select'] && !in_array( $trm->term_id, $terms_arr ) ) {
				unset( $terms[ $index ] );
			}
			
		}	
	}
//	asort( $terms );

    if ( empty( $terms ) ) {
        return false;
    }

	if ( ! isset( $terms_str ) ) {
		$terms_arr = array();
		foreach ( $terms as $term ) {
			$terms_all_arr[] = $term->term_id;
			$terms_arr[] = $term->term_id;
		}
		$terms_str = implode( ',', $terms_arr );
	}

    if( !empty($posts_terms_count) ) {
        foreach( $terms as $term ) {
            if( isset($posts_terms_count[$term->term_id]) ) {
                if( 'except' == $opts['select'] ) {
                    $term->count -= $posts_terms_count[$term->term_id];
                }elseif( 'only' == $opts['select'] ) {
                    $term->count = $posts_terms_count[$term->term_id];
                }
            }
        }
    }

    global $wpdb;

    $att_query = $all = $other = null;

    $attachments_query = <<<HERED
        SELECT ID, post_parent
        FROM $wpdb->posts
        WHERE post_type = 'attachment'
        AND post_status = 'inherit'
        AND post_mime_type LIKE 'image/%%'
        AND post_parent IN(%s)
HERED;
/*    
        $query_select = "SELECT ID FROM $wpdb->posts AS p";
        $query_where = " WHERE p.post_type = %s AND p.post_status = 'publish'"; 
        $query_join = " LEFT JOIN $wpdb->term_relationships AS tr ON tr.object_id = p.ID LEFT JOIN $wpdb->term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id";
        $query_term_id__in = " AND tt.term_id IN ($terms_str)";
        $query_term_id__not_in = " AND (tt.term_id NOT IN ($terms_str) OR tt.term_id IS NULL)";
        $query_group_by_id = " GROUP BY ID";
        $query_posts__in = " AND p.ID IN($post_ids_str)";
        $query_posts__not_in = " AND p.ID NOT IN($post_ids_str)";
        $query_group_by_id_object_id = "GROUP BY p.ID, tr.object_id";
        $query_having_object_id = " HAVING object_id IS NULL";
*/

    if ( $opts['all_btn'] ) {
/*
        $query = $query_where;
        
        switch( $opts['select'] ) {
        case 'only':
            if( !empty($opts['post_ids']) ) {
                $query .= $query_posts__in;
            }else {
                $query = $query_join . $query . $query_term_id__in . $query_group_by_id; 
            }
            break;
        case 'except':
            if( !empty($opts['post_ids']) ) {
                $query .= $query_posts__not_in;
            }else {
                $query = $query_join . $query . $query_term_id__not_in . $query_group_by_id;
            }
            break;
        }

        $all_ids = $wpdb->get_results( $wpdb->prepare($query_select . $query, $opts['post_type']) );
        $all = $all_ids;       
*/		
		
		
		$args = array(
			'no_found_rows'		=> true,
			'post_status'		=> 'publish',
			'post_type'			=> $opts['post_type'],
			'posts_per_page'	=> -1,
			'fields'			=> 'ids',
			'order'				=> 'ASC',
		);
		
        switch( $opts['select'] ) {
			case 'only':
				if ( !empty( $opts['post_ids'] ) ) {
					$args['post__in'] = $opts['post_ids'];
				} else {
					$args['tax_query'] = array( array(
						'taxonomy'	=> $opts['taxonomy'],
						'field'		=> 'id',
						'terms'		=> $terms_arr,
						'operator '	=> 'IN',
					) );
				}
				break;
			case 'except':
				if ( !empty( $opts['post_ids'] ) ) {
					$args['post__not_in'] = $opts['post_ids'];
				} else {
					$terms_diff_arr = array_values( array_diff( $terms_all_arr, $terms_arr ) );
					$args['tax_query'] = array(
						array(
							'taxonomy'	=> $opts['taxonomy'],
							'field'		=> 'id',
							'terms'		=> $terms_all_arr,
							'operator' 	=> 'NOT IN'
						)
					);
					if ( $terms_diff_arr ) {
						$args['tax_query']['relation']	= 'OR';
						$args['tax_query'][] = array(
							'taxonomy'	=> $opts['taxonomy'],
							'field'		=> 'id',
							'terms'		=> $terms_diff_arr,
							'operator' 	=> 'IN'
						);
					}
				}
				break;
        }

		add_filter('posts_clauses', 'dt_core_join_left_filter');
		$all_posts = new WP_Query( $args );
		remove_filter('posts_clauses', 'dt_core_join_left_filter');
		
		$all = $all_ids = $all_posts->posts;

		if ( $opts['count_attachments'] ) {
            foreach( $all_ids as $index=>$id ) {
                if ( post_password_required( $id ) ) {
                    unset( $all_ids[ $index ] );
                }
            }
            unset( $id );
            $all_ids = implode( ',', $all_ids );
            $all = $wpdb->get_results( str_replace( '%s', $all_ids, $attachments_query ) );
        }
		
    }

    if ( $opts['other_btn'] ) {    
/*        $query = $query_where;
        
        if( !empty($opts['post_ids']) ) { 
            switch( $opts['select'] ) {
                case 'only':
                $query .= $query_posts__in;
                break;
            case 'except':
                $query .= $query_posts__not_in;
                break;
            }
        }
        $query = $query_join . $query . $query_group_by_id_object_id . $query_having_object_id; 
        
        $other_ids = $wpdb->get_results( $wpdb->prepare( $query_select . $query , $opts['post_type']) );
        $other = $other_ids;
*/        
		$args = array(
			'no_found_rows'		=> true,
			'post_status'		=> 'publish',
			'post_type'			=> $opts['post_type'],
			'posts_per_page'	=> -1,
			'fields'			=> 'ids',
			'order'				=> 'ASC',
			'tax_query'			=> array(
				array(
					'taxonomy'	=> $opts['taxonomy'],
					'field'		=> 'id',
					'terms'		=> $terms_all_arr,
					'operator' 	=> 'NOT IN'
				)
			)
		);
		
		if ( !empty( $opts['post_ids'] ) ) {
			switch( $opts['select'] ) {
				case 'only':
					$args['post__in'] = $opts['post_ids'];
					break;
				case 'except':
					$args['post__not_in'] = $opts['post_ids'];
			}
		}
		
		$other_posts = new WP_Query( $args );
		$other_ids = $other = $other_posts->posts;
		
        if( $opts['count_attachments'] ) {
            foreach( $other_ids as $index=>$id ) {
                if ( post_password_required( $id ) ) {
                    unset( $other_ids[ $index ] );
                }
            }
            unset( $id );
            $other_ids = implode( ',', $other_ids );
            if( $other_ids )
                $other = $wpdb->get_results( str_replace('%s', $other_ids, $attachments_query) );
            else
                $other = null;
        }

    }

    if ( $opts['count_attachments'] && ! empty( $all_ids ) ) {
        $terms_count = $wpdb->get_results( "
            SELECT COUNT($wpdb->posts.ID) AS count, $wpdb->term_taxonomy.term_id AS term_id
            FROM $wpdb->posts
            JOIN $wpdb->term_relationships ON $wpdb->term_relationships.object_id = $wpdb->posts.post_parent
            JOIN $wpdb->term_taxonomy ON $wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id
            WHERE $wpdb->posts.post_type = 'attachment'
            AND $wpdb->posts.post_status = 'inherit'
            AND $wpdb->posts.post_mime_type LIKE 'image/%%'
            AND $wpdb->posts.post_parent IN($all_ids)
            GROUP BY $wpdb->term_taxonomy.term_id
        " );
        if( $terms_count ) {
            $term_count_arr = array();
            foreach( $terms_count as $t_count ) {
                $term_count_arr[$t_count->term_id] = $t_count->count;
            }
            foreach( $terms as &$term ) {
                if( isset($term_count_arr[$term->term_id]) ) {
                    $term->count = $term_count_arr[$term->term_id];
                } 
            }
            unset($term);
        }
    }
	
	if ( empty( $opts['terms'] ) && 'all' != $opts['select'] ) {
		$terms = array();
	}
	
    return array(
        'terms'         => $terms,
        'all_count'     => count( $all ),
        'other_count'   => count( $other )
    );
}

function dt_get_category_list( $opts = array(), $echo = true ) {
    global $post;

    $defaults = array(
        'wrap'              => '<div class="%CLASS%">%LIST%</div>',
        'item_wrap'         => '<a href="%HREF%" class="%CLASS%" title="%TERM_DESC%">%TERM_NICENAME%</a>',
        'hash'              => '#%TERM_ID%/%PAGE%',
        'item_class'        => 'filter',    
        'class'             => 'filters',
        'taxonomy'          => '',
        'post_type'         => '',
        'ajax'              => false,
        'current'           => '',
        'select'            => 'all',
        'page'              => '1',
        'terms'             => array(),
        'count_attachments' => false,
        'all_btn'           => true,
        'other_btn'         => true,
        'post_ids'          => array()
    );
    $opts = wp_parse_args( $opts, $defaults );
    $opts = apply_filters( 'dt_get_category_list_options', $opts );
		
    // if there are no terms or post ids passed - return empty string 
    if ( ( 'all' != $opts['select'] ) && empty( $opts['post_ids'] ) && empty( $opts['terms'] ) ) {
        return '';
    }

    $data = dt_prepare_category_list_data( array(
        'post_type'         => $opts['post_type'],
        'taxonomy'          => $opts['taxonomy'],
        'terms'             => $opts['terms'],
        'count_attachments' => $opts['count_attachments'],
        'select'            => $opts['select'],
        'post_ids'          => $opts['post_ids']
    ) );
    
    if ( ! $data || 
		( count( $data['terms'] ) == 1 && empty( $data['other_count'] ) ) ||
		 ( count( $data['terms'] ) < 1 && !empty( $data['other_count'] ) )
	) {
        return '';
    }
    
    $opts['hash'] = str_replace( '%PAGE%', $opts['page'], get_permalink() . $opts['hash'] );
    $output = $all = '';

    foreach( $data['terms'] as $term ) {
        $output .= str_replace( array( '%HREF%', '%CLASS%', '%TERM_DESC%', '%TERM_NICENAME%', '%COUNT%' ),
            array(
                str_replace( array( '%TERM_ID%' ), array( $term->term_id ), $opts['hash'] ),
                $opts['item_class'],
                $term->category_description,
                $term->cat_name,
                $term->count
            ), $opts['item_wrap']
        );
    }
   
    // all button

    if ( $opts['all_btn'] ) { 
        $all = str_replace( array( '%HREF%', '%CLASS%', '%TERM_DESC%', '%TERM_NICENAME%', '%COUNT%' ),
            array(
                str_replace( array( '%TERM_ID%' ), array( 'all' ), $opts['hash'] ),
                $opts['item_class'] . ' act',
                _x( 'All posts', 'category list', LANGUAGE_ZONE ),
                _x( 'All', 'category list', LANGUAGE_ZONE ),
                $data['all_count']
            ), $opts['item_wrap']
        );
    }

    // other button
    if( $data['other_count'] && $opts['other_btn'] ) {
        $output .= str_replace( array( '%HREF%', '%CLASS%', '%TERM_DESC%', '%TERM_NICENAME%', '%COUNT%' ),
            array(
                str_replace( array( '%TERM_ID%' ), array( 'none' ), $opts['hash'] ),
                $opts['item_class'],
                _x( 'Other posts', 'category list', LANGUAGE_ZONE ),
                _x( 'Other', 'category list', LANGUAGE_ZONE ),
                $data['other_count']
            ), $opts['item_wrap']
        ); 
    }

    $output = $all . $output;
    $output = str_replace( array( '%LIST%', '%CLASS%' ), array( $output, $opts['class'] ), $opts['wrap'] );

    if ( $echo ) {
        echo $output;
    } else {
        return $output;
    }
    return false;
}

function dt_get_embed( $src, $width = null, $height = null, $echo = true ) {
	global $wp_embed;
    if ( empty( $wp_embed ) ) return false;

	$video_shotcode = sprintf( '[embed%s%s]%s[/embed]',
        !empty($width)?' width="'.intval($width).'"':'',
        !empty($height)?' height="'.intval($height).'"':'',
        $src
    );
    $video_shotcode = $wp_embed->run_shortcode( $video_shotcode );

    if( $echo )  {
        echo $video_shotcode;
    }else {
        return $video_shotcode;
    }
    return false;
}

function dt_get_of_uploaded_image( $src ) {
	if ( ! $src ) return '';
	
	$uri = $src;
	if ( ! parse_url( $src, PHP_URL_SCHEME ) ) {
		$pattern = '/wp-content/';
		if ( get_current_blog_id() > 1 ) { $pattern = '/files/'; }
		
		if (  strpos( $src, $pattern ) !== false ) {
			$uri = site_url( $src );
		} else {
			$uri = get_template_directory_uri() . $src;
		}
	}
	
	return $uri;
}

/*
 *	Parse str to array with src, width and height
 *	expample: image.jpg?w=25&h=45
 */
function dt_parse_of_uploaded_image_src ( $str ) {
	if ( empty( $str ) ) { return array(); }
	
	$res_arr = array();
	$str_arr = explode( '?', $str );
	
	$res_arr[0] = dt_get_of_uploaded_image( current( $str_arr ) );
	
	if ( ! isset( $str_arr[1] ) ) { return array(); } 
	
	$args_arr = array();
	wp_parse_str( $str_arr[1], $args_arr );
	
	if ( isset( $args_arr['w'] ) && isset( $args_arr['h'] ) ) {
		$res_arr[1] = intval( $args_arr['w'] );
		$res_arr[2] = intval( $args_arr['h'] );
	} else {
		return array();
	}
	
	return $res_arr;
}

function dt_get_uploaded_logo ( $logo, $type = 'normal' ) {
	if( empty( $logo ) || ! is_array( $logo ) ) { return null; }
	
	$res_arr = null;
	
	if ( next( $logo ) ) {
		$logo_src = wp_get_attachment_image_src( current( $logo ), 'full' );
	} else {
		reset( $logo );
		$logo_src = dt_parse_of_uploaded_image_src( current( $logo ) );
	}
	
	if ( ! empty( $logo_src ) ) {
		
		switch ( $type ) {
			case 'retina' :
				$logo_src[1] = $logo_src[1]/2;
				$logo_src[2] = $logo_src[2]/2;
		}
		
		$res_arr = array(
			0			=> $logo_src[0],
			1			=> $logo_src[1],
			2			=> $logo_src[2],
			'src'		=> $logo_src[0],
			'width'		=> $logo_src[1],
			'height'	=> $logo_src[2],
			'size'		=> image_hwstring(  $logo_src[1], $logo_src[2] )
		);
	}
	return $res_arr;
}

function dt_uploader_style_script( $id, $params = array() ) {

	$defaults = array(
        'align'			=> '.align',
        'image-size'	=> '.image-size',
        'post_content'	=> '.post_content',
		'url'			=> '.url',
		'submit'		=> '.submit input.button'
	);
	$params = wp_parse_args( $params, $defaults );
	
	// clear empty fields
	foreach ( $params as $field=>$class ) {
		if ( ! $class || true === $class ) unset( $params[ $field ] );
	}
	
	$params = array_map( 'esc_attr', $params );
	$str = implode( ', ', $params );
?>
	<script type="text/javascript">
		jQuery('#<?php echo esc_attr( $id ); ?>').load( function() {
			var innerDoc = this.contentDocument || this.contentWindow.document;
				
			if( innerDoc ) {
				var css = '<?php echo $str; ?> { display: none; }',
					head = innerDoc.getElementsByTagName('head')[0],
					style = document.createElement('style');

					style.type = 'text/css';
					if(style.styleSheet){
						style.styleSheet.cssText = css;
					}else{
						style.appendChild(document.createTextNode(css));
					}
					head.appendChild(style);
			}
		});
	</script>
<?php	
}

function dt_core_get_favicon( $icon = null ) {
	$output = '';
	if ( ! empty( $icon ) ) {
		
		if ( strpos( $icon, '/wp-content' ) === 0 || strpos( $icon, '/files' ) === 0 ) {
			$icon = get_site_url() . $icon;
		}
		
		$ext = explode( '.', $icon );
		if ( count( $ext ) > 1 ) {
			$ext = end( $ext );
		} else {
			return '';
		}
		
		switch ( $ext ) {
			case 'png':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_PNG ) );
				break;
			case 'gif':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_GIF ) );
				break;
			case 'jpg':
			case 'jpeg':
				$icon_type = esc_attr( image_type_to_mime_type( IMAGETYPE_JPEG ) );
				break;
			case 'ico':
				$icon_type = esc_attr( 'image/x-icon' );
				break;
			default:
				return '';
		}
		
		$output .= '<!-- icon -->' . "\n";
		$output .= '<link rel="icon" href="' . $icon . '" type="' . $icon_type . '" />' . "\n";
		$output .= '<link rel="shortcut icon" href="' . $icon . '" type="' . $icon_type . '" />' . "\n";
	}
	return  $output;
}

/*	This function return array with thumbnail image meta for items list in admin are.
 *	If fitured image not set it gets last image by menu order.
 *	If there are no images and $noimage not empty it returns $noimage in other way it returns false
 **/ 

function dt_get_admin_thumbnail ( $post_id, $max_w = 100, $max_h = 100, $noimage = 'images/noimage_small.jpg' ) {
	$thumb = array();
	if ( has_post_thumbnail( $post_id ) ) {
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
	} else {
		$att_query = new WP_Query( array(
			'post_type' 		=> 'attachment',
			'post_status'		=> 'inherit',
			'post_parent'		=> $post_id,
			'posts_per_page'	=> 1,
			'post_mime_type'	=> 'image',
			'order'				=> 'DESC',
			'orderby'			=> 'menu_order'
		) );
		
		if ( count( $att_query->posts ) ) {
			$thumb = wp_get_attachment_image_src( $att_query->posts[0]->ID, 'thumbnail' );
		}
	}
	
	if ( empty( $thumb ) ) {
		if ( ! $noimage ) { return false; }
		
		$thumb = trailingslashit( get_template_directory_uri() ) . $noimage;
		$w = $max_w;
		$h = $max_h;
	} else {
		$sizes = wp_constrain_dimensions( $thumb[1], $thumb[2], $max_w, $max_h );
		$w = $sizes[0];
		$h = $sizes[1];
		$thumb = $thumb[0];
	}
	
	return array( esc_url( $thumb ), $w, $h );
}

/* This function print item thumbnail
 **/

function dt_admin_thumbnail ( $post_id ) {
	$thumbnail = dt_get_admin_thumbnail( $post_id );
		
	if ( $thumbnail ) {
		printf(
			'<a style="width: 100%%; text-align: center; display: block;" href="post.php?post=%d&action=edit" title=""><img src="%s" width="%d" height="%d" alt=""/></a>', 
			$post_id, $thumbnail[0], $thumbnail[1], $thumbnail[2]
		);
	}
}

function dt_get_google_fonts( $font = '', $effect = '' ) {
	if ( ! $font ) return;

	if ( array_key_exists( $effect, dt_get_web_fonts_effects() ) ) {
		$effect = '&effect=' . esc_attr( $effect ); 
	} else {
		$effect = '';
	}

	$protocol = "http";
	if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] == 'on' ) $protocol = "https";		
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo $protocol; ?>://fonts.googleapis.com/css?family=<?php echo str_replace( ' ', '+', $font ) . $effect; ?>">
	<?php
}

/* Beta fieture Google fonts effects
 * https://developers.google.com/webfonts/docs/getting_started
 */
function dt_get_web_fonts_effects () {
	$supported_effects = array(
		'anaglyph'			=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'brick-sign'		=> array( 'support' => 'Chrome, Safari' ),
		'canvas-print'		=> array( 'support' => 'Chrome, Safari' ),
		'crackle'			=> array( 'support' => 'Chrome, Safari' ),
		'decaying'			=> array( 'support' => 'Chrome, Safari' ),
		'destruction'		=> array( 'support' => 'Chrome, Safari' ),
		'distressed'		=> array( 'support' => 'Chrome, Safari' ),
		'distressed-wood'	=> array( 'support' => 'Chrome, Safari' ),
		'emboss'			=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'fire'				=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'fire-animation'	=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'fragile'			=> array( 'support' => 'Chrome, Safari' ),
		'grass'				=> array( 'support' => 'Chrome, Safari' ),
		'ice'				=> array( 'support' => 'Chrome, Safari' ),
		'mitosis'			=> array( 'support' => 'Chrome, Safari' ),
		'neon'				=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'outline'			=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'putting-green'		=> array( 'support' => 'Chrome, Safari' ),
		'scuffed-steel'		=> array( 'support' => 'Chrome, Safari' ),
		'shadow-multiple'	=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'splintered'		=> array( 'support' => 'Chrome, Safari' ),
		'static'			=> array( 'support' => 'Chrome, Safari' ),
		'stonewash'			=> array( 'support' => 'Chrome, Safari' ),
		'3d'				=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'3d-float'			=> array( 'support' => 'Chrome, Firefox, Opera, Safari' ),
		'vintage'			=> array( 'support' => 'Chrome, Safari' ),
		'wallpaper'			=> array( 'support' => 'Chrome, Safari' )
	);
	return $supported_effects;
}

function dt_get_web_font_effect( $type = '' ) {
	return '';
	$effect = of_get_option( 'fonts-effect', 'none' );
	if ( ! array_key_exists( $effect, dt_get_web_fonts_effects() ) ) { return ''; }
	
	if ( 'class' == $type ) {
		return 'font-effect-' . esc_attr( $effect );
	}
	return $effect;
}

function dt_add_qtranslate_hooks () {
	if ( defined( 'QT_SUPPORTED_WP_VERSION' ) ) {
		add_filter('the_posts',					'qtrans_postsFilter');
		add_filter('wp_setup_nav_menu_item',		'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage');
		
		// Compability with Default Widgets
		qtrans_optionFilter();
		add_filter('widget_title',				'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage',0);
		add_filter('widget_text',				'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage',0);
		
		// filter options
		add_filter('esc_html',					'qtrans_esc_html', 0);
		// don't filter untranslated posts in admin
		add_filter('posts_where_request',		'qtrans_excludeUntranslatedPosts');
		
		// leave terms in default language
		add_filter('cat_row',					'qtrans_useTermLib',0);
		add_filter('cat_rows',					'qtrans_useTermLib',0);
		add_filter('wp_get_object_terms',		'qtrans_useTermLib',0);
		add_filter('single_tag_title',			'qtrans_useTermLib',0);
		add_filter('single_cat_title',			'qtrans_useTermLib',0);
		add_filter('the_category',				'qtrans_useTermLib',0);
		add_filter('get_term',					'qtrans_useTermLib',0);
		add_filter('get_terms',					'qtrans_useTermLib',0);
		add_filter('get_category',				'qtrans_useTermLib',0);
		add_filter('get_comment_author',		'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage',0);
		add_filter('the_author',				'qtrans_useCurrentLanguageIfNotFoundUseDefaultLanguage',0);
	}
}

function dt_get_paged_var() {
    if ( !($pg = get_query_var('page')) ) {$pg = get_query_var('paged'); }
    return absint($pg);
}
