<?php
/**
 * Backgrounds options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
    "page_title"    => _x('Backgrounds', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Backgrounds', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-backgrounds-menu",
    "type"          => "page"
);

/*
 *	Content area
 */
$options[] = array( "name" => _x('Content area', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Icons', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );
	
    $options[] = array(
        "name"  	=> '',
        "desc"  	=> _x('Icons style', 'theme-options', LANGUAGE_ZONE),
        "id"    	=> "main-icons_style",
        "std"   	=> "black",
        "type"  	=> "radio",
		"options"	=> array(
			'black'	=> _x('Dark', 'theme-options', LANGUAGE_ZONE),	
			'white'	=> _x('Light', 'theme-options', LANGUAGE_ZONE)
		)
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Icons opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main-icons_opacity",
        "std"       => 70, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Main background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    // bg color
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "main_bg-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    // bg image
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "background-bg_image",
        "std"       => 'none',
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/content/pattern-main', 'images/backgrounds' )
    );

    // upload bg					
    $options[] = array(
        "name"      => '',
        "desc"      => _x('... or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        // uploader
        $options[] = array( "name" => "", "desc" => "", "id" => "main_bg-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => array_merge( $fl_arr, array('full-screen' => _x('full screen', 'backend options', LANGUAGE_ZONE)) )
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );
	
	// fixed background				
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Fixed background', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_fixed",
        "std"       => "0",
        "type"      => "checkbox"
    );
	
	// hide in mobile layout			
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Hide in mobile layout', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-bg_mobile_hide",
        "std"       => "1",
        "type"      => "checkbox"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Overlay', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );
	
	// enable overlay
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Enable overlay', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-overlay_enable",
        "std"       => "0",
        "type"      => "checkbox"
    );
	
    // overlay image
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose overlay image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-overlay_image",
        "std"       => 'none',
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/content/overlay', 'images/backgrounds' )
    );

    // upload overlay					
    $options[] = array(
        "name"      => '',
        "desc"      => _x('... or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "main_bg-overlay_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        // uploader
        $options[] = array( "name" => "", "desc" => "", "id" => "main_bg-overlay_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

$options[] = array(	"type" => "block_end");

    $divs_and_heads = array(

        array(
            'img_desc'   => _x('Choose thick divider', 'theme-options', LANGUAGE_ZONE),
            'img_std'    => 'none',
            'img_opts'   => dt_get_images_in( 'images/backgrounds/content/div-big', 'images/backgrounds' ),
            'prefix'     => 'wide_divider',
            'block_name' => 'Thick divider'
        ),
        array(
            'img_desc'   => _x('Choose thin divider', 'theme-options', LANGUAGE_ZONE),
            'img_std'    => 'none',
            'img_opts'   => dt_get_images_in( 'images/backgrounds/content/div-small', 'images/backgrounds' ),
            'prefix'     => 'narrow_divider',
            'block_name' => 'Thin divider'
        )
    );
    
    foreach( $divs_and_heads as $opts_set ) {
		
		$options[] = array(	"name" => _x($opts_set['block_name'], 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");
        
        $opts_set['prefix'] = 'content_' . $opts_set['prefix'];

        $options[] = array(
            "name"      => '',
            "desc"      => $opts_set['img_desc'],
            "id"        => "divs_and_heads-" . $opts_set['prefix'],
            "std"       => $opts_set['img_std'], 
            "type"      => "images",
            "options"   => $opts_set['img_opts'] 
        );

        $options[] = array(
            "name"      => '',
            "desc"      => _x('... or upload your own image', 'theme-options', LANGUAGE_ZONE),
            "id"        => "divs_and_heads-{$opts_set['prefix']}_upload",
            "std"       => "0",
            "type"      => "checkbox",
            'options'   => array( 'java_hide' => true )
        );

        $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "divs_and_heads-{$opts_set['prefix']}_custom", "type" => "upload");

        $options[] = array( 'type' => 'js_hide_end' ); 

        $options[] = array(
            "name"  => '',
            "desc"  => _x('Repeat-x', 'theme-options', LANGUAGE_ZONE),
            "id"    => "divs_and_heads-{$opts_set['prefix']}_repeatx",
            "std"   => "0",
            "type"  => "checkbox"
        );

        $options[] = array( "type" => "block_end");
    }

$options[] = array(	"name" => _x('Widgets/shortcodes background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "widgetcodes-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "widgetcodes-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

/*
 *	Headers
 */
$options[] = array( "name" => _x('Headers', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Contact icons', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );
	
    $options[] = array(
        "name"  	=> '',
        "desc"  	=> _x('Icons style', 'theme-options', LANGUAGE_ZONE),
        "id"    	=> "header-icons_style",
        "std"   	=> "white",
        "type"  	=> "radio",
		"options"	=> array(
			'black'	=> _x('Dark', 'theme-options', LANGUAGE_ZONE),	
			'white'	=> _x('Light', 'theme-options', LANGUAGE_ZONE)
		)
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Icons opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header-icons_opacity",
        "std"       => 70, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Header on homepage', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/art-header-main', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "header_homepage-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_repeat",
        "std"       => "no-repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_vertical_pos",
        "std"       => "top",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_homepage-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Header on content pages', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/art-header-inner', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "header_content-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_repeat",
        "std"       => "no-repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_vertical_pos",
        "std"       => "top",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "header_content-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Top line background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "top_line-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_opacity",
        "std"       => 100, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/header/line-top', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "top_line-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "top_line-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

/*
 * Footer
 */
$options[] = array( "name" => _x('Footer', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Footer background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "footer-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/footer/pattern-footer', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "footer-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "footer-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

    $divs_and_heads[0]['img_desc'] = _x('Choose decorative line', 'theme-options', LANGUAGE_ZONE);
    $divs_and_heads[0]['img_opts'] = dt_get_images_in( 'images/backgrounds/footer/line-decor', 'images/backgrounds' );
    $divs_and_heads[0]['block_name'] = 'Decorative line above the footer';
 
/* Dividers here */

    $divs_and_heads[1]['img_desc'] = _x('Choose divider', 'theme-options', LANGUAGE_ZONE);
    $divs_and_heads[1]['img_opts'] = dt_get_images_in( 'images/backgrounds/footer/div-footer', 'images/backgrounds' );
    $divs_and_heads[1]['block_name'] = 'Dividers in footer widgets';

    foreach( $divs_and_heads as $opts_set ) {
		
        $options[] = array(	"name" => _x($opts_set['block_name'], 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");
		
        $opts_set['prefix'] = 'footer_' . $opts_set['prefix'];

        $options[] = array(
            "name"      => '',
            "desc"      => $opts_set['img_desc'],
            "id"        => "divs_and_heads-" . $opts_set['prefix'],
            "std"       => $opts_set['img_std'], 
            "type"      => "images",
            "options"   => $opts_set['img_opts'] 
        );
		
		if( 'footer_wide_divider' == $opts_set['prefix'] ) {
			$options[] = array(
				"name"      => '',
				"desc"      => _x('hide if the widget area in the footer is disabled', 'theme-options', LANGUAGE_ZONE),
				"id"        => "divs_and_heads-{$opts_set['prefix']}_hide_if_no_footer",
				"std"       => "0",
				"type"      => "checkbox"
			);
		}
		
        $options[] = array(
            "name"      => '',
            "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
            "id"        => "divs_and_heads-{$opts_set['prefix']}_upload",
            "std"       => "0",
            "type"      => "checkbox",
            'options'   => array( 'java_hide' => true )
        );

        $options[] = array( 'type' => 'js_hide_begin' );

            $options[] = array( "name" => "", "desc" => "", "id" => "divs_and_heads-{$opts_set['prefix']}_custom", "type" => "upload");

        $options[] = array( 'type' => 'js_hide_end' ); 

        $options[] = array(
            "name"  => '',
            "desc"  => _x('Repeat-x', 'theme-options', LANGUAGE_ZONE),
            "id"    => "divs_and_heads-{$opts_set['prefix']}_repeatx",
            "std"   => "0",
            "type"  => "checkbox"
        );

        $options[] = array(	"type" => "block_end");
    }

$options[] = array(	"name" => _x('Background in footer widgets', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "widgetcodes_footer-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "widgetcodes_footer-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Bottom line background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "bottom_line-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_opacity",
        "std"       => 17, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/footer/line-bottom', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "bottom_line-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' ); 

    // repeat
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Repeat', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_repeat",
        "std"       => "repeat",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $fl_arr
    );

    // vertical
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Vertical position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_vertical_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $v_arr
    );

    // horizontal
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Horizontal position', 'theme-options', LANGUAGE_ZONE),
        "id"        => "bottom_line-bg_horizontal_pos",
        "std"       => "center",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $h_arr
    );

$options[] = array(	"type" => "block_end");

/*
 *	Boxed Layout
 */
$options[] = array( "name" => _x('Boxed Layout', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Enable Boxed Layout', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	$options[] = array(
        "name"      => '',
        "desc"      => _x('Enable', 'theme-options', LANGUAGE_ZONE),
        "id"        => "boxed_layout-enable",
        "std"       => "1",
        "type"      => "checkbox",
        'options'   => array( 'java_hide_global' => true )
    );
	
$options[] = array(	"type" => "block_end");	

$options[] = array( 'type' => 'js_hide_begin' );

$options[] = array(	"name" => _x('Background', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	$options[] = array(
        "name"  => '',
        "desc"  => _x('Color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "boxed_layout-bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "boxed_layout-bg_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Choose background image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "boxed_layout-bg_image",
        "std"       => 'none', 
        "type"      => "images",
        "options"   => dt_get_images_in( 'images/backgrounds/boxed', 'images/backgrounds' ) 
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('...or upload your own image', 'theme-options', LANGUAGE_ZONE),
        "id"        => "boxed_layout-bg_upload",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "name" => "", "desc" => "", "id" => "boxed_layout-bg_custom", "type" => "upload" );

    $options[] = array( 'type' => 'js_hide_end' );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Shadow color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "boxed_layout-shadow_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Shadow opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "boxed_layout-shadow_opacity",
        "std"       => 0, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array( 'type' => 'js_hide_end' );

/*
 *	Color Accent
 */
$options[] = array( "name" => _x('Color accent', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Color accent', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

     $options[] = array(
        "name"  => '',
        "desc"  => _x('Accent color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "accent-color",
        "std"   => "#00D0DD",
        "type"  => "color"
    );
	
$options[] = array(	"type" => "block_end");
