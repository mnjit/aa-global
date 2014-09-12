<?php

// module uri
if( !defined('DT_TESTIMONIALS_URI') ) {
    define( 'DT_TESTIMONIALS_URI', get_template_directory_uri(). '/functions/modules/dt-testimonials' );
}

// Setup custom post type
function dt_testimonials_setup_post_type() {

// titles
$labels = array(
    'name'                  => _x('Testimonials',              'backend testimonials', LANGUAGE_ZONE),
    'singular_name'         => _x('Testimonials',              'backend testimonials', LANGUAGE_ZONE),
    'add_new'               => _x('Add New',                'backend testimonials', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Item',           'backend testimonials', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Item',              'backend testimonials', LANGUAGE_ZONE),
    'new_item'              => _x('New Item',               'backend testimonials', LANGUAGE_ZONE),
    'view_item'             => _x('View Item',              'backend testimonials', LANGUAGE_ZONE),
    'search_items'          => _x('Search Items',           'backend testimonials', LANGUAGE_ZONE),
    'not_found'             => _x('No items found',         'backend testimonials', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No items found in Trash','backend testimonials', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Testimonials', 'backend testimonials', LANGUAGE_ZONE)
);

$img = DT_TESTIMONIALS_URI. '/images/admin_ico_testimonials.png';

// options
$args = array(
    'labels'                => $labels,
    'public'                => false,
	'exclude_from_search'	=> true,
    'publicly_queryable'    => false,
    'show_ui'               => true,
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => false,
    'capability_type'       => 'post',
    'has_archive'           => false, 
    'hierarchical'          => false,
    'menu_position'         => 49,
    'menu_icon'             => $img,
    'supports'              => array( 'title', 'editor', 'thumbnail' )
);
register_post_type( 'dt_testimonials', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',        'backend testimonials', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',          'backend testimonials', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category','backend testimonials', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',        'backend testimonials', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',   'backend testimonials', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',  'backend testimonials', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',     'backend testimonials', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',   'backend testimonials', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',  'backend testimonials', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name', 'backend testimonials', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',        'backend testimonials', LANGUAGE_ZONE )
); 	

register_taxonomy(
    'dt_testimonials_category',
    array( 'dt_testimonials' ),
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
add_action('init', 'dt_testimonials_setup_post_type');

include_once 'filters.php';
include_once 'actions.php';
include_once 'metaboxes.php';

?>