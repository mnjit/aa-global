<?php
function dt_get_soc_link_script( $type = 'twitter' ) {
	
	$types = array();
	
	ob_start();
	?>
	
	<!-- twitter -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
	<?php
	$types['twitter'] = ob_get_clean();
	
	ob_start();
	?>
	
	<!-- google plus -->
	<script type="text/javascript">
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
	
	<?php
	$types['google_plus'] = ob_get_clean();
	
	ob_start();
	?>
	
	<!-- facebook SDK -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	
	<?php
	$types['faceboock'] = ob_get_clean();
/*	
	ob_start();
	?>
	
	<!-- pinterest -->
	<script type="text/javascript">
	(function(d){
	  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
	  p.type = 'text/javascript';
	  p.async = true;
	  p.src = '//assets.pinterest.com/js/pinit.js';
	  f.parentNode.insertBefore(p, f);
	}(document));
	</script>

	<?php
	$types['pinterest'] = ob_get_clean();
*/

	if ( 'pinterest' == $type && !is_attachment() ) {
		wp_enqueue_script('pinit-script', get_stylesheet_directory_uri() . '/js/pin-it.js');
	}

	if( isset( $types[ $type ] ) )
		return $types[ $type ];
	return '';
}

function dt_get_like_button( $type = 'twitter', $post_id = null, $echo = true ) {
	global $post;
	if( !$post_id && $post )
		$post_id = $post->ID;

	$url_params = array(
		'twitter'		=> ' data-url="%1$s" data-text="%2$s"',
		'faceboock'		=> ' data-href="%1$s"',	
		'google_plus'	=> ' data-href="%1$s"'
	);

	$buttons = array(
		'twitter'		=> '<a href="https://twitter.com/share" class="twitter-share-button" data-lang="en"%s>Tweet</a>',
		'faceboock'		=> '<div class="fb-like" data-send="false" data-width="120" data-show-faces="false" data-layout="button_count"%s></div>',
		'google_plus'	=> '<div class="g-plusone" data-size="medium" data-annotation="inline" data-width="120"%s></div>',
		'pinterest'		=> '<span class="share-button pinterest"><a href="%s"><img title="Pin It" src="//assets.pinterest.com/images/PinExt.png" alt="Pin it" border="0" /></a></span>'
	);

	$button = $url_param = $permalink = '';
	if ( of_get_option( 'social-like_button_'. $type, true ) && isset( $buttons[ $type ] ) ) {
		if ( 'pinterest' == $type && is_attachment() ) {

			$img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'medium' );
			if ( ! $img ) return '';

			$pin_media = $img[0];
		}

		if ( $permalink = get_permalink( $post_id ) ) {

			if ( 'pinterest' == $type ) {
				
				if ( is_attachment() ) {
					$url_param = add_query_arg(
						array(
							'url' 			=> urlencode( $permalink ),
							'media' 		=> urlencode( $pin_media ),
							'description'	=> urlencode( substr( get_the_title( $post_id ), 0, 500 ) )
						),
						'http://pinterest.com/pin/create/button/'
					);

				} else {
					$url_param = '//pinterest.com/pin/create/button/" data-pin-do="buttonBookmark" data-pin-config="above';
				}
			} else {
				$url_param = sprintf( $url_params[ $type ], esc_url( $permalink ), esc_attr( get_the_title( $post_id ) ) );
			}

		}
		
		$button = sprintf( $buttons[ $type ], $url_param );
		$button = $button . dt_get_soc_link_script( $type );
	}

	if ( $echo ) {
		echo $button;
		return false;
	}
	return $button;
}

function dt_is_page_soc_buttons_enabled( $place = '', $model = true ) {
	if( $model && of_get_option('social-like_'. $place, true) )
		return true;
	return false;
}

function dt_get_like_buttons( $post_id = null, $wrap = '', $echo = true ) {
	if( !$wrap )
		$wrap = '<div class="dt-social-buttons">%s</div><style>.article{overflow: visible !important;}</style>';
	
	$links = dt_get_like_button('faceboock', $post_id, false);	
	$links .= dt_get_like_button('twitter', $post_id, false);	
	$links .= dt_get_like_button('google_plus', $post_id, false);	
	$links .= dt_get_like_button('pinterest', $post_id, false);	

	$links = sprintf( $wrap, $links );

	if( $echo ) {
		echo $links;
		return false;
	}
	return $links;
}

function dt_get_like_window( $args = array(), $echo = true ) {
	if( ! is_array( $args ) )
		$args = array();

	if( of_get_option('social-like_button_twitter', true) )
		$args['tw'] = 1;

	if( of_get_option('social-like_button_faceboock', true) )
		$args['fb'] = 1;

	if( of_get_option('social-like_button_google_plus', true) )
		$args['gp'] = 1;

	if( of_get_option('social-like_button_pinterest', true) )
		$args['pin'] = 1;

	$href = add_query_arg( $args, get_template_directory_uri().'/like_window.php' );

	ob_start();
	?>		
	<div class="dt-social-buttons dt-window-link">	
		<a href="<?php echo esc_url($href); ?>" target="_blank" onClick="popupWin = window.open(this.href, 'like window', 'location,width=465,height=320,top=0'); popupWin.focus(); return false;"><?php _e('Like!', LANGUAGE_ZONE); ?></a>	
	</div>
	<?php
	$html = ob_get_clean();

	if( $echo ) {
		echo $html;
		return false;
	}
	return $html;
}
?>