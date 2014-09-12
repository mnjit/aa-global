<?php
/* modules/dt-logos
*/

// post type 
add_action( 'save_post', 'dt_metabox_logos_options_save' );
add_action( 'save_post', 'dt_metabox_logos_retina_save' );

/* Adds a box to the main column on the Post and Page edit screens */
add_action( 'add_meta_boxes', 'logos_meta_box' );
function logos_meta_box () {
    
    // post options
    add_meta_box ( 
        'dt_logos-post_options',
        _x( 'Logos options', 'backend logos post', LANGUAGE_ZONE ),
        'dt_metabox_logos_options',
        'dt_logos',
        'normal',
        'high'
    );
	
	add_meta_box(
		'dt_page_box-logos_retina',
		_x( 'Retina Image', 'backend logos', LANGUAGE_ZONE ),
		'dt_metabox_logos_retina',
		'dt_logos',
		'side',
		'low'
	);

}

// layout

// portfolio category
function dt_metabox_logos_options( $post ) {
    $box_name = 'dt_logos_options';
    
    $defaults = array(
        'url'   => '',
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );

    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
    
?>

    <label><?php echo _x('Target link:', 'backend logos post', LANGUAGE_ZONE); ?><input class="widefat" name="<?php echo esc_attr($box_name . '_url'); ?>" value="<?php echo esc_url($opts['url']); ?>" /></label>

<?php
}

function dt_metabox_logos_options_save( $post_id ) {
    $box_name = 'dt_logos_options';

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

    if( !empty($_POST[$box_name. '_url']) ) {
        $mydata['url'] = esc_url($_POST[$box_name. '_url']);
    }

    update_post_meta( $post_id, '_'.$box_name, $mydata );
}

// retina image upload box
function dt_metabox_logos_retina( $post ) {
    $box_name = 'dt_logos_retina';
    $defaults = array(
        'retina_image'		=> '',
		'retina_image_w'	=> 0,
		'retina_image_h'	=> 0,
		'retina_image_id'	=> null
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( $opts, $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
    // image
	$img_id = '<input type="hidden" value="' . $opts['retina_image_id'] . '" class="dt-uploader-textfield dt-get-id" name="' . $box_name . '_retina_image_id" />';
    
    // upload button
    $upload = dt_melement( 'link', array(
        'description'   => _x( 'Upload Image', 'backend logos', LANGUAGE_ZONE ),
        'class'         => 'dt-uploader-opener button-primary thickbox',
        'href'          => get_admin_url().'media-upload.php?post_id=' . $post->ID . '&type=image&TB_iframe=1&width=640&height=852'
    ));
	
	// delete button
    $delete = dt_melement( 'link', array(
        'description'   => _x( 'Clear', 'backend logos', LANGUAGE_ZONE ),
        'class'         => 'dt-uploader-delete button',
        'href'          => '#'
    ));
		    
    ?>

	<p class="dt_switcher-box"><?php
	if ( $opts['retina_image_id'] ) {
		$img = wp_get_attachment_image_src( $opts['retina_image_id'], 'medium' );
		if ( $img ) {
			$size = wp_constrain_dimensions( $img[1], $img[2], 266, 266 );
			echo '<img class="attachment-266x266 dt-thumb" src="' . $img[0]. '" ' . image_hwstring( $size[0], $size[1] ) . ' />';
		}
	}
	echo $img_id . $upload. $delete;
	?></p>
	
	<?php
}

// save bg options
function dt_metabox_logos_retina_save( $post_id ) {
    $box_name = 'dt_logos_retina';
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
    
    if ( ! empty( $_POST[ $box_name . '_retina_image' ] ) ) {
        $mydata['retina_image'] = esc_url( $_POST[ $box_name. '_retina_image' ] );
    }
	
	if ( ! empty( $_POST[ $box_name . '_retina_image_w' ] ) ) {
        $mydata['retina_image_w'] = intval( $_POST[ $box_name. '_retina_image_w' ] );
    }
	
	if ( ! empty( $_POST[ $box_name . '_retina_image_h' ] ) ) {
        $mydata['retina_image_h'] = intval( $_POST[ $box_name. '_retina_image_h' ] );
    }
	
	if ( ! empty( $_POST[ $box_name . '_retina_image_id' ] ) && wp_attachment_is_image( intval( $_POST[ $box_name . '_retina_image_id' ] ) ) ) {
        $mydata['retina_image_id'] = intval( $_POST[ $box_name. '_retina_image_id' ] );
    }
	
    update_post_meta( $post_id, '_'.$box_name, $mydata );
}