<?php

// media uploader for gallery filter
function dt_f_obo_slider_mu($tabs) {
	if ( isset( $_REQUEST['post_id'] ) && 'dt_obo_slider' == get_post_type( $_REQUEST['post_id'] ) && ! empty( $_GET['dt_custom'] ) ) {
		global $wpdb;
        
        if( isset($tabs['library']) ) {
			unset($tabs['library']);
		}
		
        if( isset($tabs['gallery']) ) {
			unset($tabs['gallery']);
		}
        
        if( isset($tabs['type_url']) ) {
			unset($tabs['type_url']);
		}
        
        $post_id = intval($_REQUEST['post_id']);
  
        if ( $post_id ) {
            $attachments = intval( $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $wpdb->posts WHERE post_type = 'attachment' AND post_status != 'trash' AND post_parent = %d", $post_id ) ) );
        }
        
        if ( empty($attachments) ) {
            unset($tabs['gallery']);
            return $tabs;
        }
    
		if( !isset($tabs['dt_obo_slider_media'] )) {
			$tabs['dt_obo_slider_media'] = sprintf( _x( 'Images (%s)', 'backend oboslider', LANGUAGE_ZONE ), "<span id='attachments-count'>$attachments</span>");
		}
        
        if( isset($tabs['type']) ) {
            $tabs['type'] = 'Upload';
        }
	}
	return $tabs;
}
add_filter('media_upload_tabs', 'dt_f_obo_slider_mu', 99 );

// fields filter for custom uploader
function dt_f_obo_slider_att_fields($fields, $post) {
	if( 'dt_obo_slider' == get_post_type($post->post_parent) ) {
		
		// position left field
        $fields["dt_obo_slider_pos_left"]["label"] = _x("Position Left (px)", 'backend slider', LANGUAGE_ZONE);
        $fields["dt_obo_slider_pos_left"]["input"] = "text";
        $fields["dt_obo_slider_pos_left"]['value'] = get_post_meta($post->ID, "_dt_obo_slider_pos_left", true);
		
		// position top field
        $fields["dt_obo_slider_pos_top"]["label"] = _x("Position Top (px)", 'backend slider', LANGUAGE_ZONE);
        $fields["dt_obo_slider_pos_top"]["input"] = "text";
        $fields["dt_obo_slider_pos_top"]['value'] = get_post_meta($post->ID, "_dt_obo_slider_pos_top", true);
			
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_obo_slider_att_fields', 99, 2);

// upload tab custom fields save handler
function dt_f_obo_slider_att_fields_save($post, $attachment) {
	// prevent loading gallery after save uploaded images
    if( 'dt_obo_slider' == get_post_type($_REQUEST['post_id']) && !empty($_GET['dt_custom']) ) {
        if( isset($_GET['tab']) && 'type' == $_GET['tab']) {
            unset($_POST['save']);
        }
    }
    	
    if( 'dt_obo_slider' == get_post_type($post['post_parent']) ) {
       
        // hide desc (checkbox)
        update_post_meta($post['ID'], '_dt_obo_slider_pos_left', intval($attachment['dt_obo_slider_pos_left']));
        
        // open in new window (checkbox)
        update_post_meta($post['ID'], '_dt_obo_slider_pos_top', intval($attachment['dt_obo_slider_pos_top']));
    }
    
	return $post;
}
add_filter('attachment_fields_to_save', 'dt_f_obo_slider_att_fields_save', 99, 2);

// add custon column in slideshow list
function dt_f_obo_slider_col_thumb( $defaults ){
    $defaults['dt_obo_slider_cat'] = _x( 'Category', 'backend oboslider', LANGUAGE_ZONE );
	
	$head = array_slice( $defaults, 0, 1 );
    $tail = array_slice( $defaults, 1 );
    
    $head['dt_obo_slider_thumbs'] = _x( 'Thumbs', 'backend oboslider', LANGUAGE_ZONE );
    
    $defaults = array_merge( $head, $tail );
    
    return $defaults;
}
add_filter('manage_edit-dt_obo_slider_columns', 'dt_f_obo_slider_col_thumb', 5);

function dt_f_obo_slider_hide_mboxes( $hidden, $screen, $use_defaults ) {
    $template = dt_core_get_template_name();
    if( 'dt-obo-slideshow-fullwidth.php' == $template ||
		'dt-obo-slideshow-sidebar.php' == $template ||
		'dt-obo-homepage-blog.php' == $template ) {
        $meta_boxes = dt_core_get_metabox_list();
        if( !empty($meta_boxes) ) {
            $hidden = array_unique( array_merge($hidden, $meta_boxes) );
             
            foreach( $hidden as $index=>$box ){
                if( 'dt_page_box-obo_slides_list' == $box ||
                    'dt_page_box-obo_slides_options' == $box ||
					'dt_page_box-footer_options' == $box ||
					'dt_page_box-background_options' == $box ||
                    ('dt-obo-slideshow-sidebar.php' == $template && 'dt_page_box-sidebar_options' == $box)
                ) {
                    unset( $hidden[$index] );
                }
            }
        }
    }
    return $hidden;
}
add_filter('hidden_meta_boxes', 'dt_f_obo_slider_hide_mboxes', 99, 3);
?>