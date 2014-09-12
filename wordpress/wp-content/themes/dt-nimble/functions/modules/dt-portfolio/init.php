<?php

// module uri
if( !defined('DT_PORTFOLIO_URI') ) {
    define( 'DT_PORTFOLIO_URI', get_template_directory_uri(). '/functions/modules/dt-portfolio' );
}

// Setup custom post type
function dt_portfolio_setup_post_type() {

// titles
$labels = array(
    'name'                  => _x('Portfolio',              'backend portfolio', LANGUAGE_ZONE),
    'singular_name'         => _x('Portfolio',              'backend portfolio', LANGUAGE_ZONE),
    'add_new'               => _x('Add New',                'backend portfolio', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Item',           'backend portfolio', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Item',              'backend portfolio', LANGUAGE_ZONE),
    'new_item'              => _x('New Item',               'backend portfolio', LANGUAGE_ZONE),
    'view_item'             => _x('View Item',              'backend portfolio', LANGUAGE_ZONE),
    'search_items'          => _x('Search Items',           'backend portfolio', LANGUAGE_ZONE),
    'not_found'             => _x('No items found',         'backend portfolio', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No items found in Trash','backend portfolio', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Portfolio', 'backend portfolio', LANGUAGE_ZONE)
);

$img = DT_PORTFOLIO_URI. '/images/admin_ico_portfolio.png';

// options
$args = array(
    'labels'                => $labels,
    'public'                => true,
    'publicly_queryable'    => true,
    'show_ui'               => true,
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => true,
    'capability_type'       => 'post',
    'has_archive'           => true, 
    'hierarchical'          => false,
    'menu_position'         => 47,
    'menu_icon'             => $img,
    'supports'              => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' )
);
register_post_type( 'dt_portfolio', $args );
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
    'dt_portfolio_category',
    array( 'dt_portfolio' ),
    array(
        'hierarchical'          => true,
        'public'                => true,
        'labels'                => $labels,
        'show_ui'               => true,
        'rewrite'               => true
    )
);
/* taxonomy end */

}
add_action('init', 'dt_portfolio_setup_post_type');

include_once 'setup-scripts.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';
