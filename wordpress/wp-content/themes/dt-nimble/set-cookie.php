<?php
if ( isset( $_GET['devicePixelRatio'] ) ) {
	$dpr = $_GET['devicePixelRatio'];
	
	// Validate value before setting cookie
	if (''.intval($dpr) !== $dpr) {
		$dpr = '1';
	}

	setcookie('devicePixelRatio', $dpr, 0, '/');
	exit();
}
?>