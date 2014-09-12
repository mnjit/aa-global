<!DOCTYPE html>
<!--[if IE 7]>
<html id="ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html id="ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]--><head>
<?php dt_get_google_fonts( of_get_option( 'fonts-list' ), dt_get_web_font_effect() ); ?>
<meta http-equiv="Content-Type" content="text/html" />
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<?php
/* Tourn off responsivness if option "misc-off_responsivness" is set
 * Another part of this action located in functions.php (dt_tourn_off_responsivness function) and footer.php (set javascript global)
 * dt_is_responsive() located on /modules/helpers/template-helpers.php
 */
if ( dt_is_responsive() ) : ?>

<meta name="viewport" content="initial-scale=1, maximum-scale=1">

<?php endif; ?>

<?php if ( dt_is_retina_on() ): ?>

<script>(function(w){var dpr=((w.devicePixelRatio===undefined)?1:w.devicePixelRatio);if(!!w.navigator.standalone){var r=new XMLHttpRequest();r.open('GET','<?php echo get_template_directory_uri();?>/set-cookie.php?devicePixelRatio='+dpr,false);r.send()}else{document.cookie='devicePixelRatio='+dpr+'; path=/'}})(window)</script>

<?php endif; ?>

<link href='http://fonts.googleapis.com/css?family=Advent+Pro:600' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Cabin:700' rel='stylesheet' type='text/css'>
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	if (  !defined( 'WPSEO_VERSION' ) ) {
		global $page, $paged;

		// Add the blog name.
		bloginfo( 'name' );

		wp_title( '|' );

		// Add the blog description for the home/front page.
		$site_description = get_bloginfo( 'description', 'display' );
		if ( $site_description && ( is_home() || is_front_page() ) ) {
			echo " | $site_description";
		}

		// Add a page number if necessary:
		if ( $paged >= 2 || $page >= 2 ) {
			echo ' | ' . sprintf( __( 'Page %s', LANGUAGE_ZONE ), max( $paged, $page ) );
		}
	} else {
		wp_title( '|', true, 'right' );
	}
?></title>
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<?php echo dt_core_get_favicon( of_get_option( 'branding-favicon' ) ); ?>

<?php
// Google analitics code
if ( ! is_preview() ) {
	echo of_get_option( 'misc-analitics_code', '' );
}

// add custom classes for fullscreen slider homepage
$body_class = array();
if ( dt_storage( 'is_homepage' ) && ! dt_storage( 'have_obo_slider' ) ) {
	$page_opts = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true );
	if ( isset( $page_opts['slider'] ) && 'fullscreen_slider' == $page_opts['slider'] ) {
		$body_class[] = 'fs-enabled';

		if ( ! empty( $page_opts['fs_hide_content'] ) ) { $body_class[] = 'fs-no-content'; }

		if ( ! empty( $page_opts['fs_hide_footer'] ) ) { $body_class[] = 'fs-no-footer'; }
	}
}

wp_head();
?>
</head>
<body <?php body_class( $body_class ); ?>>
<?php
$class = array();
if ( dt_storage( 'is_homepage' ) && ! dt_storage( 'have_obo_slider' ) && ! dt_storage( 'is_blog' ) ) {
    $slider_options = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true );
    if( $slider_options && isset($slider_options['slider']) ) {
        switch( $slider_options['slider'] ) {
            case 'carousel': $class[] = 'carous'; break;
            case 'photo_stack': $class[] = 'vert';
        }
    }
}

$class = implode( ' ', $class );
if ( ! empty( $class ) ) {
    $class = ' class="' . $class . '"';
}
?>

	<div id="wrap">
	<div <?php if( of_get_option('boxed_layout-enable') ): ?> class="boxed" <?php endif; ?> id="page">
	
    <div id="<?php dt_main_block_class_changer(); ?>"<?php echo $class; ?>>
	<div id="main-menu" class="but-wrap"><a class="button big" href="javascript:void(0)"><span><i class="line-one"></i><i class="line-two"></i><i class="line-three"></i><i class="line-four"></i> <?php _e('Menu ', LANGUAGE_ZONE); ?></span></a></div>