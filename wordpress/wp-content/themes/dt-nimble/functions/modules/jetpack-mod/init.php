<?php
/* Remove Share Buttons buttons from posts list */
function dt_remove_jetpack_sharebuttons () {
	remove_filter( 'the_content', 'sharing_display', 19 );
	remove_filter( 'the_excerpt', 'sharing_display', 19 );
	remove_action( 'wp_head', 'sharing_add_header', 1 );
}
add_action( 'dt_layout_before_loop', 'dt_remove_jetpack_sharebuttons' );
