<?php
/**
 * Misc options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// page
$options[] = array(
    "page_title"    => _x('Misc', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Misc', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-misc-menu",
    "type"          => "page"
);

// MISC
$options[] = array( "name" => _x('Misc', 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

// create static css or not
$options[] = array(	"name" => _x('Save options', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  => "",
        "desc"  => _x( 'Create static css (beta)', 'theme-options', LANGUAGE_ZONE ),
        "id"    => "misc-static_css",
        "std"   => "0",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Rollovers', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  => "",
        "desc"  => _x('Use blur', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-rollover_blur",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Images', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  	=> "",
		"explain"	=> _x('(Attention! You need to clear your browser cache in order to see the effect of this option.)', 'theme-options', LANGUAGE_ZONE),
        "desc"  	=> _x('Use Retina images', 'theme-options', LANGUAGE_ZONE),
        "id"    	=> "misc-retina_images",
        "std"   	=> "1",
        "type"  	=> "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Responsiveness', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  	=> "",
        "desc"  	=> _x('Turn OFF responsiveness', 'theme-options', LANGUAGE_ZONE),
        "id"    	=> "misc-off_responsivness",
        "std"   	=> "0",
        "type"  	=> "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Contacts in header', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Show contacts in header', 'theme-options', LANGUAGE_ZONE),
        "id"        => "misc-show_header_contacts",
        "std"       => "0",
        "type"      => "checkbox",
        'options'   => array( 'java_hide' => true )
    );
    
    $contact_fields = array(
        array(
            'prefix'    => 'address',
            'desc'      => _x('Adress', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'phone',
            'desc'      => _x('Phone', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'email',
            'desc'      => _x('Email', 'theme-options', LANGUAGE_ZONE) 
        ),
        array(
            'prefix'    => 'skype',
            'desc'      => _x('Skype', 'theme-options', LANGUAGE_ZONE) 
        ),
		array(
            'prefix'    => 'work_hours',
            'desc'      => _x('Working hours', 'theme-options', LANGUAGE_ZONE) 
        ),
    );

    $options[] = array( 'type' => 'js_hide_begin' );

        foreach( $contact_fields as $field ) {
        
            $options[] = array(
                "name"      => '',
                "desc"      => $field['desc'],
                "id"        => "misc-contact_" . $field['prefix'],
                "std"       => "",
                "type"      => "text",
                'sanitize'  => false
            );

        }

    $options[] = array(	"type" => "block_end");

$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Show next/prev links', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show prev/next in post
    $options[] = array(
        "name"  => "",
        "desc"  => _x('on blog post page', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_next_prev_post",
        "std"   => "1",
        "type"  => "checkbox"
    );

	// show prev/next in portfolio
    $options[] = array(
        "name"  => "",
        "desc"  => _x('on portfolio project page', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_next_prev_portfolio",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Top line options', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

     // show top line
    $options[] = array(
        "name"  => "",
        "desc"  => _x('Show top line', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_top_line",
        "std"   => "1",
        "type"  => "checkbox"
    );
    
    // show search
    $options[] = array(
        "name"  => "",
        "desc"  => _x('Show search form', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_search_top",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

$options[] = array(	"name" => _x('Post options', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    // show author details
    $options[] = array(
        "name"  => "",
        "desc"  => _x('Show author info in posts', 'theme-options', LANGUAGE_ZONE),
        "id"    => "misc-show_author_details",
        "std"   => "1",
        "type"  => "checkbox"
    );
	
$options[] = array(	"type" => "block_end");

/*
$options[] = array(	"name" => _x('Image hovers', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

	// image hovers
    $options[] = array(
        "name"  	=> "",
        "desc"  	=> _x('Image hovers', 'theme-options', LANGUAGE_ZONE),
        "id"    	=> "misc-image_hovers",
        "std"   	=> "fade",
        "type"  	=> "select",
		"class"     => "mini",
		"options"	=> $image_hovers
    );
	
$options[] = array(	"type" => "block_end");
*/

$options[] = array(	"name" => _x('Analytics', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin");

    $options[] = array(
        "name"      => '',
        "desc"      => _x('Analytics code', 'theme-options', LANGUAGE_ZONE),
        "id"        => "misc-analitics_code",
        "std"       => false,
        "type"      => "textarea",
        "sanitize"  => false
    );

$options[] = array(	"type" => "block_end");