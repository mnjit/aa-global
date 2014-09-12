<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Insert Tooltip</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
    <?php require_once '../window_scripts.php'; ?>
	
    <script language="javascript" type="text/javascript">
	function init() {
		tinyMCEPopup.resizeToInnerSize();
		var selectedContent = tinyMCE.activeEditor.selection.getContent();
        if( selectedContent && selectedContent != 'undefined' ) {
			document.getElementById('tooltip_text').value = selectedContent;
		}
		
	}
	
	function insertShortcode() {
		
		var tagtext;
		
		var panel = document.getElementById('tooltip_panel');
		
		if (panel.className.indexOf('current') != -1) {
			
			var tooltip_el = document.getElementById('tooltip_el').value;
			var tooltip_text = document.getElementById('tooltip_text').value;
				
			if( tooltip_text != '' ) {
				tagtext = '[tooltip title="' + tooltip_text + '"] '+tooltip_el+' [/tooltip] ';
			}else {
				alert('Please specify a text to your tooltip.');
                return false;
			}	
		}
	
		
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
	<form name="dt-tooltips" action="#">
		<div class="tabs">
			<ul>
				<li id="tooltip_tab" class="current"><span><a href="javascript:mcTabs.displayTab('tooltip_tab','tooltip_panel');" onmousedown="return false;">Tooltips</a></span></li>
			</ul>
		</div>
		
		<div class="panel_wrapper">
		
			<div id="tooltip_panel" class="panel current">
			
				<fieldset>
					<legend>Title:</legend>
					<input type="text" name="tooltip_text" id="tooltip_text" class="wide-field">
				</fieldset>
				
				<fieldset>
					<legend>Content:</legend>
					<textarea type="text" name="tooltip_el" id="tooltip_el" class="wide-field" ></textarea>
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