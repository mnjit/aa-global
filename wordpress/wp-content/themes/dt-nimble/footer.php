<?php
$show_bottom_line = true;
if ( dt_storage( 'is_homepage' ) && ! dt_storage( 'have_obo_slider' ) ) {
	$page_opts = get_post_meta( get_the_ID(), '_dt_slider_layout_options', true );
	if ( isset( $page_opts['slider'], $page_opts['fs_hide_footer'] ) &&
		'fullscreen_slider' == $page_opts['slider'] && $page_opts['fs_hide_footer']
	) { $show_bottom_line = false; }
}
?>

<?php if ( $show_bottom_line ): ?>

<div class="line-footer"></div>
<footer id="footer">
	<div class="light"></div>

	<?php
	dt_footer_widgetarea();

	$logos = array(
		'logo' 			=> dt_get_uploaded_logo( of_get_option( 'branding-footer_logo', array() ) ),
		'logo_retina'	=> dt_get_uploaded_logo( of_get_option( 'branding-retina_footer_logo', array() ), 'retina' )
	);
	$default_logo = null;
	$alt = get_bloginfo( 'name' );

	// get default logo
	foreach ( $logos as $logo ) {
		if ( $logo ) { $default_logo = $logo; break; } 
	}

	$flogo_class = '';
	if ( $default_logo ) {
		$flogo_class = ' class="logo-down-' . of_get_option( 'branding-footer_logo_position', false ) . '"';
	}
	?>

    <div id="bottom"<?php echo $flogo_class; ?>>
		<div class="bottom-cont">

			<?php if ( $default_logo ): ?>
			
				<?php
				$logo = dt_get_retina_sensible_image( $logos['logo'], $logos['logo_retina'], $default_logo, 'id="dt-footer-logo" class="dt-footer-logo" alt="' . $alt . '"' );
				?>
				
				<a href="<?php echo home_url(); ?>" class="logo-down"><?php echo $logo; ?></a>
			
			<?php endif; ?>

			<?php
			$copyright = of_get_option( 'branding-copyrights', '' );
			$credits = of_get_option( 'branding-dt_credits', false );
			
			if ( $copyright || $credits ):
			?>
	
			<div class="copy-credits">

				<?php if ( $copyright ): ?>
						<span class="bot-info"><?php echo $copyright; ?></span>
				<?php endif; ?>

				<?php if ( $credits ): ?>
						<span class="copy">Powered by <a href="http://wordpress.org/">WordPress</a>. Created by <a href="http://dream-theme.com/" title="premium wordpress themes">Dream-Theme</a>. </span>
				<?php endif; ?>
			
			</div>

			<?php endif;// copyrights || credits ?>

		</div>
	</div>
</footer>

<?php endif; // show bottom line ?>

<?php
if ( dt_storage( 'is_homepage' ) ) {
	if ( dt_storage( 'have_obo_slider' ) ) {
		get_template_part( 'slider', 'obo' );
	} else {
		get_template_part( 'slider' );
	}
}
?>

</div>
</div>

</div>
<div id="mobile-menu" class="mobile-menu">
	<div class="but-wrap">
		<div class="button big">
			<span><i class="line-one"></i><i class="line-two"></i><i class="line-three"></i><i class="line-four"></i><?php _e('Menu ', LANGUAGE_ZONE); ?><i class="cross"> &#10006 </i></span>
		</div>
	</div>
	<?php
	dt_menu( array(
		'menu_wraper' 	=> '<div class="menu-wrap"><ul class="menu-container">%MENU_ITEMS%</ul></div>',
		'menu_items'	=> '<li %IS_FIRST%><a class="%ITEM_CLASS%" href="%ITEM_HREF%"%ESC_ITEM_TITLE%><span class="inner-item">%ITEM_TITLE%</span></a>%SUBMENU%</li>',
		'submenu' 		=> '<div><ul>%ITEM%</ul></div>'
	) );
	?>
</div>
<div id="overlay" class="overlay"></div>

<?php wp_footer(); ?>

<script type="text/javascript">
/* <![CDATA[ */
// DO NOT REMOVE!
// b21add52a799de0d40073fd36f7d1f89
if( typeof window['hs'] !== 'undefined' ) {
	hs.graphicsDir = '<?php echo get_template_directory_uri(); ?>/js/plugins/highslide/graphics/';
}

window.blur_effect = <?php echo intval( of_get_option( 'misc-rollover_blur', 1 ) ); ?>;
window.isRetinaInOptions = <?php echo dt_is_retina_on(); ?>;
<?php
/* Tourn off responsivness if option "misc-off_responsivness" is set
 * Another part of this action located in header.php (change viewport) and functions.php (dt_tourn_off_responsivness function)
 * dt_is_responsive() located on /modules/helpers/template-helpers.php
 */
?>
window.notResponsive = <?php echo absint( ! dt_is_responsive() ); ?>;

<?php if ( dt_storage( 'is_homepage' ) && dt_storage( 'have_obo_slider' ) ): ?>

jQuery(document).ready(function() {

	<?php $obo_opts = get_post_meta( $post->ID, '_dt_obo_slider_layout_options', true ); ?>

	jQuery('#banner').oneByOne({
		className: 'oneByOne1',
		slideShow: <?php echo !empty($obo_opts['autoslide'])?'true':'false'; ?>,
		slideShowDelay: <?php echo !empty($obo_opts['autoslide'])?$obo_opts['autoslide']:0; ?>
	});

	jQuery('#banner img, #banner .oneByOne_item, .dt-obo-content ').css('visibility', 'visible');

	if (jQuery('.byOne').next('#wrapper').length > 0) {
		jQuery('.byOne').addClass('oneBy-content');
	} else {
		jQuery('.oneByOne1').removeClass('oneBy-content');
	}

	var $oneByOne = jQuery('.oneByOne1');
	window.oboRatio			= $oneByOne.width()/$oneByOne.height();
	window.block 			= new Array();
	window.oneByOne_height	= $oneByOne.css('height');
	window.length_obo		= jQuery('.oneByOne_item', $oneByOne).length;

	if (length_obo <= 1) {
		jQuery('.navig-nivo.onebyone').addClass('hide');
	} else {
		jQuery('.navig-nivo.onebyone').removeClass('hide');
	}

	var oboResize = false;

	jQuery(window).on("resize", function() {
	
		clearTimeout(oboResize);
		oboResize = setTimeout(function() {

			jQuery('#slide').css({
				 height: ( jQuery('#slide').width() / oboRatio )
			});

			jQuery('.navig-nivo.onebyone').css({
				top: jQuery('.oneByOne1').height()/2 - 12
			});

			if(jQuery(window).width() < 739){
				jQuery('.oneByOne1').addClass('mobile');
			} else {
				jQuery('.oneByOne1').removeClass('mobile');
			}

		}, 200);
		
	}).trigger("resize");
	
});

<?php endif; ?>

jQuery(function($){	
	if( dtStorage.isiPhone ){
	   setTimeout(function(){
		window.scrollTo(0, 0);
		}, 0);
	}
})

/* ]]> */
</script>

<?php
/*
 * Overlay mask
 */
if( of_get_option('main_bg-overlay_enable') ): ?>
	
	<div class="overlay-mask"></div>
	
<?php endif; ?>

</body>
</html>