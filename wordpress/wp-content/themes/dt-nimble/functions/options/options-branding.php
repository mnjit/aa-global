<?php
/**
 * Branding options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
    "page_title"    => _x('Branding', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Branding', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-branding-menu",
    "type"          => "page"
);

$options[] = array( "name" => _x('Branding', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Logo in header', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    // logo
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-header_logo',
        "type"  => 'upload',
        'std'   => ''
    );
	
	// logo retina
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Retina Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-retina_header_logo',
        "type"  => 'upload',
        'std'   => ''
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Mobile logo', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    // logo
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-header_mobile_logo',
        "type"  => 'upload',
        'std'   => ''
    );
	
	// logo retina
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Retina Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-retina_header_mobile_logo',
        "type"  => 'upload',
        'std'   => ''
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Logo in footer', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // logo
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-footer_logo',
        "type"  => 'upload',
        'std'   => ''
    );
	
	// logo retina
    $options[] = array(
        "name"  => '',
        "desc"  => _x('Retina Logo', 'theme-options', LANGUAGE_ZONE),
		"mode"	=> 'with_id',
        "id"    => 'branding-retina_footer_logo',
        "type"  => 'upload',
        'std'   => ''
    );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Favicon', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // favicon
    $options[] = array( "name" => '', "desc" => '', "id" => "branding-favicon", "type" => "upload" );

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Copyright & Credits', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"  => '',
        "desc"  => _x('Copyright information', 'theme-options', LANGUAGE_ZONE),
        "id"    => "branding-copyrights",
        "std"   => false,
        "type"  => "textarea"
    );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Give credits to Dream-Theme', 'theme-options', LANGUAGE_ZONE),
        "id"        => "branding-dt_credits",
        "std"       => "1",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );
    
    $options[] = array( 'type' => 'js_hide_begin' );

        $options[] = array( "desc"  => 'Thank you so much!', "type" => "info" );
    
    $options[] = array( 'type' => 'js_hide_end' ); 

$options[] = array(	"type" => "block_end");
