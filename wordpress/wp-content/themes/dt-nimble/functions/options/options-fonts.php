<?php
/**
 * Fonts options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// pege
$options[] = array(
    "page_title"    => _x('Fonts', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Fonts', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-fonts-menu",
    "type"          => "page"
);

$options[] = array( "name" => _x('Fonts', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Basic font-family', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options['fonts-font_family'] = array(
        "name"      => '',
        "desc"      =>  _x('Choose font', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-font_family",
        "std"       => "Trebuchet_MS",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $web_fonts
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Font size', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-font_size",
        "std"       => 12, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 12,
            'max'   => 16
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Contacts in top line', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-topline_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Content area', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Primary text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-primary_color",
        "std"   => "#474747",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Secondary text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-secondary_color",
        "std"   => "#00b8c2",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Footer', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Primary text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-primary_color",
        "std"   => "#e5e5e5",
        "type"  => "color"
    );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Secondary text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-secondary_color",
        "std"   => "#23a5ad",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Bottom line', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-bottomline_color",
        "std"   => "#767676",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Headers (h1-h6) font', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options['fonts-list'] = array(
        "name"      => '',
        "desc"      => _x('Choose Google Font from the list', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-list",
        "std"       => "Alice",
        "type"      => "web_fonts",
//        "class"     => "mini",
        "options"   => $google_fonts
    );

$options[] = array(	"type" => "block_end");

/* Beta feature */
/*
$options[] = array(	"name" => _x('Headers (h1-h6) font effect (BETA)', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );
	
	$effects = array( 'none' => 'none' );
	foreach ( dt_get_web_fonts_effects() as $effect=>$info ) {
		$effects[ $effect ] = sprintf( '%s (%s)', $effect, $info['support'] );
	}
	
    $options[] = array(
        "name"      => '',
        "desc"      => _x('Choose effect', 'theme-options', LANGUAGE_ZONE),
        "id"        => "fonts-effect",
        "std"       => "none",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $effects
    );

$options[] = array(	"type" => "block_end");
*/
/* end */

$options[] = array(	"name" => _x('Headers sizes', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $headers = array(
        'h1'    => array( 'desc' => 'H1', 'std' => 32 ), 
        'h2'    => array( 'desc' => 'H2', 'std' => 24 ), 
        'h3'    => array( 'desc' => 'H3', 'std' => 20 ),
        'h4'    => array( 'desc' => 'H4', 'std' => 17 ),
        'h5'    => array( 'desc' => 'H5', 'std' => 15 ),
        'h6'    => array( 'desc' => 'H6', 'std' => 12 )
    );
    
    foreach( $headers as $name=>$data) {
        $options[] = array(
            "name"      => '',
            "desc"      => $data['desc'],
            "id"        => "fonts-headers_size_" . $name,
            "std"       => $data['std'],
            "type"      => "text",
            "class"     => "mini"
        );
    }//end foreach
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Headers color in content area', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_content-headers_color",
        "std"   => "#2e2e2e",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Headers color in footer', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Text color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "fonts_footer-headers_bottom_color",
        "std"   => "#ebebeb",
        "type"  => "color"
    );

$options[] = array(	"type" => "block_end");
