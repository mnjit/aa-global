<?php

// module uri
if( !defined('DT_SLIDESHOWS_URI') ) {
    define( 'DT_SLIDESHOWS_URI', get_template_directory_uri(). '/functions/modules/dt-slideshows' );
}

// Setup custom post type
function dt_slider_setup_post_type() {

// titels
$labels = array(
    'name'                  => _x('Slideshows', 'backend slideshow', LANGUAGE_ZONE),
    'singular_name'         => _x('Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'add_new'               => _x('Add New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'new_item'              => _x('New Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'view_item'             => _x('View Slideshow', 'backend slideshow', LANGUAGE_ZONE),
    'search_items'          => _x('Search', 'backend slideshow', LANGUAGE_ZONE),
    'not_found'             => _x('No Slideshows Found', 'backend slideshow', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No Slideshows found in Trash', 'backend slideshow', LANGUAGE_ZONE),
    'parent_item_colon'     => '',
    'menu_name'             => _x('Slideshows', 'backend slideshow', LANGUAGE_ZONE)
);

$img = DT_SLIDESHOWS_URI. '/images/admin_ico_slides.png';

$args = array(
    'labels'                => $labels,
    'public'                => false,
    'publicly_queryable'    => false,
    'show_ui'               => true, 
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => false,
    'capability_type'       => 'post',
    'has_archive'           => false, 
    'hierarchical'          => false,
    'menu_position'         => 42,
    'menu_icon'             => $img,
    'supports'              => array( 'thumbnail', 'title' )
);
register_post_type( 'dt_slider', $args);
/* post type end */

}
add_action( 'init', 'dt_slider_setup_post_type' );

include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>