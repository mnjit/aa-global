<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */
function optionsframework_option_name() {

    // This gets the theme name from the stylesheet (lowercase and without spaces)
    $wp_ver = explode('.', get_bloginfo('version'));
    $wp_ver = array_map( 'intval', $wp_ver );

	$themename = wp_get_theme();
	$themename = $themename->name;

    $themename = preg_replace("/\W/", "", strtolower($themename) );
    
    $optionsframework_settings = get_option('optionsframework');
    $optionsframework_settings['id'] = $themename;
    update_option('optionsframework', $optionsframework_settings);

}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	$fl_arr = array(
        'repeat'    => _x( 'repeat', 'backend options', LANGUAGE_ZONE ),
		'repeat-x'  => _x( 'repeat-x', 'backend options', LANGUAGE_ZONE ),
		'repeat-y'  => _x( 'repeat-y', 'backend options', LANGUAGE_ZONE ),
		'no-repeat' => _x( 'no-repeat', 'backend options', LANGUAGE_ZONE )
	);
	$repeat_x_arr = array(
        'no-repeat' => _x( 'no-repeat', 'backend options', LANGUAGE_ZONE ),
		'repeat-x'  => _x( 'repeat-x', 'backend options', LANGUAGE_ZONE )
	);
	$v_arr = array(
        'center'    => _x( 'center', 'backend options', LANGUAGE_ZONE ),
		'top'       => _x( 'top', 'backend options', LANGUAGE_ZONE ),
		'bottom'    => _x( 'bottom', 'backend options', LANGUAGE_ZONE )
	);
	$h_arr = array(
        'center'    => _x( 'center', 'backend options', LANGUAGE_ZONE ),
		'left'      => _x( 'left', 'backend options', LANGUAGE_ZONE ),
		'right'     => _x( 'right', 'backend options', LANGUAGE_ZONE )
	);
    $colour_arr = array(
        'blue'      => _x( 'blue', 'backend options', LANGUAGE_ZONE ),
        'green'     => _x( 'green', 'backend options', LANGUAGE_ZONE ),
        'orange'    => _x( 'orange', 'backend options', LANGUAGE_ZONE ),
        'purple'    => _x( 'purple', 'backend options', LANGUAGE_ZONE ),
        'yellow'    => _x( 'yellow', 'backend options', LANGUAGE_ZONE ),
        'pink'      => _x( 'pink', 'backend options', LANGUAGE_ZONE ),
        'white'     => _x( 'white', 'backend options', LANGUAGE_ZONE )
    );
    $footer_arr = array(
        'every'     => _x( 'on every page', 'backend options', LANGUAGE_ZONE ),
        'home'      => _x( 'front page only', 'backend options', LANGUAGE_ZONE ),
        'ex_home'   => _x( 'everywhere except front page', 'backend options', LANGUAGE_ZONE ),
        'nowhere'   => _x( 'nowhere', 'backend options', LANGUAGE_ZONE )
    );
    $homepage_arr = array(
        'every'     => _x( 'everywhere', 'backend options', LANGUAGE_ZONE ),
        'home'      => _x( 'only on homepage templates', 'backend options', LANGUAGE_ZONE ),
        'ex_home'   => _x( 'everywhere except homepage templates', 'backend options', LANGUAGE_ZONE ),
        'nowhere'   => _x( 'nowhere', 'backend options', LANGUAGE_ZONE )
    );
	$image_hovers = array(
		'slice'     => _x( 'slice', 'backend options', LANGUAGE_ZONE ),
        'fade'      => _x( 'fade', 'backend options', LANGUAGE_ZONE )
	);
		
	$google_fonts = dt_get_google_fonts_list();
	
	$menu_and_buttons = array(
		'none'		=> '/images/menu-and-buttons/default.jpg',
		'red'		=> '/images/menu-and-buttons/red.jpg',
		'blue'		=> '/images/menu-and-buttons/blue.jpg',
		'green'		=> '/images/menu-and-buttons/green.jpg',
		'beige'		=> '/images/menu-and-buttons/beige.jpg',
		'purple'	=> '/images/menu-and-buttons/purple.jpg',
		'gold'		=> '/images/menu-and-buttons/gold.jpg',
		'orange'	=> '/images/menu-and-buttons/orange.jpg',
		'pink'		=> '/images/menu-and-buttons/pink.jpg'
	);
	
	$web_fonts = dt_get_websafe_fonts();
	
	static $options = array();
    
	if ( ! $options ) {

		$dirname = dirname(__FILE__);
		$options_files = array(
			'options-presets',
			'options-branding',
			'options-misc',
			'options-menu',
			'options-buttons',
			'options-backgrounds',
			'options-fonts',
			'options-widgetareas',
			'options-socials'
		);

		foreach ( $options_files as $filename ) {
			include_once( $dirname . "/{$filename}.php" );
		}

		$options = apply_filters( 'optionsframework_options', $options );
	}

	return $options;
}
