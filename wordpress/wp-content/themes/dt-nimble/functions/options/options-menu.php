<?php
/**
 * Menu options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
    "page_title"    => _x('Menu', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Menu', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-menu-menu",
    "type"          => "page"
);

$options[] = array( "name" => _x('Menu', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Make parent menu items clickable', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	// parent menu clickable
	$options[] = array(
		"name"  => "",
		"desc"  => _x('Enable', 'theme-options', LANGUAGE_ZONE),
		"id"    => "menu-parent_menu_clickable",
		"std"   => "0",
		"type"  => "checkbox"
	);

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('First level', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"      => '',
        "desc"      =>  _x('Choose font', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_font",
        "std"       => "Trebuchet_MS",
        "type"      => "select",
        "class"     => "mini",
        "options"   => $web_fonts 
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Bold', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_font_bold",
        "std"       => "0",
        "type"      => "checkbox"
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Italic', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_font_italic",
        "std"       => "0",
        "type"      => "checkbox"
    );
	
	$options[] = array(
        "name"      => '',
        "desc"      => _x('Font size', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_font_size",
        "std"       => "14",
		"class"		=> 'mini',
        "type"      => "text"
    );

	$options[] = array(
        "name"      => '',
        "desc"      => _x('Uppercase', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_font_upper",
        "std"       => "0",
        "type"      => "checkbox"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-first_font_color",
        "std"   => "#474747",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color (active)', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-first_font_color_active",
        "std"   => "#00B8C2",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Line color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-first_hoover_line_color",
        "std"   => "#00B8C2",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Hoover color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-first_hoover_color",
        "std"   => "#000000",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Hoover opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-first_hoover_opacity",
        "std"       => 6, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

	$options[] = array(
        "name"  => '',
        "desc"  => _x('Bottom menu line color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-line_color",
        "std"   => "#000000",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Bottom menu line opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-line_opacity",
        "std"       => 20, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Second level', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-second_font_color",
        "std"   => "#ffffff",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color (active)', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-second_font_color_active",
        "std"   => "#00B8C2",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "menu-second_bg_color",
        "std"   => "#EDEDED",
        "type"  => "color"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Background opacity', 'theme-options', LANGUAGE_ZONE),
        "id"        => "menu-second_bg_opacity",
        "std"       => 80, 
        "type"      => "slider",
        "options"   => array(
            'min'   => 0,
            'max'   => 100
        )
    );
	
$options[] = array(	"type" => "block_end");

?>