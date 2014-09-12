<?php
/**
 * Buttons options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
    "page_title"    => _x('Buttons', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Buttons', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-buttons-menu",
    "type"          => "page"
);

$options[] = array( "name" => _x('Buttons', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Normal stance', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	$options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-bg_color",
        "std"   => "#01c9d6",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-font_color",
        "std"   => "#ffffff",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font shadow color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-font_shadow",
        "std"   => "#0096a0",
        "type"  => "color"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Active stance', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	$options[] = array(
        "name"  => '',
        "desc"  => _x('Background color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-active_bg_color",
        "std"   => "#c1c1c1",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-active_font_color",
        "std"   => "#ffffff",
        "type"  => "color"
    );
	
	$options[] = array(
        "name"  => '',
        "desc"  => _x('Font shadow color', 'theme-options', LANGUAGE_ZONE),
        "id"    => "buttons-active_font_shadow",
        "std"   => "#969696",
        "type"  => "color"
    );
	
$options[] = array(	"type" => "block_end");

?>