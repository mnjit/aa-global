<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Small photos</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">    
    
    function dtShortcodeCheckAttribute( attribute, source ) {
        var expr = new RegExp('(' + attribute + ')=["|\']{1}(.*?)["|\']{1}', 'i');
        return source.match(expr);
    }

    function init() {
		
		tinyMCEPopup.resizeToInnerSize();
        
        var selectedContent = window.parent.temp_GlobalSelection,
            temp = selectedContent || '',
            temp2 = null;

        window.parent.temp_GlobalSelection = '';

        // new
        // fire ajax
        jQuery.post(
            tinymce.documentBaseURL + 'admin-ajax.php',
            {
                // action function
                action : 'dt_shortcode_small_photos_get_category_list'
            },
            function( response ){
                // insert responce
                jQuery('#dt-modal-ajax-container-1').html(response.html_content);
                dt_showhide_funnie();
                
                temp2 = dtShortcodeCheckAttribute('except', temp) || dtShortcodeCheckAttribute('only', temp);

                if ( temp2 != null ) {
/*
                if( (temp2 = dtShortcodeCheckAttribute('except', temp)) != null ||
                    (temp2 = dtShortcodeCheckAttribute('only', temp)) != null
                ) {
*/                    jQuery('input[name="show_type_gallery"]')
                        .each(function() {
                            if( temp2[1] == jQuery(this).val() ) {
                                jQuery(this).click();
                                var el_ids = temp2[2].replace(/ /g, '').split(',');
                                for( var i=0; i<el_ids.length; i++ ) {
                                    jQuery('input[name="show_gallery\['+temp2[1]+'\]\[\]"][value="'+el_ids[i]+'"]').attr('checked', 'checked');
                                }
                            }
                        });
                }

                if( (temp2 = dtShortcodeCheckAttribute('order', temp)) != null ) {
                    jQuery('input[name="dt_small_photos_order"]')
                        .each(function() {
                            if( temp2[2] == jQuery(this).val() ) {
                                jQuery(this).attr('checked', 'checked');
                            }
                        });
                }

                if( (temp2 = dtShortcodeCheckAttribute('orderby', temp)) != null ) {
                    jQuery('#dt_small_photos_orderby option')
                        .each(function() {
                            if( temp2[2] == jQuery(this).val() ) {
                                jQuery(this).attr('selected', 'selected');
                            }
                        });
                }

            }
        );
                
        if( (temp2 = dtShortcodeCheckAttribute('title', temp)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_title').val(temp2[2]);
        } 

        if( (temp2 = dtShortcodeCheckAttribute('ppp', temp)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_number').val(temp2[2]);
        } 

        if( (temp2 = dtShortcodeCheckAttribute('column', temp)) != null ) {
            jQuery('#dt_mce_window_widget_recent_photos_column option[value="'+temp2[2]+'"]').attr('selected', 'selected');
        } 
	}
	
	function insertShortcode() {
		var tagtext;
        
        var title = jQuery('#dt_mce_window_widget_recent_photos_title').val(),
            order = jQuery('input[name="dt_small_photos_order"]:checked').val(),
            orderby = jQuery('#dt_small_photos_orderby').val(),
            show_number = jQuery('#dt_mce_window_widget_recent_photos_number').val(),
            column = jQuery('#dt_mce_window_widget_recent_photos_column').val();
        
        if( show_number )
            show_number = ' ppp="' + show_number + '"';

        if( order )
            order = ' order="' + order + '"';

        if( orderby )
            orderby = ' orderby="' + orderby + '"';

        // new
        var ids = new Array();
        var filter = '';
        var selected_filter = jQuery("#dt-modal-ajax-container-1 .showhide input[type=radio]:checked");
        selected_filter.
            parent().next('.list').
            find('input[type=checkbox]:checked').
            each(function() {
                ids.push(jQuery(this).val());
            });
                    
        if( 'all' != selected_filter.val() ) {
            filter = ' ' + selected_filter.val() + '="' + ids.join() + '"';
        }

        tagtext = '[dt_recent_photos title="' + title + '" column="' + column + '"' + filter + show_number + order + orderby + '/]';	
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return;
	}
	</script>
	<base target="_self" />
    
</head>
<body onload="init();">
<?php $order_reference = array( 'ASC', 'DESC' ); ?>
    <form name="dt-photos" action="#">
        <div class="tabs">
            <ul>
                <li id="photos_tab" class="current"><span><a href="javascript:mcTabs.displayTab('photos_tab','widget_recent_photos_panel');" onmousedown="return false;">Small photos</a></span></li>
            </ul>
        </div>
        
        <div class="panel_wrapper">
            
            <div id="widget_recent_photos_panel" class="panel current">
            
                <fieldset style="padding-left: 15px;">
                    <legend> Title: </legend>
                    <input type="text" value="" name="dt_mce_window_widget_recent_photos_title" id="dt_mce_window_widget_recent_photos_title"/>
                </fieldset>

                <div id="dt-modal-ajax-container-1"></div>

                <fieldset style="padding-left: 15px;">
                    <legend> Number of items to display: </legend>
                    <input type="text" value="6" name="dt_mce_window_widget_recent_photos_number" id="dt_mce_window_widget_recent_photos_number"/>
                </fieldset>

                <fieldset style="padding-left: 15px;">
                    <legend> Column: </legend>
                    <select name="dt_mce_window_widget_recent_photos_column" id="dt_mce_window_widget_recent_photos_column">

                    <?php
                    $columns = array( 'one-fourth', 'three-fourth', 'one-third', 'two-thirds', 'half', 'full-width' );
                    foreach( $columns as $column ):
                    ?>

                        <option value="<?php echo $column; ?>"><?php echo $column; ?></option>

                    <?php endforeach; ?>

                    </select>
                </fieldset>

            </div>
            
        </div>
        
        <div class="mceActionPanel">
            <div style="float: left">
                <input type="button" id="cancel" name="cancel" value="Close" onclick="tinyMCEPopup.close();" />
            </div>

            <div style="float: right">
                <input type="submit" id="insert" name="insert" value="Insert" onclick="insertShortcode();" />
            </div>
        </div>
        
    </form>
<script language="javascript" type="text/javascript">
    function dt_showhide_funnie() {
        jQuery(".showhide").each(function () {
            var ee = this;
            jQuery("input[type=radio]", ee).change(function () {
                jQuery(".list").hide();
                if ( jQuery(this).attr("checked") )
                    jQuery(".list", ee).show();
                else
                    jQuery(".list", ee).hide();
            });
            jQuery("input[type=radio]:checked", ee).change();
        });
    }
</script>
</body>
</html>