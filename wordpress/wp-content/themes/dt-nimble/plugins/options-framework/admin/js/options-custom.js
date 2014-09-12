/**
 * Prints out the inline javascript needed for the colorpicker and choosing
 * the tabs in the panel.
 */

jQuery(document).ready(function($) {
	
	// Fade out the save message
	$('.fade').delay(1000).fadeOut(1000);
	
	// Color Picker
	$('.colorSelector').each(function(){
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
	
	// Switches option sections
	$('.group').hide();
	var activetab = '';
	if (typeof(localStorage) != 'undefined' ) {
		activetab = localStorage.getItem("activetab");
	}
	if (activetab != '' && $(activetab).length ) {
		$(activetab).fadeIn();
	} else {
		$('.group:first').fadeIn();
	}
	$('.group .collapsed').each(function(){
		$(this).find('input:checked').parent().parent().parent().nextAll().each( 
			function(){
				if ($(this).hasClass('last')) {
					$(this).removeClass('hidden');
						return false;
					}
				$(this).filter('.hidden').removeClass('hidden');
			});
	});
	
	if (activetab != '' && $(activetab + '-tab').length ) {
		$(activetab + '-tab').addClass('nav-tab-active');
	}
	else {
		$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
	}
	$('.nav-tab-wrapper a').click(function(evt) {
		$('.nav-tab-wrapper a').removeClass('nav-tab-active');
		$(this).addClass('nav-tab-active').blur();
		var clicked_group = $(this).attr('href');
		if (typeof(localStorage) != 'undefined' ) {
			localStorage.setItem("activetab", $(this).attr('href'));
		}
		$('.group').hide();
		$(clicked_group).fadeIn();
		evt.preventDefault();
	});
           					
	$('.group .collapsed input:checkbox').click(unhideHidden);
				
	function unhideHidden(){
		if ($(this).attr('checked')) {
			$(this).parent().parent().parent().nextAll().removeClass('hidden');
		}
		else {
			$(this).parent().parent().parent().nextAll().each( 
			function(){
				if ($(this).filter('.last').length) {
					$(this).addClass('hidden');
					return false;		
					}
				$(this).addClass('hidden');
			});
           					
		}
	}
	
	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');		
	});
		
	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();
	
	/* Web fonts ( BETA )
	 * Php source located in options-interface.php 'web_fonts'
	 */
	
	// Preview
	if ( $( ".of-input.dt-web-fonts" ).length > 0 ) {
		$( ".of-input.dt-web-fonts" ).on( "change", function() {
			var _this = $( this ),
				id = _this.attr( "id" ),
				value = _this.val(),
				font_header = value.replace( / /g, "+" ),
				font_style = value.split( "&" )[0],
				_preview = $( "#" + id + "_preview" ).contents(),
				italic = bold = '';
			
			font_style = font_style.split( ":" );
			
			if ( font_style[1] ) {
				var vars = font_style[1].split( 'italic' );
				
				if ( 2 == vars.length ) { italic = "font-style: italic;"; }
				
				if ( '700' == vars[0] || 'bold' == vars[0] ) {
					bold = "font-weight: bold;";
				} else if ( '400' == vars[0] || 'normal' == vars[0] ) {
					bold = "font-weight: normal;";
				} else if ( vars[0] ) {
					bold = "font-weight: " + parseInt( vars[0] ) + "};";
				} else {
					bold = "font-weight: normal;";
				}

			}else {
				bold = "font-weight: normal;";
			}
			
			var linkHref = 'http://fonts.googleapis.com/css?family=' + font_header,
				linkStyle = 'h1 { font-family: "' + font_style[0] + '";' + italic + bold + ' }';

			var style = '<link href="' + linkHref + '" rel="stylesheet" type="text/css">';
			style += '<style type="text/css">' + linkStyle + '</style>';
			var body_style = '<style type="text/css">body { margin: 0px; } h1 { text-align: center; }</style>';
			
			_preview.find( "head" ).html( style );
			
			if ( _preview.find( "body h1" ).length <= 0 ) {
				_preview.find( "body" ).html( body_style + "<h1>Duis lorem</h1>" );
			}

		} );
		$( ".of-input.dt-web-fonts" ).trigger( 'change' );
	}
	/* End Web fonts */
	
    // js_hide
    jQuery('#optionsframework input[type="checkbox"].of-js-hider').click(function() {
        var element = jQuery(this);
        element.parents('#section-'+element.attr('id')).next('.of-js-hide').fadeToggle(400);
    });
    
    jQuery('#optionsframework input[type="checkbox"]:checked.of-js-hider').each(function(){
        var element = jQuery(this);
        element.parents('#section-'+element.attr('id')).next('.of-js-hide').show();
    });
	
	// js_hide_global
    jQuery('#optionsframework input[type="checkbox"].of-js-hider-global').click(function() {
        var element = jQuery(this);
        element.parents('.section-block_begin').next('.of-js-hide').fadeToggle(400);
    });
    
    jQuery('#optionsframework input[type="checkbox"]:checked.of-js-hider-global').each(function(){
        var element = jQuery(this);
        element.parents('.section-block_begin').next('.of-js-hide').show();
    });

    // of_fields_generator script
	
	if ( jQuery('#optionsframework .of_fields_gen_list').length > 0 ) {
		jQuery('#optionsframework .of_fields_gen_list').sortable();
	}

    jQuery('button.of_fields_gen_add').click(function() {
        var container = jQuery(this).parent().prev('.of_fields_gen_list');
        var layout = jQuery(this).parents('div.of_fields_gen_controls');
        
		var size = 0;
		container.find('div.of_fields_gen_title').each( function(){
			var index = parseInt(jQuery(this).attr('data-index'));
			if( index >= size )
				size = index;
		});
		size += 1;

        var del_link = '<div class="submitbox"><a href="#" class="of_fields_gen_del submitdelete">Delete</a></div>';
        
        var new_block = layout.clone();
        new_block.find('button.of_fields_gen_add').detach();
        new_block
            .attr('class', '')
            .addClass('of_fields_gen_data menu-item-settings description')
			.append(del_link);
        
		var title = jQuery('<span class="dt-menu-item-title">').text( jQuery('.of_fields_gen_title', new_block).val() );
		var div_title = jQuery('<div class="of_fields_gen_title menu-item-handle" data-index="' + size + '"><span class="item-controls"><a class="item-edit" title="Edit Widgetized Area', 'backend fields"></a></span></div>');
		
        new_block.find('input, textarea').each(function(){
            var name = jQuery(this).attr('name').toString();
            
            // this line must be awful, simple horror
            jQuery(this).val(layout.find('input[name="'+name+'"], textarea[name="'+name+'"]').val());
            
            name = name.replace("][", "]["+ size +"][");
            jQuery(this).attr('name', name);
			
			var hidden_desc = jQuery(this).next('.dt-hidden-desc');

			if( 'checkbox' == jQuery(this).attr('type') && jQuery(this).attr('checked') && hidden_desc ) {
				div_title.prepend( hidden_desc.clone().removeClass('dt-hidden-desc') );
			}
        });
        container.append(new_block);
		
		div_title.prepend(title);
		
        new_block
            .wrap('<li class="nav-menus-php"></li>')
            .before(div_title);
        
		new_block.hide();
        del_button();
        checkbox_check();
		
		jQuery('.item-edit', div_title).click(function(event) {
			if( jQuery(event.target).parents('.of_fields_gen_title').is('div.of_fields_gen_title') ) {
				jQuery(event.target).parents('.of_fields_gen_title').next('div.of_fields_gen_data').toggle();
			}
		});
		
    });
    
	function del_button() {
		jQuery('.of_fields_gen_del').click(function() {
			var title_container = jQuery(this).parents('li').find('div.of_fields_gen_title');
			title_container.next('div.of_fields_gen_data').hide().detach();
			title_container.hide('slow').detach();
			return false;
		});
	}
	del_button();
		
	function toggle_button() { 
		jQuery('.item-edit').click(function(event) {
			if( jQuery(event.target).parents('.of_fields_gen_title').is('div.of_fields_gen_title') ) {
				jQuery(event.target).parents('.of_fields_gen_title').next('div.of_fields_gen_data').toggle();
			}
		});
	}
	toggle_button();
    
	function checkbox_check() {
		jQuery('.of_fields_gen_data input[type="checkbox"]').on('change', function() {
			var this_ob = jQuery(this);
			var hidden_desc = this_ob.next('.dt-hidden-desc');
			if( !hidden_desc.length ) return true;
			hidden_desc = hidden_desc.clone().removeClass('dt-hidden-desc');
			
			var div_title = jQuery(event.target)
                .parents('div.of_fields_gen_data')
                .prev('div.of_fields_gen_title')
				.children('.dt-menu-item-title');
			
			if( this_ob.attr('checked') ) {
				div_title.after( hidden_desc );
			}else {
				div_title.parent().find('.' + hidden_desc.attr('class')).remove();
			}
			
		});
	}
	checkbox_check();

	// on load indication
	jQuery('.section-fields_generator .nav-menus-php').each( function() {
		var title = jQuery('.dt-menu-item-title', jQuery(this));
		
		jQuery('input[type="checkbox"]:checked', jQuery(this)).each( function() {
			var hidden_desc = jQuery(this).next('.dt-hidden-desc');
			if( hidden_desc.length ) {
				var new_desc = hidden_desc.clone();
				title.after( new_desc.removeClass('dt-hidden-desc') );
			}
		});
	});

    jQuery('div.controls').change(function(event) {
        if( jQuery(event.target).not('div').is('.of_fields_gen_title') ) {
            var title = jQuery(event.target)
                .parents('div.of_fields_gen_data')
                .prev('div.of_fields_gen_title')
				.children('.dt-menu-item-title');
				
			if( title ) {
				title.text( jQuery(event.target).val() );
			}
        }
    });
    // of_fields_generator end

    /*
     * slider
     */
    jQuery( ".of-slider" ).each(function() {
        var data = jQuery(this).next('input.of-slider-value');
        var value = data.attr('data-value');
        var min = data.attr('data-min');
        var max = data.attr('data-max');
        var step = data.attr('data-step');

        if( data.length ) {
            jQuery(this).slider({
		        value: parseInt(value),
		        min: parseInt(min),
		        max: parseInt(max),
		        step: parseInt(step),
                range: 'min',
		        slide: function( event, ui ) {
			        data.val( ui.value );
		        }
	        });
            data.val(jQuery(this).slider('option', 'value'));
        }
    });

});

/* Web fonts (beta) */
// Refresh
function dtWebfontsRefresh ( id, nonce ) {
	var $fontsList = jQuery( '#' + id ),
		$ajaxLoader = $fontsList.siblings( '#' + id + '-ajax-loading' );
	
	// lunch ajax loader
	$ajaxLoader.show();
	
	if( ajaxurl ) {
		jQuery.ajax({
			type: "POST",
			url: ajaxurl,
			data: { action: "dt_refresh_web_fonts", nonce: nonce }
		}).done(function( msg ) {
			
			if ( msg ) {
				
				// get fonts list and selected option
				var $errorsContainer = $fontsList.siblings( '.dt-web-fonts-error-block' ),
					$selectedOption = jQuery( 'option[value="' + $fontsList.val() + '"]', $fontsList ),
					$msg = jQuery( msg.toString() );
				
				if ( $msg.length > 0 ) {
					// replace old options with new one
					$fontsList.html( jQuery( $msg[0] ).find( 'select' ).html() );
				}
				
				if ( $msg.length > 1 ) {
					var errors = jQuery( $msg[1] ).find( '.dt-web-fonts-error-block' ).html();
					if ( errors ) {
						// add errors
						$errorsContainer.html( errors );
					} else {
						// clear errors
						$errorsContainer.html( '' );
					}
				}

				// if there was selected font - make it so again
				jQuery( 'option[value="' + $selectedOption.val() + '"]', $fontsList ).attr( 'selected', 'selected' );
				
				// trigger change to renew prewiev
				$fontsList.trigger( 'change' );
				
				// stop ajax loader
				$ajaxLoader.hide();
			}
		});
	}
	
	return false;
}