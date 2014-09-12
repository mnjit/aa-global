<?php
/**
 * Widgetareas options.
 */

// File Security Check
if ( ! defined( 'ABSPATH' ) ) { exit; }

// new subpage
$options[] = array(
    "page_title"    => _x('Widget Areas', 'theme-options page title', LANGUAGE_ZONE),
    "menu_title"    => _x('Widget Areas', 'theme-options menu title', LANGUAGE_ZONE),
    "menu_slug"     => "of-widgetareas-menu",
    "type"          => "page"
);

$options[] = array( "name" => _x("Widget areas", 'theme-options', LANGUAGE_ZONE), "type" => "heading" );

$options[] = array(	"name" => _x('Widget areas', 'theme-options', LANGUAGE_ZONE), "type" => "block_begin" );

$options[] = array(
    'name'      => '',
    'desc'      => '',
    'id'        => 'of_generatortest2',
    'type'      => 'fields_generator',
    'std'       => array(
        1 => array(
                'sidebar_name'  => 'Default Sidebar',
                'sidebar_desc'  => __('Sidebar primary widget area', LANGUAGE_ZONE)
        ),
        2 => array(
                'sidebar_name'  => 'Default Footer',
                'sidebar_desc'  => __('Footer primary widget area', LANGUAGE_ZONE)
        ),
        3 => array(
                'sidebar_name'  => 'Single post page sidebar',
                'sidebar_desc'  => __('', LANGUAGE_ZONE)
        ),
        4 => array(
                'sidebar_name'  => 'Single catalog item page sidebar',
                'sidebar_desc'  => __('', LANGUAGE_ZONE)
        ),
        5 => array(
                'sidebar_name'  => 'Single post page footer',
                'sidebar_desc'  => __('', LANGUAGE_ZONE)
        ),
        6 => array(
                'sidebar_name'  => 'Single catalog item page footer',
                'sidebar_desc'  => __('', LANGUAGE_ZONE)
        ),
		7 => array(
                'sidebar_name'  => 'Single portfolio project page footer',
                'sidebar_desc'  => __('', LANGUAGE_ZONE)
        )
    ),
    'options'   => array(
        'fields' => array(
            'sidebar_name'   => array(
                'type'          => 'text',
                'class'         => 'of_fields_gen_title',
                'description'   => _x('Sidebar name', 'backend widgetareas', LANGUAGE_ZONE),
                'wrap'          => '<label>%2$s%1$s</label>',
                'desc_wrap'     => '%2$s'
            ),
            'sidebar_desc'   => array(
                'type'          => 'textarea',
                'description'   => _x('Sidebar description (optional)', 'backend widgetareas', LANGUAGE_ZONE),
                'wrap'          => '<label>%2$s%1$s</label>',
                'desc_wrap'     => '%2$s'
            ),
			'sidebar_hide_in_mobile'   => array(
                'type'          => 'checkbox',
                'description'   => _x('Hide in mobile layout', 'backend widgetareas', LANGUAGE_ZONE),
                'wrap'          => '<label>%2$s%1$s<image class="dt-hidden-desc info-mobile" src="'. get_template_directory_uri().  '/images/admin/mob-off.png" /></label>',
                'desc_wrap'     => '%2$s'
            ),
			'sidebar_hide_in_single'   => array(
				'only_for'		=> array(3, 4, 5, 6, 7),
                'type'          => 'checkbox',
                'description'   => _x('Hide on single post page', 'backend widgetareas', LANGUAGE_ZONE),
                'wrap'          => '<label>%2$s%1$s<image class="dt-hidden-desc info-single" src="'. get_template_directory_uri().  '/images/admin/single-off.png" /></label>',
                'desc_wrap'     => '%2$s'
            ),
			'sidebar_hide_everywhere'   => array(
				'only_for'		=> array(1,2),
                'type'          => 'checkbox',
                'description'   => _x('Hide everywhere', 'backend widgetareas', LANGUAGE_ZONE),
                'wrap'          => '<label>%2$s%1$s<image class="dt-hidden-desc info-single" src="'. get_template_directory_uri().  '/images/admin/single-off.png" /></label>',
                'desc_wrap'     => '%2$s'
            )
		)
    )
);

$options[] = array(	"type" => "block_end");
