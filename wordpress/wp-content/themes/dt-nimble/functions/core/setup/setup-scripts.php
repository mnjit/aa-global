<?php
function dt_core_setup_scripts(){

}
	
//add_action('wp_enqueue_scripts', 'dt_core_setup_scripts');

function dt_core_admin_setup_scripts( $hook ) {
	
	if( 'post.php' == $hook || 'post-new.php' == $hook ) {
		// this script show/hide metaboxes for each page layout, enqueue it in footer
		wp_enqueue_script('dt_core_admin-mbox_switcher', get_template_directory_uri().'/js/admin/admin_mbox_switcher.js', array('jquery'), false, true);

		// add some magick for our metaboxes
		wp_enqueue_script('dt_core_admin-mbox_magick', get_template_directory_uri().'/js/admin/admin_mbox_magick.js', array('jquery'), false, true);
	}
	
}
add_action('admin_enqueue_scripts', 'dt_core_admin_setup_scripts');