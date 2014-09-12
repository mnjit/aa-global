<?php

if ( !function_exists( 'optionsframework_init' ) ) {

/*-----------------------------------------------------------------------------------*/
/* Options Framework Theme
/*-----------------------------------------------------------------------------------*/

/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */

if ( get_stylesheet_directory() != get_template_directory() ) {
	define('OPTIONS_FRAMEWORK_URL', get_template_directory() . '/plugins/options-framework/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/plugins/options-framework/admin/');
} else {
	define('OPTIONS_FRAMEWORK_URL', get_stylesheet_directory() . '/plugins/options-framework/admin/');
	define('OPTIONS_FRAMEWORK_DIRECTORY', get_stylesheet_directory_uri() . '/plugins/options-framework/admin/');
}

require_once (OPTIONS_FRAMEWORK_URL . 'options-functions.php');
require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');

}
