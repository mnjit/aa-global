<?php

// module uri
if( !defined('DT_PHOTOALBUMS_URI') ) {
    define( 'DT_PHOTOALBUMS_URI', get_template_directory_uri(). '/functions/modules/dt-photoalbums' );
}

// Setup custom post type
function dt_gallery_post_type() {

// title
$labels = array(
    'name'                  => _x('Photo Albums', 'backend albums', LANGUAGE_ZONE),
    'singular_name'         => _x('Photo Album', 'backend albums', LANGUAGE_ZONE),
    'add_new'               => _x('Add New', 'backend albums', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Album', 'backend albums', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Album', 'backend albums', LANGUAGE_ZONE),
    'new_item'              => _x('New Album', 'backend albums', LANGUAGE_ZONE),
    'view_item'             => _x('View Album', 'backend albums', LANGUAGE_ZONE),
    'search_items'          => _x('Search for Albums', 'backend albums', LANGUAGE_ZONE),
    'not_found'             => _x('No Albums Found', 'backend albums', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No Albums Found in Trash', 'backend albums', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Photo Albums', 'backend albums', LANGUAGE_ZONE)
);

// settings
$args = array(
    'labels'                => $labels,
    'public'                => true,
    'publicly_queryable'    => false,
    'show_ui'               => true, 
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => false,
    'capability_type'       => 'post',
    'has_archive'           => true, 
    'hierarchical'          => false,
    'menu_position'         => 46,
    'menu_icon'		        => DT_PHOTOALBUMS_URI . '/images/admin_ico_gallery.png',
    'supports'              => array( 'title', 'thumbnail', 'excerpt' )
);
 
register_post_type( 'dt_gallery', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',            'backend albums', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',              'backend albums', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category',    'backend albums', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',            'backend albums', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',       'backend albums', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',      'backend albums', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',         'backend albums', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',       'backend albums', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',      'backend albums', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name',     'backend albums', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',            'backend albums', LANGUAGE_ZONE )
);

// settings
register_taxonomy(
    'dt_gallery_category',
    array( 'dt_gallery' ),
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
add_action('init', 'dt_gallery_post_type');

include_once 'helpers.php';
include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>