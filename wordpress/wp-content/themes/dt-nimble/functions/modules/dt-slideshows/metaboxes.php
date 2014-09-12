<?php
/* modules/dt-slideshow
*/

// layout
add_action( 'save_post', 'dt_metabox_slider_layout_options_save' );
add_action( 'save_post', 'dt_metabox_slider_layout_slideshows_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'slider_meta_box' );
function slider_meta_box () {
    
    add_meta_box(
        'dt_slider-uploader',
        _x( 'Slides', 'backend slider', LANGUAGE_ZONE ),
        'dt_metabox_slider_uploader',
        'dt_slider',
        'normal',
        'high'
    );
       
    add_meta_box( 
        'dt_page_box-slideshows_options',
        _x( 'Slideshow Options', 'backend slider layout', LANGUAGE_ZONE ),
        'dt_metabox_slider_layout_options',
        'page',
        'normal',
        'core'
    );
        
    add_meta_box( 
        'dt_page_box-slideshows_list',
        _x( 'Display Slideshows', 'backend slider layout', LANGUAGE_ZONE ),
        'dt_metabox_slider_layout_slideshows',
        'page',
        'normal',
        'core'
    );
 
}

// layout
function dt_metabox_slider_layout_options( $post = null ) {
    $box_name = 'dt_slider_layout_options';
    $defaults = array(
        'slider'    		=> 'nivo',
        'display_on'    	=> 'everywhere',
        'auto_period'   	=> 0,
		'fs_height'			=> 0,
		'fs_bot_spacing'	=> 0,
		'fs_hide_content'	=> false,
		'fs_hide_footer'	=> false,
		'fs_overlay'		=> false,
		'fs_header'			=> 'home'
    );
	
	if ( null === $post ) { return $defaults; }
	
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
	
	$sliders = array(
		'nivo'			=> array( 
			'desc' => _x('Nivo Slider', 'backend slider layout', LANGUAGE_ZONE),
			'img'  => array('slider-nivo.png', 99, 55) 
		),
		'photo_stack'	=> array( 
			'desc' => _x('Photo Stack Slider', 'backend slider layout', LANGUAGE_ZONE),
			'img'  => array('slider-photostack.png', 99, 55) 
		),
		'fancy_tyle'	=> array( 
			'desc' => _x('Fancy Tile Slider', 'backend slider layout', LANGUAGE_ZONE),
			'img'  => array('slider-jfancytile.png', 99, 55) 
		),
		'carousel'		=> array( 
			'desc' => _x('Carousel Slider', 'backend slider layout', LANGUAGE_ZONE),
			'img'  => array('slider-carousel.png', 99, 55) 
		),
		'fullscreen_slider'		=> array( 
			'desc' => _x('Fullscreen slider', 'backend slider layout', LANGUAGE_ZONE),
			'img'  => array('fs-slideshow.png', 99, 55) 
		)
	);

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	echo '<p><strong>' . _x('Choose slider', 'backend slider layout', LANGUAGE_ZONE) . '</strong></p>';
	echo '<div class="dt_radio-img">';
	foreach( $sliders as $val=>$data ) {
		$image = '';
		if( isset($data['img']) ) {
			$image = sprintf(
				'<img src="%1$s/%3$s" class="hide-if-no-js" width="%4$s" height="%5$s" style="background-image:url(%1$s/%2$s)" /><br />',
				esc_url(get_template_directory_uri() . '/images/admin'), esc_attr($data['img'][0]), 'blank.gif', $data['img'][1], $data['img'][2] 
			);
		}
		echo dt_melement( 'radio', array(
			'name'			=> $box_name . '_slider',
			'description'	=> $data['desc'],
			'checked'		=> $val == $opts['slider']?true:false,
			'value'			=> $val,
			'wrap'			=> '<label>'.$image.'%1$s %2$s</label>'
		) );
	}
	echo '</div>';
	?>
	
	<script type="text/javascript">
		jQuery( document ).ready( function ( $ ) {
			$( '#dt_page_box-slideshows_options .dt_radio-img input[type="radio"]' ).on( 'click', function () {
				var cls = '.' +  $( this ).val().replace('_', '-');
				$( '#dt_page_box-slideshows_options p.dt-slider-hide' ).not( cls ).hide();
				$( '#dt_page_box-slideshows_options p' + cls ).show();
			} );
			
			$( '#dt_page_box-slideshows_options .dt_radio-img input[type="radio"]:checked' ).click();
		} );
	</script>
	
	<?php
	echo '<p class="dt_switcher-box dt-slider-hide fullscreen-slider" style="display: none;"><strong>' . _x('Fullscreen slideshow options', 'backend slider layout', LANGUAGE_ZONE) . '</strong>';
	
		echo dt_melement( 'checkbox', array(
			'name'			=> $box_name . '_fs_hide_content',
			'description'	=> _x('hide content area', 'backend slider layout', LANGUAGE_ZONE),
			'checked'		=> (bool) $opts['fs_hide_content'],
			'wrap'			=> '<br /><label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'checkbox', array(
			'name'			=> $box_name . '_fs_hide_footer',
			'description'	=> _x('hide footer and bottom line', 'backend slider layout', LANGUAGE_ZONE),
			'checked'		=> (bool) $opts['fs_hide_footer'],
			'wrap'			=> '<br /><label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'checkbox', array(
			'name'			=> $box_name . '_fs_overlay',
			'description'	=> _x('show overlay mask', 'backend slider layout', LANGUAGE_ZONE),
			'checked'		=> (bool) $opts['fs_overlay'],
			'wrap'			=> '<br /><label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'text', array(
			'name'			=> $box_name . '_fs_height',
			'description'	=> _x('fixed slider height', 'backend slider layout', LANGUAGE_ZONE),
			'value'			=> $opts['fs_height'],
			'wrap'			=> '<br /><label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'text', array(
			'name'			=> $box_name . '_fs_bot_spacing',
			'description'	=> _x('slider bottom spacing', 'backend slider layout', LANGUAGE_ZONE),
			'value'			=> $opts['fs_bot_spacing'],
			'wrap'			=> '<br /><label>%1$s %2$s</label>'
		) );
		
		echo '<br /><strong>'. _x('Page header style', 'backend obo slider', LANGUAGE_ZONE). '</strong>';
		
		echo dt_melement( 'radio', array(
			'class'			=> 'dt_switcher',
			'name'			=> $box_name . '_fs_header',
			'description'	=> _x('homepage', 'backend slider layout', LANGUAGE_ZONE),
			'value'			=> 'home',
			'checked'		=> 'home' == $opts['fs_header'],
			'wrap'			=> '<label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'radio', array(
			'class'			=> 'dt_switcher',
			'name'			=> $box_name . '_fs_header',
			'description'	=> _x('inner pages', 'backend slider layout', LANGUAGE_ZONE),
			'value'			=> 'normal',
			'checked'		=> 'normal' == $opts['fs_header'],
			'wrap'			=> '<label>%1$s %2$s</label>'
		) );
		
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Display slideshow', 'backend slider layout', LANGUAGE_ZONE) . '</strong>';
	
		echo dt_melement( 'radio', array(
			'name'			=> $box_name . '_display_on',
			'description'	=> _x('everywhere', 'backend slider layout', LANGUAGE_ZONE),
			'checked'		=> 'everywhere' == $opts['display_on'],
			'value'			=> 'everywhere',
			'wrap'			=> '<label>%1$s %2$s</label>'
		) );
		
		echo dt_melement( 'radio', array(
			'name'			=> $box_name . '_display_on',
			'description'	=> _x('in desktop and tablet browsers only', 'backend slider layout', LANGUAGE_ZONE),
			'checked'		=> 'desktop_tablets' == $opts['display_on'],
			'value'			=> 'desktop_tablets',
			'wrap'			=> '<label>%1$s %2$s</label>'
		) );
	
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Autoslide settings', 'backend slider layout', LANGUAGE_ZONE) . '</strong>';
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_auto_period',
		'description'	=> _x(' milliseconds (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")', 'backend slider layout', LANGUAGE_ZONE),
		'value'			=> $opts['auto_period'],
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
}

// save layout
function dt_metabox_slider_layout_options_save( $post_id ) {
	$box_name = 'dt_slider_layout_options';
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

	$sliders = array( 'nivo', 'photo_stack', 'fancy_tyle', 'carousel', 'fullscreen_slider' );

    if( isset($_POST[$box_name. '_slider']) ) {
        $mydata['slider'] = in_array( $_POST[$box_name. '_slider'], $sliders ) ? $_POST[$box_name. '_slider'] : 'photo_stack';
    }
 
    if( isset($_POST[$box_name. '_display_on']) ) {
        $mydata['display_on'] = strip_tags($_POST[$box_name. '_display_on']);
    }

    if( isset($_POST[$box_name. '_auto_period']) ) {
        $mydata['auto_period'] = intval($_POST[$box_name. '_auto_period']);
    }
	
	if( isset($_POST[$box_name. '_fs_height']) ) {
        $mydata['fs_height'] = intval($_POST[$box_name. '_fs_height']);
    }
    
	if( isset($_POST[$box_name. '_fs_bot_spacing']) ) {
        $mydata['fs_bot_spacing'] = intval($_POST[$box_name. '_fs_bot_spacing']);
    }
	
    $mydata['fs_hide_content'] = isset( $_POST[ $box_name . '_fs_hide_content' ] );
    $mydata['fs_hide_footer'] = isset( $_POST[ $box_name. '_fs_hide_footer' ] );
    $mydata['fs_overlay'] = isset( $_POST[ $box_name. '_fs_overlay' ] );
	
	if ( isset( $_POST[ $box_name. '_fs_header' ] ) ) {
        $mydata['fs_header'] = in_array( $_POST[ $box_name. '_fs_header' ], array( 'home', 'normal' ) ) ? $_POST[ $box_name. '_fs_header' ] : 'home';
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

// slideshows
function dt_metabox_slider_layout_slideshows( $post ) {
	$box_name = 'dt_slider_layout_slideshows';
	global $wpdb;
	
    $defaults = array(
        'select'	    => 'all',
        'slideshows'    => array()
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
    $select = array(
        'all'       => array( 'desc' => 'All' ),
        'only'      => array( 'desc' => 'only' ),
        'except'    => array( 'desc' => 'except' )
    );

    $links = array(
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_slider', 'desc' => _x('Add new slideshow', 'backend slider layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_slider', 'desc' => _x('Edit slideshows', 'backend slider layout', LANGUAGE_ZONE) )
    );

//    dt_core_mb_draw_radio_switcher( $box_name . '_select', $opts['select'], $select );
//    echo '<input type="hidden" name="' . $box_name . '_select" value="' . $opts['select'] . '"/>';

    $text = array(
        'header'        => sprintf('<h2>%s</h2><p><strong>%s</strong>%s</p><p><strong>%s</strong></p>',
            _x('ALL your Slideshows are being displayed on this page!', 'backend', LANGUAGE_ZONE),
            _x('By default all your Slideshows will be displayed on this page. ', 'backend', LANGUAGE_ZONE),
            _x('But you can specify which Slideshows will (or will not) be shown.', 'backend', LANGUAGE_ZONE),
            _x('In tabs above you can select from the following options:', 'backend', LANGUAGE_ZONE)
        ),
        'select_desc'   => array(
            _x(' &mdash; all Slideshows will be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose Slideshow(s) to be shown on this page.', 'backend', LANGUAGE_ZONE),
            _x(' &mdash; choose which Slideshow(s) will be excluded from displaying on this page.', 'backend', LANGUAGE_ZONE)
        ),
        'info_desc'     => array(
            _x('%d slideshows', 'backend', LANGUAGE_ZONE),
            _x('%d slides total', 'backend', LANGUAGE_ZONE)
        )
    );

	$slideshows = new Wp_Query( 'post_type=dt_slider&posts_per_page=-1&post_status=publish' );
    dt_core_mb_draw_modern_selector( array(
        'box_name'      => $box_name,
        'albums_name'   => $box_name . '_slideshows[%d]',
        'links'         => $links,
        'posts'         => $slideshows->posts,
        'albums'        => $opts['slideshows'],
        'cur_type'      => 'albums',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_sliders'
    ) );
/*
	// get slideshows
    dt_core_mb_draw_posts_list( $box_name . '_slideshows[%d]', $opts['slideshows'], $slideshows->posts );
    dt_core_mb_draw_functional_links( $links );
 */
}

// slideshows save
function dt_metabox_slider_layout_slideshows_save( $post_id ) {
	$box_name = 'dt_slider_layout_slideshows';
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

    if( isset($_POST[$box_name. '_select']) ) {
        $mydata['select'] = esc_attr($_POST[$box_name. '_select']);

        if( isset($_POST[$box_name. '_slideshows']) ) {
           $mydata['slideshows'] = $_POST[$box_name. '_slideshows'];
        }
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );

}

// post type
function dt_metabox_slider_uploader( $post ) {
	$tab = 'type';
    $args = array(
        'post_type'			=> 'attachment',
        'post_status'		=> 'inherit',
        'post_parent'		=> $post->ID,
        'posts_per_page'	=> 1
    );
    $attachments = new Wp_Query( $args );

    if ( ! empty( $attachments->posts ) ) {
        $tab = 'dt_slider_media';
    }
    
    $u_href = get_admin_url();
    $u_href .= '/media-upload.php?post_id='. $post->ID;
    $u_href .= '&width=670&height=400&dt_custom=1&tab='.$tab;
?>
    <iframe id="dt-slider-uploader" src="<?php echo esc_url($u_href); ?>" width="100%" height="560">The Error!!!</iframe>
	<?php dt_uploader_style_script( 'dt-slider-uploader', array( 'image_alt' => false ) ); ?>	
<?php
}

function dt_slider_media_form( $errors ) {
    global $redir_tab, $type;

    $redir_tab = 'dt_slider_media';
    media_upload_header();
    
    $post_id = intval( $_REQUEST['post_id'] );
    $form_action_url = admin_url("media-upload.php?type=$type&tab=dt_slider_media&post_id=$post_id");
    $form_action_url = apply_filters('media_upload_form_url', $form_action_url, $type);
    $form_class = 'media-upload-form validate';
    
    if ( get_user_setting('uploader') )
        $form_class .= ' html-uploader';
?>	
    <script type="text/javascript">
    <!--
    jQuery(function($){
        var preloaded = $(".media-item.preloaded");
        if ( preloaded.length > 0 ) {
            preloaded.each(function(){prepareMediaItem({id:this.id.replace(/[^0-9]/g, '')},'');});
            updateMediaForm();
        }
    });
    -->
    </script>
    <div id="sort-buttons" class="hide-if-no-js">
    <span>
    <?php _ex( 'All Tabs:', 'backend slideshow', LANGUAGE_ZONE ); ?>
    <a href="#" id="showall"><?php _ex( 'Show', 'backend slideshow', LANGUAGE_ZONE ); ?></a>
    <a href="#" id="hideall" style="display:none;"><?php _ex( 'Hide', 'backend slideshow', LANGUAGE_ZONE ); ?></a>
    </span>
    <?php _ex( 'Sort Order:', 'backend slideshow', LANGUAGE_ZONE ); ?>
    <a href="#" id="asc"><?php _ex( 'Ascending', 'backend slideshow', LANGUAGE_ZONE ); ?></a> |
    <a href="#" id="desc"><?php _ex( 'Descending', 'backend slideshow', LANGUAGE_ZONE ); ?></a> |
    <a href="#" id="clear"><?php _ex( 'Clear', 'backend slideshow', LANGUAGE_ZONE ); ?></a>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo esc_attr($form_action_url); ?>" class="<?php echo $form_class; ?>" id="gallery-form">
    <?php wp_nonce_field('media-form'); ?>
    <?php //media_upload_form( $errors ); ?>
    <table class="widefat" cellspacing="0">
    <thead><tr>
    <th><?php _ex( 'Media', 'backend slideshow', LANGUAGE_ZONE ); ?></th>
    <th class="order-head"><?php _ex( 'Order', 'backend slideshow', LANGUAGE_ZONE ); ?></th>
    <th class="actions-head"><?php _ex( 'Actions', 'backend slideshow', LANGUAGE_ZONE ); ?></th>
    </tr></thead>
    </table>
    <div id="media-items">
    <?php add_filter('attachment_fields_to_edit', 'media_post_single_attachment_fields_to_edit', 10, 2); ?>
    <?php $_REQUEST['tab'] = 'gallery'; ?>
    <?php echo get_media_items($post_id, $errors); ?>
    <?php $_REQUEST['tab'] = 'dt_slider_media';?>
    </div>

    <p class="ml-submit">
    <?php submit_button( _x( 'Save all changes', 'backend slideshow', LANGUAGE_ZONE ), 'button savebutton', 'save', false, array( 'id' => 'save-all', 'style' => 'display: none;' ) ); ?>
    <input type="hidden" name="post_id" id="post_id" value="<?php echo (int) $post_id; ?>" />
    <input type="hidden" name="type" value="<?php echo esc_attr( $GLOBALS['type'] ); ?>" />
    <input type="hidden" name="tab" value="<?php echo esc_attr( $GLOBALS['tab'] ); ?>" />
    </p>
    </form>

	<div style="display: none;">
    <input type="radio" name="linkto" id="linkto-file" value="file" />
    <input type="radio" checked="checked" name="linkto" id="linkto-post" value="post" />
    <select id="orderby" name="orderby">
    	<option value="menu_order" selected="selected"></option>
        <option value="title"></option>
        <option value="post_date"></option>
        <option value="rand"></option>
    </select>
    <input type="radio" checked="checked" name="order" id="order-asc" value="asc" />
    <input type="radio" name="order" id="order-desc" value="desc" />
    <select id="columns" name="columns">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3" selected="selected">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
        <option value="9">9</option>
   	</select>
	</div>
<?php
}