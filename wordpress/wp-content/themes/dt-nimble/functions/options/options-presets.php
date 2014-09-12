<?php
/**
 * Skins options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array( "name" => _x('Skins', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Select a skin', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

$options[] = array(
    "name"      => '',
    "desc"      => '',
    "id"        => "of-preset",
    "std"       => 'blue', 
    "type"      => "images",
    "options"   => optionsframework_get_presets_list()
);

$options[] = array(	"type" => "block_end");
