<?php

/*
 * Theme customizer
 */
add_action( 'customize_register', 'options_theme_customizer_register' );
function options_theme_customizer_register( $wp_customize ) {
    /**
     * This is optional, but if you want to reuse some of the defaults
     * or values you already have built in the options panel, you
     * can load them into $options for easy reference
     */
    $options = optionsframework_options();
    $optionsframework_settings = get_option( 'optionsframework'  );
    $option_name = $optionsframework_settings['id'];
    
    /* Basic */
    $wp_customize->add_section( 'options_theme_customizer_theme_fonts', array(
        'title' => __( 'Theme Fonts', LANGUAGE_ZONE ),
        'priority' => 100
    ) );
	
	/* Font Family */
	$wp_customize->add_setting( $option_name . '[fonts-font_family]', array(
        'default' => $options['fonts-font_family']['std'],
        'type' => 'option'
    ) );
    $wp_customize->add_control( $option_name . '_fonts-font_family', array(
        'label' => $options['fonts-font_family']['desc'],
        'section' => 'options_theme_customizer_theme_fonts',
        'settings' => $option_name . '[fonts-font_family]',
        'type' => 'select',
        'choices' => $options['fonts-font_family']['options']
    ) );
	
	/* Web Fonts */
    $wp_customize->add_setting( $option_name . '[fonts-list]', array(
        'default' => $options['fonts-list']['std'],
        'type' => 'option'
    ) );
    $wp_customize->add_control( $option_name . '_fonts-list', array(
        'label' => $options['fonts-list']['desc'],
        'section' => 'options_theme_customizer_theme_fonts',
        'settings' => $option_name . '[fonts-list]',
        'type' => 'select',
        'choices' => $options['fonts-list']['options']
    ) );
}
