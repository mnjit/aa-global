<?php

// help text element retieve data from thickbox
function dt_metabox_custom_uploader_script() {
    global $post;
	
    if( empty($post) ||	!in_array(get_post_type($post->ID), array('dt_portfolio', 'dt_catalog', 'post', 'page', 'dt_benefits', 'dt_logos')) ) {
        return false;
    }
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
			// copy original method
			window.dt_origin_send_to_editor = window.send_to_editor;
			
			function dtIsImage( src ) {
				if ( ! src ) return false;

				var image = /(^.*\.jpg|jpeg|png|gif|ico*)/gi;
				var document = /(^.*\.pdf|doc|docx|ppt|pptx|odt*)/gi;
				var audio = /(^.*\.mp3|m4a|ogg|wav*)/gi;
				var video = /(^.*\.mp4|m4v|mov|wmv|avi|mpg|ogv|3gp|3g2*)/gi;
				  
				if ( ! src.match(image) ) {
					
					// No output preview if it's not an image.
					// btnContent = '';
					// Standard generic output if it's not an image.
					
					return false;
				}
				return true;
			} 
			
			function dtConstrainDim( w, h ) {
				w = parseInt(w);
				h = parseInt(h);
				var p = w / h;
				
				if ( w >= h ) {
					if ( w > 266 ) {
						w = 266;
						h = parseInt( w / p );
					}
				} else {
					if ( h > 266 ){
						h = 266;
						w = parseInt( h * p );
					}
				}
				
				return {w: w, h: h};
			}
			
			jQuery('.dt-uploader-textfield').not('.dt-get-id').each( function () {
				var _this = jQuery(this);
				if ( _this.val() ) {
					//_this.prev( 'img, div.dt-no-image' ).remove();
					if ( dtIsImage( _this.val() ) ) {
						var img = new Image();
						img.onload = function() {
							var dim = dtConstrainDim( this.width, this.height );

							this.width = dim.w;
							this.height = dim.h;
						}
						img.src = _this.val();

						_this.before( jQuery( img ).addClass( 'attachment-266x266 dt-thumb' ) );
					} else {
						_this.before( '<div class="dt-no-image"></div>' );
					}
				}
			} );
			
			// save destination textfield
			jQuery('.dt-uploader-opener').on('click', function () {
				window.dt_uploader_texfield = jQuery(this).parent().find('.dt-uploader-textfield:first');
				return true;
			});
			
			// replace original method on custom
            window.send_to_editor = function ( html ) {
				if ( window.dt_uploader_texfield ) {
					var _textField = jQuery( window.dt_uploader_texfield ),
						_html = jQuery( html ),
						_img = _html.is('img') ? _html : _html.find('img');
					
					if ( _textField.hasClass('dt-get-id') && 1 == _img.length ) {
						_textField.val( parseInt( _img.attr( 'class' ).split( 'wp-image-' )[1] ) );
					} else {
						_textField.val( _img.attr( 'src' ) || _html.attr( 'href' ) );
					}
					
					_textField.prev( 'img, div.dt-no-image' ).remove();
					
					if ( dtIsImage( _img.attr( 'src' ) ) ) {
						var dim = dtConstrainDim( _img.attr( 'width' ), _img.attr( 'height' ) );
						
						_textField.before( '<image class="attachment-266x266 dt-thumb" width="' + dim.w + '" height="' + dim.h + '" src="' + _img.attr( 'src' ) + '"/>' );
						_textField.siblings( '.dt-uploader-img-w' ).val( dim.w ).siblings( '.dt-uploader-img-h' ).val( dim.h );
					} else {
						_textField.before( '<div class="dt-no-image"></div>' );
					}
					
					window.dt_uploader_texfield = null;
				} else {
					window.dt_origin_send_to_editor( html );
				}
                
                tb_remove();
            }
            
			// clear button
            jQuery('.dt-uploader-delete').on('click', function(){
                jQuery(this).parent().find('.dt-uploader-textfield:first').val('').prev( 'img, div.dt-no-image' ).remove();
				
                return false;
            });
			
			// Color Picker
			jQuery('.colorSelector').each(function(){
				var Othis = this; //cache a copy of the this variable for use inside nested function
				var initialColor = $(Othis).next('input').attr('value');
				$(this).ColorPicker({
				color: initialColor,
				onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
				},
				onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
				},
				onChange: function (hsb, hex, rgb) {
				$(Othis).children('div').css('backgroundColor', '#' + hex);
				$(Othis).next('input').attr('value','#' + hex);
			}
			});
			}); //end color picker

        });
    </script>
    <?php
}
add_action( 'admin_head-post.php', 'dt_metabox_custom_uploader_script', 999 );
add_action( 'admin_head-post-new.php', 'dt_metabox_custom_uploader_script', 999 );

// enqueue colorpicker script and style from of package
function dt_metabox_colorpicker_script( $hook ) {
	global $post;
	
	if( !in_array($hook, array('post.php', 'post-new.php')) ) return false;
	
    if( empty($post) ||	!in_array(get_post_type($post->ID), array('dt_portfolio', 'dt_catalog', 'post', 'page')) ) {
        return false;
    }
	wp_enqueue_script('color-picker', OPTIONS_FRAMEWORK_DIRECTORY. 'js/colorpicker.js', array('jquery'));
	wp_enqueue_style('color-picker', OPTIONS_FRAMEWORK_DIRECTORY.'css/colorpicker.css');
}
add_action("admin_enqueue_scripts",'dt_metabox_colorpicker_script');

?>