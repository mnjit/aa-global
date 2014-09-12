function dtWidgetSwitcherListShowHide ( element ) {
	if ( element.length != 1 ) return;

	var container = element.parents('.dt-widget-switcher').next('div.hide-if-js');
	if( 'all' == element.val() ) {
		container.hide();
	}else {
		container.show();
	}
}

// add hide/show effect to checkbox list
jQuery(document).ready( function() {
    jQuery('.dt-widget-switcher input').live( 'click', function() {
        if( jQuery(this).attr('name').search('__i__') == -1 ) {
			dtWidgetSwitcherListShowHide( jQuery(this) );
        }
    } );
	
	jQuery('.dt-widget-switcher input:checked').each( function() {
		dtWidgetSwitcherListShowHide( jQuery(this) );
	} );
});

// do some stuff on widget save
jQuery(document).ajaxSuccess(function(e, xhr, settings) {
	var search_str = '%5Bselect%5D=';
	if ( settings.data.search( 'action=save-widget' ) != -1 &&
        settings.data.search( search_str ) != -1 )
    {
        // do some stuff
		var settingsArray = settings.data.split( '&' ),
			sidebar = '',
			widgetId = '';
		for ( var i = settingsArray.length - 1; i >= 0 ; i-- ) {
			if ( sidebar && widgetId ) { break; }
			
			if ( settingsArray[ i ].search( 'sidebar=' ) != -1 ) {
				sidebar = '#' + settingsArray[ i ].split( '=' )[1] + ' ';
			} else if ( settingsArray[ i ].search( 'widget-id=' ) != -1 ) {
				widgetId = 'div.widget[id$="' + settingsArray[ i ].split( '=' )[1] + '"] ';
			}

		}
		
		dtWidgetSwitcherListShowHide( jQuery( sidebar + widgetId + '.dt-widget-switcher input:checked' ) );
	} 
} );