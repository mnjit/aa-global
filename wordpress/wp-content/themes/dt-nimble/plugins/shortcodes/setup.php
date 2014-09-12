<?php

require_once dirname( __FILE__ ) . '/visual-shortcodes/visual-shortcodes.php';

// shortcodes base url
define( 'DT_SHORTCODES_URL', DT_PLUGINS_URL . '/shortcodes' );

//ALLOW SHORTCODES IN WIDGETS
add_filter( 'widget_text', 'do_shortcode' );

//let's trick tinymce into thnking its a new version to clean up the cache
add_filter( 'tiny_mce_version', 'dt_shortcodes_refresh_mce' );
function dt_shortcodes_refresh_mce( $ver ) {
  $ver += 3;
  return $ver;
}

/*
Plugin Name: Shortcode Empty Paragraph Fix
Plugin URI: http://www.johannheyne.de/wordpress/shortcode-empty-paragraph-fix/
Description: Fix issues when shortcodes are embedded in a block of content that is filtered by wpautop.
Author URI: http://www.johannheyne.de
Version: 0.1
*/

add_filter( 'the_content', 'dt_shortcodes_empty_paragraph_fix' );
function dt_shortcodes_empty_paragraph_fix( $content ) {   
	$array = array (
		'<p>[' => '[', 
		']</p>' => ']', 
		']<br />' => ']'
	);
	$content = strtr($content, $array);
	return $content;
}

// TODO: reconstruct and rename to helpers.php
require_once( 'helpers_alpha.php' );

// TODO: delete in future
require_once( 'shortcodes_lib.php' );

// TinyMCE button class
require_once( 'includes/tinyMCE-button-class.php' );	

// List of shortcodes folders to include
// All folders located in /include
$shortcodes = array(
	'buttons',
	'tooltips',
	'toggle',
	'slider',
	'tabbed',
	'accordion',
	'highlight',
	'benefits',
	'framed-video',
	'map',
	'call-to-action',
	'text-box',
	'divider',
	'layout-builder',
	'widget-twitter',
	'widget-small-photos',
	'widget-popular-posts',
	'widget-testimonials',
	'widget-portfolio',
	'widget-partners',
	'widget-contactform',
);

foreach ( $shortcodes as $shortcode_dirname ) {
	$file_path = dirname( __FILE__ ) . '/includes/' . $shortcode_dirname . '/functions.php';
	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
}

/* Scott you are real skot */
