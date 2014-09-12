<?php
define ('FILE_CACHE_DIRECTORY', '../../uploads/dt_cache');
$cookie_value = 0;
if ( isset( $_COOKIE['devicePixelRatio'] ) ) {
	$cookie_value = intval( $_COOKIE['devicePixelRatio'] );
}
if ( $cookie_value > 1 ) {
	define ('FILE_CACHE_PREFIX', 'timthumb_2x');	
	if ( isset( $_GET['r_src'] ) && ! empty( $_GET['r_src'] ) ) {
		$_GET['src'] = $_GET['r_src'];
	}
	if ( isset( $_GET['w'] ) && $_GET['w'] > 0 ) {
		$_GET['w'] = intval( $_GET['w'] ) * 2;
	}
	if ( isset( $_GET['h'] ) && $_GET['h'] > 0 ) {
		$_GET['h'] = intval( $_GET['h'] ) * 2;
	}
}
define ('MAX_WIDTH', 4000);
define ('MAX_HEIGHT', 4000);
?>