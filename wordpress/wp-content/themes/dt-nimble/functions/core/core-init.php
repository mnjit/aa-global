<?php

// include config file
require_once 'core-config.php';
require_once 'core-filters.php';
//require_once 'core-actions.php';

// include core functions
require_once 'core-functions.php';

// include metabox functions
require_once 'includes/metabox-functions.php';
require_once 'includes/core-metaboxes.php';

// include menu functions
require_once 'menu/core-menu.php';
require_once 'includes/lib.php';
require_once 'includes/stylesheet-functions.php';

// set content width
global $content_width;
if ( ! isset( $content_width ) ) {
    $content_width = 630;
}

// add modules
include_files_in_dir( "/../modules/", false, 'init.php' );

/* Set up theme defaults and registers support for various WordPress features. */
add_action( 'after_setup_theme', 'dt_init' );
if ( ! function_exists( 'dt_init' ) ) {
	function dt_init() {
		// for translate purpose
		if( function_exists( 'load_theme_textdomain' ) ){
			load_theme_textdomain( LANGUAGE_ZONE, get_template_directory(). '/languages' );
		}

		/* menu slot */
		register_nav_menu( 'primary-menu', __( 'Primary Menu', LANGUAGE_ZONE ) );

		if ( function_exists( 'add_theme_support' ) ) { 
			/* add theme support images */
			add_theme_support( 'post-thumbnails' );

			/* add automatic feeds support */
			add_theme_support( 'automatic-feed-links' );
		}

		if ( function_exists( 'add_editor_style' ) ) {
            add_editor_style();
        }

		// include some plugins
		$plugins = array(
			'captcha/dt_captcha.php',
			'options-framework/functions.php',
			'wp-pagenavi.php',
			'shortcodes/setup.php'
		);

		foreach ( $plugins as $plugin ) {
			$file_path = dirname( __FILE__ ) . '/../../plugins/' . $plugin;
			if ( file_exists( $file_path ) ) {
				require_once $file_path;
			}
		}

        // add dynamic widgetized areas
        require_once dirname( __FILE__ ) . '/setup/setup-widgets.php';
		require_once dirname( __FILE__ ) . '/setup/setup-scripts.php';
        require_once dirname( __FILE__ ) . '/setup/setup-styles.php';
	}
}
