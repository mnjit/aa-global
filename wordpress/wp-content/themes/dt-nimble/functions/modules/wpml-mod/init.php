<?php
// for compatibility mode we use this ugly and stupid filter
// since WPML has a bug with serialization custom fields http://wpml.org/forums/topic/bug-on-serialized-customf-fields-copy/

/*
if ( ! function_exists( 'is_plugin_active' ) ) {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
}

if ( function_exists( 'is_plugin_active' ) && is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) ) {
	add_filter( 'get_post_metadata', 'dt_get_metadata_filter', 100, 4 );
}
*/
function dt_get_metadata_filter( $check, $object_id, $meta_key, $single ) {
	static $_recur_control_flag = 0; // avoid recursion
	if ( $_recur_control_flag ) return $check; 
	$_recur_control_flag = 1;
	
	$meta = get_post_meta( $object_id, $meta_key, $single );
	if ( $meta ) {
		if ( $single )
			$check  = array( maybe_unserialize( $meta ) );
		else
			$check = array_map('maybe_unserialize', $meta);
	}
	$_recur_control_flag = 0;
	return $check;
}
?>