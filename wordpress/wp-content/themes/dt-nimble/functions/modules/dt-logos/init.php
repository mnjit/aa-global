<?php

// module uri
if( !defined('DT_LOGOS_URI') ) {
    define( 'DT_LOGOS_URI', get_template_directory_uri(). '/functions/modules/dt-logos' );
}

// Setup custom post type
function dt_logos_setup_post_type() {

// titles
$labels = array(
    'name'                  => _x('Partners, Clients, etc.',    'backend logos', LANGUAGE_ZONE),
    'singular_name'         => _x('Item',              			'backend logos', LANGUAGE_ZONE),
    'add_new'               => _x('Add New',                	'backend logos', LANGUAGE_ZONE),
    'add_new_item'          => _x('Add New Item',           	'backend logos', LANGUAGE_ZONE),
    'edit_item'             => _x('Edit Item',              	'backend logos', LANGUAGE_ZONE),
    'new_item'              => _x('New Item',               	'backend logos', LANGUAGE_ZONE),
    'view_item'             => _x('View Item',              	'backend logos', LANGUAGE_ZONE),
    'search_items'          => _x('Search Items',           	'backend logos', LANGUAGE_ZONE),
    'not_found'             => _x('No items found',         	'backend logos', LANGUAGE_ZONE),
    'not_found_in_trash'    => _x('No items found in Trash',	'backend logos', LANGUAGE_ZONE), 
    'parent_item_colon'     => '',
    'menu_name'             => _x('Partners, Clients, etc.', 	'backend logos', LANGUAGE_ZONE)
);

$img = DT_LOGOS_URI. '/images/admin_ico_clients.png';

// options
$args = array(
    'labels'                => $labels,
	'exclude_from_search'	=> true,
    'public'                => false,
    'publicly_queryable'    => false,
    'show_ui'               => true,
    'show_in_menu'          => true, 
    'query_var'             => true,
    'rewrite'               => false,
    'capability_type'       => 'post',
    'has_archive'           => false, 
    'hierarchical'          => false,
    'menu_position'         => 45,
    'menu_icon'             => $img,
    'supports'              => array( 'title', 'thumbnail' )
);
register_post_type( 'dt_logos', $args );
/* post type end */

/* setup taxonomy */

// titles
$labels = array(
    'name'              => _x( 'Categories',        'backend logos', LANGUAGE_ZONE ),
    'singular_name'     => _x( 'Category',          'backend logos', LANGUAGE_ZONE ),
    'search_items'      => _x( 'Search in Category','backend logos', LANGUAGE_ZONE ),
    'all_items'         => _x( 'Categories',        'backend logos', LANGUAGE_ZONE ),
    'parent_item'       => _x( 'Parent Category',   'backend logos', LANGUAGE_ZONE ),
    'parent_item_colon' => _x( 'Parent Category:',  'backend logos', LANGUAGE_ZONE ),
    'edit_item'         => _x( 'Edit Category',     'backend logos', LANGUAGE_ZONE ), 
    'update_item'       => _x( 'Update Category',   'backend logos', LANGUAGE_ZONE ),
    'add_new_item'      => _x( 'Add New Category',  'backend logos', LANGUAGE_ZONE ),
    'new_item_name'     => _x( 'New Category Name', 'backend logos', LANGUAGE_ZONE ),
    'menu_name'         => _x( 'Categories',        'backend logos', LANGUAGE_ZONE )
); 	

register_taxonomy(
    'dt_logos_category',
    array( 'dt_logos' ),
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
add_action('init', 'dt_logos_setup_post_type');

require_once 'filters.php';
require_once 'actions.php';
require_once 'metaboxes.php';

?>