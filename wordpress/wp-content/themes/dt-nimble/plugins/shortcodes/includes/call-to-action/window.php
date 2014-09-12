<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Call to action</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    
    <?php require_once '../window_scripts.php'; ?>
    
    <script language="javascript" type="text/javascript">
	function init() {
		
		tinyMCEPopup.resizeToInnerSize();
		
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
        if( selectedContent && selectedContent != 'undefined') {
			document.getElementById('call_ta_text').value = selectedContent;
		}
		
	}
	
	function insertShortcode() {
		var tagtext;
		var icon_bt = document.getElementById('dt_mce_panel-icon');
		
		var icon_link = document.getElementById('dt_mce-link').value;
		var icon_text = document.getElementById('dt_mce-text').value;
		var icon_size = document.getElementById('dt_mce-size').value;
		var icon_colour = document.getElementById('dt_mce-colour').value;
		var icon_target = jQuery('input[type=checkbox]#dt_mce-target:checked').length?' blank="true"':'';

        if( icon_size )
            icon_size = ' size="' + icon_size + '"';

        if( icon_colour )
            icon_colour = ' colour="' + icon_colour + '"';
		
		if( icon_text )
			icon_text = ' button_text="' + icon_text + '"';
		
		if( icon_link )
			icon_link = ' url="' + icon_link + '"';
		
		// who is active ?
		if (icon_bt.className.indexOf('current') != -1) {
			var text = jQuery('#call_ta_text').val();
		    tagtext = '[call_to_action'+ icon_link + icon_target + icon_size + icon_colour + icon_text + ']'+text+'[/call_to_action]';
		}
		
		if(window.tinyMCE) {
			window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tagtext);
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.close();
		}
		
		return false;
	}
	</script>
	<base target="_self" />
    
</head>
<body onload="init();">
	<form name="dt-calltoaction" action="#">
	<div class="tabs">
		<ul>
			<li id="dt_mce_pu_tab-icon" class="current"><span><a href="javascript:mcTabs.displayTab('dt_mce_pu_tab-icon','dt_mce_panel-icon');" onmousedown="return false;">Call to action</a></span></li>
		</ul>
	</div>
	
	<div class="panel_wrapper">      
    
		<div id="dt_mce_panel-icon" class="panel current">
        
        <fieldset>
            <legend>Text:</legend>
            <textarea name="call_ta_text" id="call_ta_text" class="wide-field"></textarea>
        </fieldset>
		
		<fieldset style="padding-left: 15px;">
            <legend>Options:</legend>

            <p>
	            <label for="dt_mce-size">Size:</label>
                <select name="icon_size" id="dt_mce-size" style="width: 230px">
                    <option value="">small</option>
                    <option value="middle">middle</option>
                    <option value="big">big</option>
                </select>
	            <em>Button size</em>
            </p>

            <p>
	            <label for="dt_mce-colour">Colour:</label>
                <select name="icon_colour" id="dt_mce-colour" style="width: 230px">
                    <option value="">default</option>
                    <option value="red">red</option>
                    <option value="green">green</option>
                    <option value="blue">blue</option>
                </select>
	            <em>Button colour</em>
            </p>

            <p>
	            <label for="dt_mce-text">Text:</label>
	            <input type="text" name="icon_text" id="dt_mce-text" style="width: 230px" />
	            <em>Insert the text of your button.</em>
            </p>

            <p>
                <label for="dt_mce-link">Link: <input type="text" name="icon_link" id="dt_mce-link" style="width: 230px" />
                <em>The URL your button will redirect to.</em>
            </p>

            <input type="checkbox" name="icon_target" id="dt_mce-target" value="true"/>
            <label for="dt_mce-target"> Open the link in a new window</label>

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