<?php
/* modules/dt-benefits
*/

add_action( 'save_post', 'dt_metabox_benefits_options_save' );

// metaboxes
add_action( 'add_meta_boxes', 'dt_benefits_boxes' );
function dt_benefits_boxes() {

	// background options
	add_meta_box(
		'dt_page_box-benefits_options',
		_x( 'Retina Image', 'backend benefits', LANGUAGE_ZONE ),
		'dt_metabox_benefits_options',
		'dt_benefits',
		'side',
		'low'
	);

}

function dt_metabox_benefits_options( $post ) {
    $box_name = 'dt_benefits_options';
    $defaults = array(
        'retina_image'		=> '',
		'retina_image_w'	=> 0,
		'retina_image_h'	=> 0,
		'retina_image_id'	=> null
    );
    $opts = get_post_meta( $post->ID, '_' . $box_name, true );
    $opts = wp_parse_args( maybe_unserialize( $opts ), $defaults );
    
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), $box_name. '_nonce' );
	
    // image
	$img_id = '<input type="hidden" value="' . $opts['retina_image_id'] . '" class="dt-uploader-textfield dt-get-id" name="' . $box_name . '_retina_image_id" />';
    
    // upload button
    $upload = dt_melement( 'link', array(
        'description'   => _x( 'Upload Image', 'backend benefits', LANGUAGE_ZONE ),
        'class'         => 'dt-uploader-opener button-primary thickbox',
        'href'          => get_admin_url().'media-upload.php?post_id=' . $post->ID . '&type=image&TB_iframe=1&width=640&height=310'
    ));
	
	// delete button
    $delete = dt_melement( 'link', array(
        'description'   => _x( 'Clear', 'backend benefits', LANGUAGE_ZONE ),
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
function dt_metabox_benefits_options_save( $post_id ) {
    $box_name = 'dt_benefits_options';
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