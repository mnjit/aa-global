<?php
function dt_core_admin_setup_styles( $hook ) {
	
	if( 'post.php' == $hook || 'post-new.php' == $hook ) {
		// styling metaboxes
		wp_enqueue_style('dt_core_admin-mbox_magick_style', get_template_directory_uri().'/css/admin/admin_mbox_magick.css', array(), false);
	}
	
	if( 'edit.php' == $hook ) {
		// styling columns
		wp_enqueue_style('dt_core_admin-edit_style', get_template_directory_uri().'/css/admin/admin_edit_style.css', array(), false);
	}
	
}
add_action('admin_enqueue_scripts', 'dt_core_admin_setup_styles');