<?php
/* modules/dt-slideshow
*/

// layout
add_action( 'save_post', 'dt_metabox_obo_slider_options_save' );
add_action( 'save_post', 'dt_metabox_obo_slider_layout_slideshows_save' );
add_action( 'save_post', 'dt_metabox_obo_slider_layout_options_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'obo_slider_meta_box' );
function obo_slider_meta_box () {
    
    add_meta_box(
        'dt_slider-uploader',
        _x( 'Images', 'backend obo slider', LANGUAGE_ZONE ),
        'dt_metabox_obo_slider_uploader',
        'dt_obo_slider',
        'normal',
        'high'
    );
	    
    add_meta_box( 
        'dt_page_box-obo_slide_options',
        _x( 'Text area options', 'backend obo slider', LANGUAGE_ZONE ),
        'dt_metabox_obo_slider_options',
        'dt_obo_slider',
        'normal',
        'high'
    );
	
    add_meta_box( 
        'dt_page_box-obo_slides_list',
        _x( 'Display slideshows', 'backend obo slider layout', LANGUAGE_ZONE ),
        'dt_metabox_obo_slider_layout_slideshows',
        'page',
        'normal',
        'core'
    );
	
	add_meta_box( 
        'dt_page_box-obo_slides_options',
        _x( 'Slideshow options', 'backend obo slider layout', LANGUAGE_ZONE ),
        'dt_metabox_obo_slider_layout_options',
        'page',
        'normal',
        'high'
    );

}

// layout

// slideshows
function dt_metabox_obo_slider_layout_slideshows( $post ) {
	$box_name = 'dt_obo_slider_layout_slideshows';
	global $wpdb;
	
    $defaults = array(
        'select'	    => 'all',
        'slider_cats'   => array()
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	$terms = get_terms(
        'dt_obo_slider_category',
        array(
            'hide_empty'               => true,
            'hierarchical'             => false,
            'pad_counts'               => false
        )
    );
	
    $select = array(
        'all'       => array( 'desc' => 'All' ),
        'only'      => array( 'desc' => 'only' ),
        'except'    => array( 'desc' => 'except' )
    );

    $links = array(
        array( 'href' => get_admin_url(). 'post-new.php?post_type=dt_obo_slider', 'desc' => _x('Add new slideshow', 'backend slider layout', LANGUAGE_ZONE) ),
        array( 'href' => get_admin_url(). 'edit.php?post_type=dt_obo_slider', 'desc' => _x('Edit slideshows', 'backend slider layout', LANGUAGE_ZONE) )
    );

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
        'cats_name'     => $box_name . '_obo_slider_cats[%d]',
        'links'         => $links,
        'terms'         => $terms,
        'albums_cats'   => $opts['slider_cats'],
        'cur_type'      => 'category',
        'cur_select'    => $opts['select'],
        'text'          => $text,
		'maintab_class' => 'dt_all_sliders'
    ) );

}

// slideshows save
function dt_metabox_obo_slider_layout_slideshows_save( $post_id ) {
	$box_name = 'dt_obo_slider_layout_slideshows';
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

        if( isset($_POST[$box_name. '_obo_slider_cats']) ) {
           $mydata['slider_cats'] = $_POST[$box_name. '_obo_slider_cats'];
        }
    }
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );

}

// obo slider options
function dt_metabox_obo_slider_layout_options( $post ) {
	$box_name = 'dt_obo_slider_layout_options';
	global $wpdb;
	
    $defaults = array(
        'autoslide'		=> 0,
		'header'		=> 'home',
		'display_on'    => 'everywhere',
		'position_top'	=> 0,
		'height'		=> 50
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
	
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	echo '<p class="dt_switcher-box">';
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_autoslide',
		'description'	=> _x('Autoslide - milliseconds (1 second = 1000 milliseconds; to disable autoslide leave this field blank or set it to "0")', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['autoslide'],
		'wrap'			=> '<label>%1$s <strong>%2$s</strong></label><br />'
	) );
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_position_top',
		'description'	=> _x('Top offset (px)', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['position_top'],
		'wrap'			=> '<label>%1$s <strong>%2$s</strong></label><br />'
	) );
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_height',
		'description'	=> _x('Height (px)', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['height'],
		'wrap'			=> '<label>%1$s <strong>%2$s</strong></label>'
	) );
	
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Display slideshow', 'backend obo slider', LANGUAGE_ZONE) . '</strong>';
	
	echo dt_melement( 'radio', array(
		'name'			=> $box_name . '_display_on',
		'description'	=> _x('everywhere', 'backend obo slider', LANGUAGE_ZONE),
		'checked'		=> 'everywhere' == $opts['display_on'],
		'value'			=> 'everywhere',
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	
	echo dt_melement( 'radio', array(
		'name'			=> $box_name . '_display_on',
		'description'	=> _x('in desktop and tablet browsers only', 'backend obo slider', LANGUAGE_ZONE),
		'checked'		=> 'desktop_tablets' == $opts['display_on'],
		'value'			=> 'desktop_tablets',
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>'. _x('Page header style', 'backend obo slider', LANGUAGE_ZONE). '</strong>';
	
	echo dt_melement( 'radio', array(
		'class'			=> 'dt_switcher',
		'name'			=> $box_name . '_header',
		'description'	=> _x('homepage', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> 'home',
		'checked'		=> 'home' == $opts['header'],
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	
	echo dt_melement( 'radio', array(
		'class'			=> 'dt_switcher',
		'name'			=> $box_name . '_header',
		'description'	=> _x('inner pages', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> 'normal',
		'checked'		=> 'normal' == $opts['header'],
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	
	echo '</p>';
}

// slideshows save
function dt_metabox_obo_slider_layout_options_save( $post_id ) {
	$box_name = 'dt_obo_slider_layout_options';
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

    if( isset($_POST[$box_name. '_autoslide']) ) {
        $mydata['autoslide'] = intval($_POST[$box_name. '_autoslide']);
	}
	
	if( isset($_POST[$box_name. '_animation']) ) {
	   $mydata['animation'] = strip_tags(trim($_POST[$box_name. '_animation']));
	}
	
	if( isset($_POST[$box_name. '_header']) ) {
	   $mydata['header'] = strip_tags($_POST[$box_name. '_header']);
	}
	
	if( isset($_POST[$box_name. '_display_on']) ) {
        $mydata['display_on'] = strip_tags($_POST[$box_name. '_display_on']);
    }
	
	if( isset($_POST[$box_name. '_position_top']) ) {
		$mydata['position_top'] = intval($_POST[$box_name. '_position_top']);
	   
		if( $mydata['position_top'] < 0 ) $mydata['position_top'] = 0;
	}
	
	if( isset($_POST[$box_name. '_height']) ) {
		$mydata['height'] = strip_tags(trim($_POST[$box_name. '_height']));
	
		if( $mydata['height'] < 50 ) $mydata['height'] = 50;
	}
    
    update_post_meta( $post_id, '_' . $box_name, $mydata );

}

// post type
function dt_metabox_obo_slider_options( $post ) {
    $box_name = 'dt_obo_slider_options';
    $defaults = array(
        'text_top'    	=> 0,
		'text_left'		=> 0,
		'text_width'	=> 100,
		'animation'		=> 'random',
        'text_depth'   	=> 'before'
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
    
	// Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
	echo '<p><strong>'. _x('Size and positioning:', 'backend obo slider', LANGUAGE_ZONE). '</strong><br />';
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_text_left',
		'description'	=> _x('Left (px)', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['text_left'],
		'wrap'			=> '<label><strong>%2$s</strong> %1$s</label>'
	) );
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_text_top',
		'description'	=> _x('Top (px)', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['text_top'],
		'wrap'			=> '<label><strong>%2$s</strong> %1$s</label>'
	) );
	
	echo dt_melement( 'text', array(
		'name'			=> $box_name . '_text_width',
		'description'	=> _x('Width (px)', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> $opts['text_width'],
		'wrap'			=> '<label><strong>%2$s</strong> %1$s</label>'
	) );
	
	echo '</p>';
	
	echo '<div class="dt_hr"></div>';
	
	echo dt_melement( 'select', array(
		'name'			=> $box_name . '_animation',
		'description'	=> _x('Animation', 'backend obo slider', LANGUAGE_ZONE),
		'wrap'			=> '<p><label>%2$s&nbsp;%1$s</label></p>',
		'options'		=> array(
			'fadeIn'			=> 'fadeIn',
			'fadeInUp'			=> 'fadeInUp',
			'fadeInDown'		=> 'fadeInDown',
			'fadeInLeft'		=> 'fadeInLeft',
			'fadeInRight'		=> 'fadeInRight',
			'fadeInRight'		=> 'fadeInRight',
			'bounceIn'			=> 'bounceIn',
			'bounceInDown'		=> 'bounceInDown',
			'bounceInUp'		=> 'bounceInUp',
			'bounceInLeft'		=> 'bounceInLeft',
			'bounceInRight'		=> 'bounceInRight',
			'rotateInDownLeft'	=> 'rotateInDownLeft',
			'rotateInDownRight'	=> 'rotateInDownRight',
			'rotateInUpLeft'	=> 'rotateInUpLeft',
			'rotateInUpRight'	=> 'rotateInUpRight',
			'random'			=> 'random'
		),
		'selected'		=> $opts['animation']
	) );	

	echo '<div class="dt_hr"></div>';
	
	echo '<p class="dt_switcher-box"><strong>' . _x('Display:', 'backend obo slider', LANGUAGE_ZONE) . '</strong>';
	echo dt_melement( 'radio', array(
		'name'			=> $box_name . '_text_depth',
		'description'	=> _x('Before images', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> 'before',
		'checked'		=> 'before' == $opts['text_depth'],
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	echo dt_melement( 'radio', array(
		'name'			=> $box_name . '_text_depth',
		'description'	=> _x('After images', 'backend obo slider', LANGUAGE_ZONE),
		'value'			=> 'after',
		'checked'		=> 'after' == $opts['text_depth'],
		'wrap'			=> '<label>%1$s %2$s</label>'
	) );
	echo '</p>';
}

function dt_metabox_obo_slider_options_save( $post_id ) {
	$box_name = 'dt_obo_slider_options';
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
	
    if( isset($_POST[$box_name. '_text_left']) ) {
        $mydata['text_left'] = intval($_POST[$box_name. '_text_left']);
    }
	
	if( isset($_POST[$box_name. '_text_top']) ) {
        $mydata['text_top'] = intval($_POST[$box_name. '_text_top']);
    }
	
	if( isset($_POST[$box_name. '_text_width']) ) {
        $mydata['text_width'] = intval($_POST[$box_name. '_text_width']);
    }
	
	if( isset($_POST[$box_name. '_animation']) ) {
        $mydata['animation'] = strip_tags(trim($_POST[$box_name. '_animation']));
    }
	
	if( isset($_POST[$box_name. '_text_depth']) ) {
        $mydata['text_depth'] = strip_tags(trim($_POST[$box_name. '_text_depth']));
    }
	    
    update_post_meta( $post_id, '_' . $box_name, $mydata );
}

function dt_metabox_obo_slider_uploader( $post ) {
	$tab = 'type';
    $args = array(
        'post_type'			=>'attachment',
        'post_status'		=>'inherit',
        'post_parent'		=>$post->ID,
        'posts_per_page'	=>1
    );
    $attachments = new Wp_Query( $args );

    if( !empty($attachments->posts) ) {
        $tab = 'dt_obo_slider_media';
    }
    
    $u_href = get_admin_url();
    $u_href .= '/media-upload.php?post_id='. $post->ID;
    $u_href .= '&width=670&height=400&dt_custom=1&tab='.$tab;
?>
    <iframe id="dt-oboslider-uploader" src="<?php echo esc_url($u_href); ?>" width="100%" height="560">The Error!!!</iframe>
	<?php dt_uploader_style_script('dt-oboslider-uploader', array('.post_excerpt')); ?>	
<?php
}

function dt_obo_slider_media_form( $errors ) {
    global $redir_tab, $type;

    $redir_tab = 'dt_obo_slider_media';
    media_upload_header();
	
    $post_id = intval($_REQUEST['post_id']);
    $form_action_url = admin_url("media-upload.php?type=$type&tab=dt_obo_slider_media&post_id=$post_id");
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
    <?php _ex( 'All Tabs:', 'backend oboslider', LANGUAGE_ZONE ); ?>
    <a href="#" id="showall"><?php _ex( 'Show', 'backend oboslider', LANGUAGE_ZONE ); ?></a>
    <a href="#" id="hideall" style="display:none;"><?php _ex( 'Hide', 'backend oboslider', LANGUAGE_ZONE ); ?></a>
    </span>
    <?php _ex( 'Sort Order:', 'backend oboslider', LANGUAGE_ZONE ); ?>
    <a href="#" id="asc"><?php _ex( 'Ascending', 'backend oboslider', LANGUAGE_ZONE ); ?></a> |
    <a href="#" id="desc"><?php _ex( 'Descending', 'backend oboslider', LANGUAGE_ZONE ); ?></a> |
    <a href="#" id="clear"><?php _ex( 'Clear', 'backend oboslider', LANGUAGE_ZONE ); ?></a>
    </div>
    <form enctype="multipart/form-data" method="post" action="<?php echo esc_attr( $form_action_url ); ?>" class="<?php echo $form_class; ?>" id="gallery-form">
    <?php wp_nonce_field('media-form'); ?>
    <?php //media_upload_form( $errors ); ?>
    <table class="widefat" cellspacing="0">
    <thead><tr>
    <th><?php _ex( 'Media', 'backend oboslider', LANGUAGE_ZONE ); ?></th>
    <th class="order-head"><?php _ex( 'Order', 'backend oboslider', LANGUAGE_ZONE ); ?></th>
    <th class="actions-head"><?php _ex( 'Actions', 'backend oboslider', LANGUAGE_ZONE ); ?></th>
    </tr></thead>
    </table>
    <div id="media-items">
    <?php
	add_filter('attachment_fields_to_edit', 'media_post_single_attachment_fields_to_edit', 10, 2);
	
	// remove insert into post button
	add_filter( 'get_media_item_args', 'dt_core_media_item_remove_insert_button' );
	
	$_REQUEST['tab'] = 'gallery';
	echo get_media_items($post_id, $errors);
	$_REQUEST['tab'] = 'dt_obo_slider_media';
	 
	remove_filter( 'get_media_item_args', 'dt_core_media_item_remove_insert_button' );
	?>
    </div>

    <p class="ml-submit">
    <?php submit_button( _x( 'Save all changes', 'backend oboslider', LANGUAGE_ZONE ), 'button savebutton', 'save', false, array( 'id' => 'save-all', 'style' => 'display: none;' ) ); ?>
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