<?php
/**
 * Captcha options
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
     "page_title"   => _x( 'Captcha', 'theme-options page title', LANGUAGE_ZONE ),
     "menu_title"   => _x( 'Captcha', 'theme-options menu title', LANGUAGE_ZONE ),
     "menu_slug"    => "of-captcha-menu",
     "type"         => "page"
);

$options[] = array( "name" => _x( 'Captcha options', 'backend', LANGUAGE_ZONE ), "type" => "heading" );

// enable for
$options[] = array(	"name" => _x( 'Enable CAPTCHA on the:', 'backend', LANGUAGE_ZONE ),
					"type" => "block_begin" );                    

// hide for register
$options[] = array( "name" => "",
                    "desc" => _x( "do not show CAPTCHA to registered users", 'backend', LANGUAGE_ZONE ),
                    "id" => "captcha_hide_register",
                    "std" => "1",
                    "type" => "checkbox" );

$options[] = array(	"type" => "block_end" );

// arithmetic
$options[] = array(	"name" => _x( 'Arithmetic actions for CAPTCHA:', 'backend', LANGUAGE_ZONE ),
					"type" => "block_begin");

// minus
$options[] = array( "name" => "",
                    "desc" => _x( "minus (-)", 'backend', LANGUAGE_ZONE ),
                    "id" => "captcha_math_action_minus",
                    "std" => "1",
                    "type" => "checkbox" );
                    
// multiply
$options[] = array( "name" => "",
                    "desc" => _x( "multiply (x)", 'backend', LANGUAGE_ZONE ),
                    "id" => "captcha_math_action_increase",
                    "std" => "1",
                    "type" => "checkbox" );
                    
$options[] = array(	"type" => "block_end");

// difficulty
$options[] = array(	"name" => _x( 'Difficulty for CAPTCHA:', 'backend', LANGUAGE_ZONE ),
					"type" => "block_begin");
                    
// numbers
$options[] = array( "name" => "",
                    "desc" => _x( "numbers", 'backend', LANGUAGE_ZONE ),
                    "id" => "captcha_difficulty_number",
                    "std" => "1",
                    "type" => "checkbox" );
                    
// words
$options[] = array( "name" => "",
                    "desc" => _x( "words", 'backend', LANGUAGE_ZONE ),
                    "id" => "captcha_difficulty_word",
                    "std" => "1",
                    "type" => "checkbox" );
                    
$options[] = array(	"type" => "block_end");
