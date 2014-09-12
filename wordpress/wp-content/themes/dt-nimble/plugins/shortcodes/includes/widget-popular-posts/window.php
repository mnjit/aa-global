<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Blog Posts</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    var list = new Array( 'cats', 'select', 'orderby', 'order', 'ppp', 'thumbs', 'column', 'title' );
	
    function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = window.parent.temp_GlobalSelection;
		
		jQuery('.dt_select').on('change', function(e) {
			if( 'all' == jQuery(e.target).val() ) {
				jQuery('#dt_ajaxing_posts_list').hide();
			}else {
				jQuery('#dt_ajaxing_posts_list').show();
			}
		});
		
        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_shortcodes_ajax_popular_posts'
            },
            function( response ){
                var terms = response.terms,
					temp = selectedContent,
					temp2 = null,
					terms_box = jQuery('#dt_ajaxing_posts_list');
				
				if( terms.length ) {
					for( term in terms ){
						var item = jQuery('<input />');
						item.attr('type', 'checkbox')
							.attr('name', 'cats[]')
							.attr('value', terms[term].id);
						terms_box.append(item);
						item.wrap('<label style="display: block;"></label>').parent().append('&nbsp;' + terms[term].name);					}
				}
				
				if( temp ) {
					for( var i=0; i < list.length; i++ ) {
						
						if( (temp2 = temp.match(new RegExp("(" + list[i] + ")=[\"|']{1}(.*?)[\"|']{1}", 'i')) ) != null ) {
							
							if( 'cats' == list[i] ) {
								var tmp_arr = temp2[2].replace(/\s/g, '').split(',');
								jQuery('input', terms_box).each( function() {
									if( -1 != tmp_arr.indexOf(jQuery(this).val()) ) {
										jQuery(this).attr('checked', 'checked');
									}
								});
							}else if( 'select' == list[i] || 'order' == list[i] ) {
								jQuery('[name="' + list[i] + '"][value="' + temp2[2] + '"]').attr('checked', 'checked').trigger('change');
							}else if( 'orderby' == list[i] || 'column' == list[i] ){
								jQuery('select[name="' + list[i] + '"] option[value="' + temp2[2] + '"]').attr('selected', 'selected');
							}else if( 'thumbs' == list[i] ) {
			
								if( parseInt(temp2[2]) ){
									jQuery('[name="' + list[i] + '"]').attr('checked', 'checked');
								} else {
									jQuery('[name="' + list[i] + '"]').removeAttr('checked');
								}
								
							}else {
								jQuery('[name="' + list[i] + '"]').val(temp2[2]);
							}
							
						}// endif temp2
						
					}// endfor
				}// endif temp
            }// end function
        );

	}
	
	function insertShortcode() {
		var tagtext;
        
		tagtext = '[dt_blog_posts';
		
		for( var i=0; i < list.length; i++ ) {
			
			var value = '';
			
			if( 'cats' == list[i] ){
				value = new Array();
				jQuery('#dt_ajaxing_posts_list input:checked').each( function() {
					value.push(jQuery(this).val());
				});
				value = value.join(',');
			}else if( 'select' == list[i] || 'order' == list[i] ) {
				value = jQuery('[name="' + list[i] + '"]:checked').val();
			}else if( 'orderby' == list[i] || 'column' == list[i] ){
				value = jQuery('select[name="' + list[i] + '"] option:selected').val();
			}else if( 'thumbs' == list[i] ) {
				value = jQuery('[name="' + list[i] + '"]:checked').length.toString();
			}else {
				value = jQuery('[name="' + list[i] + '"]').val();
			}
			
			if( value )
				tagtext += ' ' + list[i] + '="' + value + '"';
				
		}
		
		tagtext += ' /]';
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			//Peforms a clean up of the current editor HTML. 
			//tinyMCEPopup.editor.execCommand('mceCleanup');
			//Repaints the editor. Sometimes the browser has graphic glitches. 
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return false;
	}
	</script>
	<base target="_self" />
    
</head>
<body onload="init();">
	<form name="dt-popular" action="#">
		
        <div class="tabs">
            <ul>
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','widget_latposts_panel');" onmousedown="return false;">Blog posts</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <div id="widget_latposts_panel" class="panel current">
				
				<fieldset style="padding-left: 15px;">
					
					<legend> Title: </legend>
					
					<input type="text" value="" name="title" id="title" />
				
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<legend> Show Posts from following categories: </legend>
					
					<label><input type="radio" value="all" name="select" class="dt_select" checked="checked" />&nbsp;All</label>
					&nbsp;
					<label><input type="radio" value="only" name="select" class="dt_select" />&nbsp;Only</label>
					&nbsp;
					<label><input type="radio" value="except" name="select" class="dt_select" />&nbsp;Except</label>
					
					<div id="dt_ajaxing_posts_list" style="display: none;"></div>
				
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<legend> Show: </legend>
					
					<?php
					$p_orderby = array(
						'modified'  	=> 'Order by modified',
						'date'      	=> 'Order by date',
						'ID'        	=> 'Order by ID',
						'author'    	=> 'Order by author',
						'title'     	=> 'Order by title',
						'rand'      	=> 'Order by rand',
						'menu_order'	=> 'Order by menu'
					);
					?>
					
					<select name="orderby" id="dt_orderby">
					
					<?php foreach( $p_orderby as $value=>$title ): ?>
						
						<option value="<?php echo $value; ?>"><?php echo $title; ?></option>
					
					<?php endforeach; ?>
					
					</select>
				
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<legend> Sort by: </legend>
					
					<label>Ascending&nbsp;<input type="radio" value="ASC" name="order" class="dt_order" checked="checked" /></label>
					&nbsp;
					<label><input type="radio" value="DESC" name="order" class="dt_order" />&nbsp;Descending</label>
					
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<legend> How many: </legend>
					
					<input type="text" value="5" name="ppp" id="dt_ppp" />
					
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<label><input type="checkbox" value="1" name="thumbs" id="dt_thumbs" checked="checked" />&nbsp;Show featured images</label>
					
				</fieldset>
				
				<fieldset style="padding-left: 15px;">
					
					<legend> Column: </legend>
					
					<select name="column" id="column">

					<?php
					$columns = array(
						'one-fourth'        => 'one-fourth',
						'three-fourth'      => 'three-fourth',
						'one-third'         => 'one-third',
						'two-thirds'        => 'two-thirds',
						'half'              => 'half',
						'full-width_three'  => 'full-width(three columns)',
						'full-width_fourth' => 'full-width(four columns)'
					);
					foreach( $columns as $val=>$desc ):
					?>

						<option value="<?php echo $val; ?>"><?php echo $desc; ?></option>

					<?php endforeach; ?>

					</select>
				
				</fieldset>
			
			</div>
            
        </div>
        
        <div class="mceActionPanel">
            <div style="float: left">
                <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close(); return false;" />
            </div>

            <div style="float: right">
                <input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode(); return false;" />
            </div>
        </div>
        
    </form>
</body>
</html>