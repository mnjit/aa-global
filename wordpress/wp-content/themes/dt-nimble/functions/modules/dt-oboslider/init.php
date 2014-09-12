<?php

// module uri

if( !defined('DT_OBO_SLIDER_URI') ) {
    define( 'DT_OBO_SLIDER_URI', get_template_directory_uri(). '/functions/modules/dt-oboslider' );
}

// Setup custom post type
function dt_obo_slider_setup_post_type() {

// titels
$labels = array(
    'name'                  => _x('OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'singular_name'         => _x('OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'add_new'               => _x('Add New OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'new_item'              => _x('New OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'view_item'             => _x('View OneByOne Slide', 'backend obo slides', LANGUAGE_ZONE),
    'search_items'          => _x('Search', 'backend obo slides', LANGUAGE_ZONE),
    'not_found'             => _x('No OneByOne Slides Found', 'backend obo slides', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No OneByOne Slides found in Trash', 'backend obo slides', LANGUAGE_ZONE),
    'parent_item_colon'     => '',
    'menu_name'             => _x('OneByOne Slider', 'backend obo slides', LANGUAGE_ZONE)
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
    'menu_position'         => 41,
    'menu_icon'             => $img,
    'supports'              => array( 'thumbnail', 'title', 'editor' )
);
register_post_type( 'dt_obo_slider', $args);
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',        'backend portfolio', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',          'backend portfolio', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category','backend portfolio', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',        'backend portfolio', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',   'backend portfolio', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',  'backend portfolio', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',     'backend portfolio', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',   'backend portfolio', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',  'backend portfolio', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name', 'backend portfolio', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',        'backend portfolio', LANGUAGE_ZONE )
); 	

register_taxonomy(
    'dt_obo_slider_category',
    array( 'dt_obo_slider' ),
    array(
        'hierarchical'          => true,
        'show_in_nav_menus '    => false,
        'public'                => false,
        'show_tagcloud'         => false,
        'labels'                => $labels,
        'show_ui'               => true,
        'rewrite'               => true
    )
);
/* taxonomy end */

}
add_action('init', 'dt_obo_slider_setup_post_type');

//include_once 'functions.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';
?>