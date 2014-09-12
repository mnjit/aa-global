<?php
/* modules/dt-team
*/

// post type 
add_action( 'save_post', 'dt_metabox_info_save' );
add_action( 'save_post', 'dt_metabox_team_category_save' );
add_action( 'save_post', 'dt_metabox_team_options_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'team_meta_box' );
function team_meta_box() {
    
    // post options
    add_meta_box ( 
        'dt_team-post_info',
        _x( 'Teammate', 'backend ourteam post', LANGUAGE_ZONE ),
        'dt_metabox_team_info',
        'dt_team',
        'side'
    );
	
	// template category
	add_meta_box(
		'dt_page_box-team_cats',
		_x( 'Team Category(s)', 'backend team metabox', LANGUAGE_ZONE ),
		'dt_metabox_team_category',
		'page',
		'normal',
		'high'
	);
	
	// template options
	add_meta_box(
		'dt_page_box-team_options',
		_x( 'Team options', 'backend team metabox', LANGUAGE_ZONE ),
		'dt_metabox_team_options',
		'page',
		'side'
	);

}

// layout

// portfolio category
function dt_metabox_team_info( $post ) {
    $box_name = 'dt_team_info';
    
    $defaults = array(
        'position'  => '',
        'age'       => ''    
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );

    echo dt_melement( 'text', array(
       'name'           => $box_name . '_position',
       'value'          => $opts['position'],
       'class'          => 'widefat',
       'wrap'           => '%2$s%1$s',
       'description'    => _x('Position', 'backend ourteam post', LANGUAGE_ZONE)
    ) );

    echo dt_melement( 'text', array(
       'name'           => $box_name . '_age',
       'value'          => $opts['age'],
       'class'          => 'widefat',
       'wrap'           => '%2$s%1$s',
       'description'    => _x('Age', 'backend ourteam post', LANGUAGE_ZONE)
    ) );
}

function dt_metabox_info_save( $post_id ) {
    $box_name = 'dt_team_info';
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
  
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset( $_POST[$box_name. '_nonce'] ) || !wp_verify_nonce( $_POST[$box_name. '_nonce'], plugin_basename( __FILE__ ) ) )
        return;

  
    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;

    $mydata = null;

    if( !empty($_POST[$box_name. '_position']) )
        $mydata['position'] = esc_attr($_POST[$box_name. '_position']);
        
    if( !empty($_POST[$box_name. '_age']) )
        $mydata['age'] = esc_attr($_POST[$box_name. '_age']);

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}

/**
 * Team category selector.
 */
function dt_metabox_team_category( $post ) {
    $box_name = 'dt_meta_team_list';

    $defaults = array(
        'select'    => 'all',
        'team_cats' => array()
    );
    
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
    $terms = get_terms(
        'dt_team_category',
        array(
            'type'                     => 'post',
            'hide_empty'               => 1,
            'hierarchical'             => 0,
            'pad_counts'               => false
        )
    );
    
    $select = array(
        'all'       => array( 'desc' => 'All' ),
        'only'      => array( 'desc' => 'only' ),
        'except'    => array( 'desc' => 'except' )
    );

    $links = array(
        array(
			'href' => get_admin_url() . 'post-new.php?post_type=dt_team',
			'desc' => _x('Add new teammate', 'backend team layout', LANGUAGE_ZONE)
		),
        array(
			'href' => get_admin_url() . 'edit.php?post_type=dt_team',
			'desc' => _x('Edit team', 'backend team layout', LANGUAGE_ZONE)
		),
        array(
			'href' => get_admin_url() . 'edit-tags.php?taxonomy=dt_team_category&post_type=dt_team',
			'desc' => _x('Edit team categories', 'backend team layout', LANGUAGE_ZONE)
		)
    );

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Team posts are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Team posts will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Team categories will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Team posts (from all categories) will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Team category(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which category(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d posts', 'backend', LANGUAGE_ZONE)
        )
    );

    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'cats_name'     => $box_name . '_team_cats[%d]',
        'links'         => $links,
        'terms'         => $terms,
        'albums_cats'   => $opts['team_cats'],
        'cur_type'      => 'category',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_blog'
    ) );
}

function dt_metabox_team_category_save( $post_id ) {
    $box_name = 'dt_meta_team_list';
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
  
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset( $_POST[ $box_name . '_nonce' ] ) || !wp_verify_nonce( $_POST[ $box_name . '_nonce' ], plugin_basename( __FILE__ ) ) ) {
        return;
	}
  
    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) ) {
        return;
    }

    $mydata = null;
    
    if ( !empty( $_POST[ $box_name . '_select' ] ) ) {
        $mydata['select'] = esc_attr( $_POST[ $box_name . '_select' ] );
   	 
   	    if ( isset( $_POST[ $box_name . '_team_cats' ] ) ) {
	        $mydata['team_cats'] = $_POST[ $box_name . '_team_cats' ];
	    }
    }
	
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

function dt_metabox_team_options( $post ) {
    $box_name = 'dt_meta_team_options';
    $defaults = array(
		'content_position'	=> 'top',
        'orderby'           => 'date',
        'order'             => 'DESC',
        'ppp'               => ''
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
    
	$radio_top_bottom = array(
		'top'		=> array( 'desc' => _x('Top', 'backend team layout', LANGUAGE_ZONE) ),
		'bottom'	=> array( 'desc' => _x('Bottom', 'backend team layout', LANGUAGE_ZONE) )
	);
	
	$ppp = dt_melement( 'text', array(
        'name'          => $box_name . '_ppp',
        'value'         => $opts['ppp'],
		'wrap'			=> '%1$s'
    ));
	
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Content position', 'backend team', LANGUAGE_ZONE) . '</strong>';
	dt_core_mb_draw_radio_switcher( $box_name . '_content_position', $opts['content_position'], $radio_top_bottom );
	echo '</p>';
	echo '<p><strong>' . _x('Number of posts to display on one page', 'backend team', LANGUAGE_ZONE) . '</strong></p>';
    echo '<p>' . $ppp . '</p>';
	echo '<div class="dt_hr"></div>';
	echo '<p><strong>' . _x('Ordering settings', 'backend blog', LANGUAGE_ZONE) . '</strong></p>';
    
	dt_core_mb_draw_order_options( array(
        'box_name'          => $box_name,
        'order_current'     => $opts['order'],
        'orderby_current'   => $opts['orderby']
    ));
}

function dt_metabox_team_options_save( $post_id ) {
    $box_name = 'dt_meta_team_options';
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
  
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times

    if ( !isset( $_POST[$box_name. '_nonce'] ) || !wp_verify_nonce( $_POST[$box_name. '_nonce'], plugin_basename( __FILE__ ) ) )
        return;

    // Check permissions
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
    
    $mydata = null;
	
	if ( isset( $_POST[ $box_name . '_content_position' ] ) && in_array( $_POST[ $box_name . '_content_position' ], array( 'top', 'bottom' ) ) ) {
        $mydata['content_position'] = $_POST[ $box_name . '_content_position' ];
    }
	
    if ( isset( $_POST[ $box_name . '_ppp' ] ) ) {
        $mydata['ppp'] = $_POST[ $box_name . '_ppp' ];
    }
    
    if ( isset( $_POST[ $box_name . '_orderby' ] ) ) {
        $mydata['orderby'] = $_POST[ $box_name . '_orderby' ];
    }
    
    if ( isset( $_POST[ $box_name . '_order' ] ) ) {
        $mydata['order'] = $_POST[ $box_name . '_order' ];
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}
