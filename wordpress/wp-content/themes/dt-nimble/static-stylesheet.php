<?php
global $post;
$template = dt_core_get_template_name();

?>
	<?php
	/*
	 *	Google fonts
	 */

	$blod = $italic = '';
	$font = of_get_option('fonts-list', 'Arial');
	$clear = explode('&', $font);
	$clear = explode(':', $clear[0]);
	
	if( isset($clear[1]) ) {
		$vars = explode('italic', $clear[1]);
		
		if( isset($vars[1]) ) $italic = "\nfont-style: italic;";
		
		if( '700' == $vars[0] || 'bold' == $vars[0] ) {
			$bold = "\nfont-weight: bold;";
		}else if( '400' == $vars[0] || 'normal' == $vars[0] ) {
			$bold = "\nfont-weight: normal;";
		}else if( $vars[0] ) {
			$bold = "\nfont-weight: {$vars[0]};";
		}else
			$bold = "\nfont-weight: normal;";
			
	}else
		$bold = "\nfont-weight: normal;";
	
	?>
	/* Google Fonts */
	#slider .nivo-caption .caption-head,
	.carousel-caption .caption-head,
	.header,
	.ps-head,
	.textwidget > .info > .head,
	.caption-head,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.fs-title
	{
		font-family: '<?php echo $clear[0]; ?>', 'Arial', cursive !important;
		<?php echo $italic, $bold; ?>
	}
	
	<?php
	/*
	 *	Overlay
	 */

	if( of_get_option('main_bg-overlay_enable') ):
	?>
	
	/* overlay */
	.overlay-mask {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('main_bg-overlay_image', 'none'),
			of_get_option('main_bg-overlay_custom'),
			of_get_option('main_bg-bg_upload')
		); ?>
	}
	
	<?php endif; ?>
	
	/* appearance background font-family content-text-color content-text-shadow-color */    
	body {
		font: 12px/20px "<?php echo str_replace('_', ' ', of_get_option('fonts-font_family')); ?>", Arial, Helvetica, sans-serif;
		font-size: <?php echo of_get_option( 'fonts-font_size', 12 ); ?>px !important;
		color: <?php echo of_get_option('fonts_content-primary_color'); ?>; 
	}
	
	#container > *,
	.foot-cont > *,
	.list-carousel.coda li,
	.i-l,
	.autor,
	.team-description
	{
		font-size: <?php echo of_get_option( 'fonts-font_size', 12 ); ?>px;
	}
	
	<?php /*if ( 'full-screen' == $bg_repeat ) : ?>
		#ie8 body, #ie7 body {
			background-repeat: repeat !important;
			background-position: center top !important;
		}
	<?php endif;*/ ?>
	
	.pagin-info,
	.team-wrap .head,
	.custom-menu li a,
	.panel .panel-wrapper a,
	.reviews-t,
	.post a,
	ul.categories li a,
	.do-clear,
	.c-clear,
	.ico-twit a
	{
		color: <?php echo of_get_option('fonts_content-primary_color'); ?> !important; 
	}
	.custom-menu li a:after
	{
		border-left: solid 3px <?php echo of_get_option('fonts_content-primary_color'); ?> !important;
		
	}
		
	<?php if( of_get_option('boxed_layout-enable') ): ?>
	
	/* boxed lauout */
	#page.boxed {
		background-color: <?php echo dt_style_options_get_rgba_from_hex_color( array(),
			of_get_option('boxed_layout-bg_color'),
			of_get_option('boxed_layout-bg_opacity')
		); ?> !important;
		-webkit-box-shadow: 0px 0px 5px 1px <?php echo dt_style_options_get_rgba_from_hex_color( array(), 
			of_get_option('boxed_layout-shadow_color'),
			of_get_option('boxed_layout-shadow_opacity')
		); ?> !important;
		box-shadow: 0px 0px 5px 1px <?php echo dt_style_options_get_rgba_from_hex_color( array(),
			of_get_option('boxed_layout-shadow_color'),
			of_get_option('boxed_layout-shadow_opacity')
		); ?> !important;
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('boxed_layout-bg_image', 'none'),
			of_get_option('boxed_layout-bg_custom'),
			of_get_option('boxed_layout-bg_upload')
		); ?>
		
		-ms-filter: "<?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('boxed_layout-bg_color'),
			of_get_option('boxed_layout-bg_opacity')
		); ?>";

		filter: <?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('boxed_layout-bg_color'),
			of_get_option('boxed_layout-bg_opacity')
		); ?>;
	}
	
	<?php endif; ?>
	
<?php
$accent_color = of_get_option( 'accent-color', '#00D0DD' );
?>
	/* color accent */
	
	/* for homepage sliders */
	#carousel .carousel-feature .carousel-caption,
	.slide-desc,
	#slide .nivo-caption,
	.jfancytileTitle
	{
		border-bottom: solid 4px <?php echo $accent_color; ?> !important;
	}
	
	.accent,
	.fs-caption {
		border-color: <?php echo $accent_color; ?> !important;
	}
	
	/* for some stuff ... */
	a.alignleft i.fade,
	a.alignright i.fade,
	a.alignnone i.fade,
	a.aligncenter i.fade,
	a.photo i.fade,
	.flickr i,
	.categ:hover,
	.categ.act
	{
		border-bottom: solid 3px <?php echo $accent_color; ?> !important;
	}
	
	/* for tabs and ... */
	ul.nav-tab li:hover, ul.nav-tab li.current
	{
		border-bottom: solid 2px <?php echo $accent_color; ?> !important;
	}
	
	/* for call to action ... */
	.about
	{
		border-left: solid 4px <?php echo $accent_color; ?> !important;
	}
	
	
	i.fade:after,
	ul.nav-tab li:hover:after,
	ul.nav-tab li.current:after,
	ul.gallery li i.fade
	{
		border-bottom: solid 3px <?php echo $accent_color; ?> !important;
		
	}
	.about-cont:after,
	ul li:after
	{
		border-left: solid 3px <?php echo $accent_color; ?> !important;		
	}
	
	/* for arrows ... */
	a.prev span.a-r-s,
	a.next span.a-r-s,
	span.a-r-s
	{
		color: <?php echo $accent_color; ?> !important;
	}

/* dividers content */
<?php
$wide_divider = dt_style_options_get_image(
	array( 'important' => false ),
	of_get_option('divs_and_heads-content_wide_divider', 'none'),
	of_get_option('divs_and_heads-content_wide_divider_custom'),
	of_get_option('divs_and_heads-content_wide_divider_upload')
);

$wide_divider_important = dt_style_options_get_image(
	array(),
	of_get_option('divs_and_heads-content_wide_divider', 'none'),
	of_get_option('divs_and_heads-content_wide_divider_custom'),
	of_get_option('divs_and_heads-content_wide_divider_upload')
);

$narrow_divider = dt_style_options_get_image(
	array(),
	of_get_option('divs_and_heads-content_narrow_divider', 'none'),
	of_get_option('divs_and_heads-content_narrow_divider_custom'),
	of_get_option('divs_and_heads-content_narrow_divider_upload')
);
?>

	.hr.hr-wide, .entry-content.cont {
		background-image: <?php echo $wide_divider; ?>
		background-position: <?php echo dt_style_options_get_bg_position('top', 'left'); ?>
		background-repeat: <?php echo of_get_option('divs_and_heads-content_wide_divider_repeatx')?'repeat-x':'no-repeat'; ?>;
	}

	.entry-content.one-line {		
		background-image: <?php echo $wide_divider_important; ?>		
		background-position: <?php echo dt_style_options_get_bg_position('bottom', 'left'); ?>
		background-repeat: <?php echo of_get_option('divs_and_heads-content_wide_divider_repeatx')?'repeat-x':'no-repeat'; ?>;
	}
		
	#comments .text, .hr.hr-narrow, .type-post, .post, ul.categories li, .gallery .textwidget.text, .item-blog, .dt-testimon  {
		background-image: <?php echo $narrow_divider; ?>
		background-position: <?php echo dt_style_options_get_bg_position('top', 'left'); ?>
		background-repeat: <?php echo of_get_option('divs_and_heads-content_narrow_divider_repeatx')?'repeat-x':'no-repeat'; ?>;
	}
	
	#comments .text {
		background-position: <?php echo dt_style_options_get_bg_position('bottom', 'left'); ?>
	}
/* end dividers content */

/* widgets/shotcodes background */
<?php
$color = dt_style_options_get_rgba_from_hex_color(
	array( 'important' => false ),
	of_get_option('widgetcodes-bg_color'),
	of_get_option('widgetcodes-bg_opacity')
);
$ie_color = dt_style_options_get_rgba_from_hex_color_for_ie(
	array( 'important' => false ),
	of_get_option('widgetcodes-bg_color'),
	of_get_option('widgetcodes-bg_opacity')
)
?>
	#wp-calendar td, #calendar_wrap, #wp-calendar caption, #aside .slider-wrapper, .half .slider-wrapper, .full .slider-wrapper, .two-thirds .slider-wrapper, .one-fourth .slider-wrapper {
		background-color: <?php echo $color; ?>;
	}

	.about, .custom-menu > li, .partner-bg, .shadow-light, .reviews-t, #aside .twit .reviews-t, .blockquote-bg, .slider-shprtcode, .toggle, .basic .accord, ul.nav-tab li, .list-wrap, .jfancytileContainer, .anything-video, .videos, .wp-caption-text, .loading-image, .dt-testimon .panel-wrapper {
		background-color: <?php echo $color; ?>;
	}

	/* for ie8 */
	#ie7 #wp-calendar td, #ie7 #calendar_wrap, #ie7 #wp-calendar caption, #ie7 #aside .slider-wrapper, #ie7 .half .slider-wrapper, #ie7 .full .slider-wrapper, #ie7 .two-thirds .slider-wrapper, #ie7 .one-fourth .slider-wrapper, #ie7 .wp-caption-text {
		filter: <?php echo $ie_color; ?>;
	}

	#ie7 .about, #ie7 .custom-menu > li, #ie7 .partner-bg, #ie7 .loading-image, #ie7 .shadow-light, #ie7 .reviews-t, #ie7 .dt-testimon .panel-wrapper, #ie7 #aside .twit .reviews-t, #ie7 .blockquote-bg, #ie7 .slider-shprtcode, #ie7 .toggle, #ie7 .basic .accord, #ie7 ul.nav-tab li, #ie7 .list-wrap{
		filter: <?php echo $ie_color; ?>;
	}
	
	/* for ie8 */
	#ie8 #wp-calendar td, #ie8 #calendar_wrap, #ie8 #wp-calendar caption, #ie8 #aside .slider-wrapper, #ie8 .half .slider-wrapper, #ie8 .full .slider-wrapper, #ie8 .two-thirds .slider-wrapper, #ie8 .one-fourth .slider-wrapper, #ie8 .wp-caption-text {
		-ms-filter: "<?php echo $ie_color; ?>";
	}

	#ie8 .about, #ie8 .custom-menu > li, #ie8 .partner-bg, #ie8 .loading-image, #ie8 .alignright, #ie8 .aligncenter, #ie8 .shadow-light, #ie8 .reviews-t, #ie8 .dt-testimon .panel-wrapper, #ie8 #aside .twit .reviews-t, #ie8 .blockquote-bg, #ie8 .slider-shprtcode, #ie8 .toggle, #ie8 .basic .accord, #ie8 ul.nav-tab li, #ie8 .list-wrap {
		-ms-filter: "<?php echo $ie_color; ?>";
	}
	
	.reviews-b,
	.dt-testimon .panel-wrapper:after {
		border-top: 12px solid <?php echo $color; ?>;
	}

	/* background headers homepage background */
	#home-bg {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('header_homepage-bg_image', 'none'),
			of_get_option('header_homepage-bg_custom'),
			of_get_option('header_homepage-bg_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('header_homepage-bg_horizontal_pos'),
			of_get_option('header_homepage-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('header_homepage-bg_repeat'); ?>;
	}

	/* background headers content background */
	#bg {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('header_content-bg_image', 'none'),
			of_get_option('header_content-bg_custom'),
			of_get_option('header_content-bg_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('header_content-bg_horizontal_pos'),
			of_get_option('header_content-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('header_content-bg_repeat'); ?>;
	}
	
	
	
	/* background headers top line background */
	#top-bg {
		background-image: <?php $image = dt_style_options_get_image(
			array(),
			of_get_option('top_line-bg_image', 'none'),
			of_get_option('top_line-bg_custom'),
			of_get_option('top_line-bg_upload')
		); echo $image;
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('top_line-bg_horizontal_pos'),
			of_get_option('top_line-bg_vertical_pos')

		); ?>
		background-repeat: <?php echo of_get_option('top_line-bg_repeat'); ?>;
		background-color: <?php echo dt_style_options_get_rgba_from_hex_color(
			array(),
			of_get_option('top_line-bg_color'),
			of_get_option('top_line-bg_opacity')
		); ?> !important;

		-ms-filter: "<?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('top_line-bg_color'),
			of_get_option('top_line-bg_opacity')
		); ?>";
		
		filter: <?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('top_line-bg_color'),
			of_get_option('top_line-bg_opacity')
		); ?> !important;
	}

<?php
/*
 *	Headers icons
 */

$h_icons_style = of_get_option( 'header-icons_style', 'white' );
if ( ! in_array( $h_icons_style , array( 'white', 'black' ) ) ) { $h_icons_style = 'white'; }

$h_icon_url = 'url(' . get_template_directory_uri() . '/images/' . $h_icons_style . '/icons.png)';
$h_retina_icon_url = 'url(' . get_template_directory_uri() . '/images/retina/' . $h_icons_style . '/icons.png)';

$h_icons_opacity = dt_style_options_get_opacity( of_get_option( 'header-icons_opacity', 70 ) );

/*
 *	Content icons
 */

$c_icons_style = of_get_option( 'main-icons_style', 'black' );
if ( ! in_array( $c_icons_style , array( 'white', 'black' ) ) ) { $c_icons_style = 'black'; }

$c_icon_url = 'url(' . get_template_directory_uri() . '/images/' . $c_icons_style . '/icons.png)';
$c_retina_icon_url = 'url(' . get_template_directory_uri() . '/images/retina/' . $c_icons_style . '/icons.png)';


$c_icons_opacity = dt_style_options_get_opacity( of_get_option( 'main-icons_opacity', 70 ) );
?>

/* Header icons */
.contact-block span:before {
	background-image: <?php echo $h_icon_url; ?>;
	opacity: <?php echo $h_icons_opacity; ?>;	
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=<?php echo of_get_option( 'main-icons_opacity', 70 ); ?>)" !important;
	filter: alpha(opacity=<?php echo of_get_option( 'main-icons_opacity', 70 ); ?>) !important;
}

/* Content icons */
.ico-twit:before,
.entry-meta .ico-link:before,
.ico-link.categories:before,
.ico-link.tags:before,
.categ i,
#header .contact-block span:before
{
	background-image: <?php echo $c_icon_url; ?>;
	opacity: <?php echo $c_icons_opacity; ?>;
}

/* Retina variant */
@media
only screen and (-webkit-min-device-pixel-ratio: 2),
only screen and (   min--moz-device-pixel-ratio: 2),
only screen and (     -o-min-device-pixel-ratio: 2/1),
only screen and (        min-device-pixel-ratio: 2),
only screen and (                min-resolution: 192dpi),
only screen and (                min-resolution: 2dppx)
{
	.contact-block span:before {
		background-image: <?php echo $h_retina_icon_url; ?>;
		opacity: <?php echo $h_icons_opacity; ?>;
	}
	
	.ico-twit:before,
	.entry-meta .ico-link:before,
	.ico-link.categories:before,
	.ico-link.tags:before,
	.categ i,
	#header .contact-block span:before
	{

		background-image: <?php echo $c_retina_icon_url; ?>;
		opacity: <?php echo $c_icons_opacity; ?>;
	}
}

	
	/* background parallax position */
	#parallax {
		position: <?php echo (of_get_option('mr_parallax-fixed')?'fixed':'absolute'); ?> !important;
	}

	/* background footer baground */
	#footer {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('footer-bg_image', 'none'),
			of_get_option('footer-bg_custom'),
			of_get_option('footer-bg_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('footer-bg_horizontal_pos'),
			of_get_option('footer-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('footer-bg_repeat'); ?>;
		background-color: <?php echo dt_style_options_get_rgba_from_hex_color(array(),
			of_get_option('footer-bg_color'),
			of_get_option('footer-bg_opacity')
		); ?> !important;
	}
	#ie7 #footer,
	#ie8 #footer {
		background-color: <?php echo of_get_option('footer-bg_color'); ?>;
	}
	
	/* background footer bottom line bg */
	#bottom {
		background-image: <?php $image = dt_style_options_get_image(
			array(),
			of_get_option('bottom_line-bg_image', 'none'),
			of_get_option('bottom_line-bg_custom'),
			of_get_option('bottom_line-bg_upload')
		); echo $image;
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('bottom_line-bg_horizontal_pos'),
			of_get_option('bottom_line-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('bottom_line-bg_repeat'); ?>;
		background-color: <?php echo dt_style_options_get_rgba_from_hex_color(
			array(),
			of_get_option('bottom_line-bg_color'),
			of_get_option('bottom_line-bg_opacity')
		); ?> !important;
		
		-ms-filter: "<?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('bottom_line-bg_color'),
			of_get_option('bottom_line-bg_opacity')
		); ?>";

		filter: <?php echo dt_style_options_get_rgba_from_hex_color_for_ie(
			array(),
			of_get_option('bottom_line-bg_color'),
			of_get_option('bottom_line-bg_opacity')
		); ?>;
	}	

	/* background footer wide divider */
	
	<?php if( of_get_option('divs_and_heads-footer_wide_divider_hide_if_no_footer') ): ?>
		.line-footer.dt-no-bg-atall {
			background-image: none !important;
		}
	<?php endif; ?>
	
	/* background footer narrow divider */
	#footer .post, #footer ul.categories li/*, #footer .custom-menu li*/ {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('divs_and_heads-footer_narrow_divider', 'none'),
			of_get_option('divs_and_heads-footer_narrow_divider_custom'),
			of_get_option('divs_and_heads-footer_narrow_divider_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position( 'top', 'left' ); ?>
		background-repeat: <?php echo of_get_option('divs_and_heads-footer_narrow_divider_repeatx')?'repeat-x':'no-repeat'; ?>;
	}
	
<?php
$color = dt_style_options_get_rgba_from_hex_color(
	array(),
	of_get_option('widgetcodes_footer-bg_color'),
	of_get_option('widgetcodes_footer-bg_opacity')
);
$ie_color = dt_style_options_get_rgba_from_hex_color_for_ie(
	array(),
	of_get_option('widgetcodes_footer-bg_color'),
	of_get_option('widgetcodes_footer-bg_opacity')
);
?>

	/* background footer widgets/shortcodes bg */
	#footer #wp-calendar td, #footer #calendar_wrap, #footer #wp-calendar caption, #footer .reviews-t, #footer .partner-bg, #footer .custom-menu > li, .twit .reviews-t, #footer .loading-image, #footer .wp-caption-text {
		background-color: <?php echo $color; ?> !important;
	}

	/* for ie7 */
	#ie7 #footer #wp-calendar td, #ie7 #footer #calendar_wrap, #ie7 #footer #wp-calendar caption, #ie7 #footer .reviews-t, #ie7 #footer .partner-bg, #ie7 #footer .custom-menu > li, #ie7 #footer .twit .reviews-t, #ie7 #footer .loading-image {
		filter: <?php echo $ie_color; ?>;
	}

	/* for ie8 */
	#ie8 #footer #wp-calendar td, #ie8 #footer #calendar_wrap, #ie8 #footer #wp-calendar caption, #ie8 #footer .reviews-t, #ie8 #footer .partner-bg, #ie8 #footer .custom-menu > li, #ie8 .twit .reviews-t, #ie8 #footer .loading-image{
		-ms-filter: "<?php echo $ie_color; ?>"; 
	}

	#footer .reviews-b {
		border-top: 12px solid <?php echo $color; ?> !important;
	}
	
<?php
$color = of_get_option( 'fonts_content-topline_color', '#00b8c2' );
?>
   /* top line */ 
	.right-top a,
	.right-top li
	{ 
		color: <?php echo $color; ?> !important;
	}
	
	.contact-block span,
	.not-responsive .contact-block span{
		color: <?php echo $color; ?> !important;
	}
	
		
<?php
$color = of_get_option( 'fonts_content-secondary_color', '#00b8c2' );
?>
	/* fonts content secondary color */
	.author-position,
	a,
	span.tooltip,
	.widget .ico-link.comments,
	.blog-posts .ico-link.comments,
	.mid-gray,
	.panel-wrapper .blue-date,
	p.autor,
	p.autor a,
	.goto-post span,
	.entry-meta .ico-link,
	.ico-link a,
	.entry-meta .ico-link.comments,
	.autor-head,
	.comment-meta span,
	#comments .comment-meta a,
	#form-holder .do-clear,
	.c-clear,
	.price,
	.full-left a,
	.ico-link.tags,
	.full-left .ico-link.categories,
	.ico-twit,
	.folio-category a
	{
		color: <?php echo $color; ?>
	}
	.widget-info h3 a.head {
		color: <?php echo $color; ?> !important
	}
	.custom-menu > li.current-menu-item > a,
	.custom-menu > li > ul > li.current-menu-item > a,
	.custom-menu > li > ul > li > ul>  li.current-menu-item > a,
	.custom-menu li a:hover
	{
		color: <?php echo $color; ?> !important;
	}
	.custom-menu li a:hover:after,
	.custom-menu > li.current-menu-item > a:after,
	.custom-menu > li > ul > li.current-menu-item > a:after,
	.custom-menu > li > ul > li > ul > li.current-menu-item a:after
	{
		border-left: solid 3px <?php echo $color; ?> !important;
		
	}
	#aside .goto-post span .dot,
	.folio-category .dot,
	.comment-meta .dot
	{
		background-color: <?php echo $color; ?> !important;
	}
	
	.comment-meta,
	.ico-link.categories a
	{
		color: <?php echo $color; ?> !important;
	}

	span.tooltip {
		border-bottom: 1px dashed <?php echo $color; ?> !important;
	}
	
<?php
/*
 *	Main menu
 */

 /* first level */
$font_family = str_replace('_', ' ', of_get_option('menu-first_font', 'Arial'));

$font_size = intval(of_get_option('menu-first_font_size', 14));
if( $font_size <= 0 ) { $font_size = 14; }

$font_style = of_get_option('menu-first_font_italic', 0) ? 'italic' : 'normal';
$font_weight = of_get_option('menu-first_font_bold', 0) ? 'bold' : 'normal';

$text_transform = of_get_option('menu-first_font_upper', 0) ? 'uppercase' : 'none';
$first_color = of_get_option('menu-first_font_color', '#474747');
if( !$first_color ) { $first_color = 'inherit'; }

$first_color_act = of_get_option('menu-first_font_color_active', '#00B8C2');
if( !$first_color_act ) { $first_color_act = 'inherit'; }

$line_color = of_get_option('menu-first_hoover_line_color', '#00B8C2');
if( !$line_color ) { $line_color = 'inherit'; }

$hoover_color_rgb = of_get_option('menu-first_hoover_color', '#000000');
$hoover_color_rgba = dt_style_options_get_rgba_from_hex_color( array(),
	$hoover_color_rgb,
	of_get_option('menu-first_hoover_opacity', 6)
);


$menu_line_color_rgb = of_get_option('menu-line_color', '#000000');
$menu_line_color_rgba = dt_style_options_get_rgba_from_hex_color( array(),
	$menu_line_color_rgb,
	of_get_option('menu-line_opacity', 20)
);

/* second level */
$second_color = of_get_option('menu-second_font_color', '#ffffff');
$second_color_hoover = of_get_option('menu-second_font_color_active', '#474747');

$second_bg_color_rgb = of_get_option('menu-second_bg_color', '#000000');
$second_bg_color_rgba = dt_style_options_get_rgba_from_hex_color( array(),
	$second_bg_color_rgb,
	of_get_option('menu-second_bg_opacity', 80)
);
$second_bg_color_rgb_ie = dt_style_options_get_rgba_from_hex_color_for_ie( array(),
	$second_bg_color_rgb,
	of_get_option('menu-second_bg_opacity', 80)
);

?>

/* fonts main menu links color and shadow */
	
	/* menu item FIRST level */
	ul#nav li a.dt-depth-1 {
		font-family: <?php echo $font_family; ?> !important;
		font-size: <?php echo $font_size; ?>px !important;
		font-style: <?php echo $font_style; ?> !important;
		font-weight: <?php echo $font_weight; ?> !important;
		text-transform: <?php echo $text_transform; ?> !important;
		color: <?php echo $first_color; ?> !important;
	}
	
	/* little arrow color */
	
	ul#nav li a span:after {		
		border-top: 3px solid  <?php echo $first_color; ?> !important;
	}
	/* active menu item first level */
	#nav li a.dt-depth-1.act,
	#nav li:hover a.dt-depth-1 {
		color: <?php echo $first_color_act; ?> !important;
	}
	
	/* active little arrow color */
	#nav li a.act span:after, #nav li:hover a span:after {
		
		border-top: 3px solid  <?php echo $first_color_act; ?> !important;
	}

	/* top border and arrow of the first level */

	/* arrow */
	#nav > li:hover > a:after,
	#nav > li.act > a:after {
		
		border-top: 3px solid  <?php echo $line_color; ?> !important;
	}

	/* line */
	#nav > li:hover,
	#nav > li.act {
		border-top: 3px solid <?php echo $line_color; ?> !important;
		background: <?php echo $hoover_color_rgb; ?> !important;
		background: <?php echo $hoover_color_rgba; ?> !important;
	}
	
	<?php if ( of_get_option('menu-line_opacity') < 100 ): ?>
		
		#ie8 #nav > li:hover,
		#ie8 #nav > li.act {
			background-color: transparent !important;
		}
		
	<?php endif; ?>
	
	/* menu bottom line */
	#header {
		border-bottom: 1px solid <?php echo $menu_line_color_rgb; ?>;
		border-bottom: 1px solid <?php echo $menu_line_color_rgba; ?>;
	}
	
	<?php if ( of_get_option('menu-line_opacity') < 100 ): ?>
		
		#ie8 #header {			
			border-bottom: none;
		}
		
	<?php endif; ?>
	/* main menu SECOND level and friends */

	/* text color */
	#nav li div ul li a,
	#nav li div ul li div ul li a,
	.widget-info,
	.widget-info.widget,
	.nivo-prevNav span.a-l,
	.nivo-nextNav span.a-l,
	.jfancytileBack span.a-l,
	.jfancytileForward span.a-l,
	.basic .accord > a i:after,
	.navig-nivo a.prev span.a-l,
	.navig-nivo a.next span.a-l,
	#carousel-left span.a-l,
	#carousel-right span.a-l,
	.arrow span.a-l,
	.flex-prev span.a-l,
	.flex-next span.a-l,
	.toggle a.question i:after,
	.fs-controls .a-l,
	.widget-info .sd-title
	{
		color: <?php echo $second_color; ?> !important;
	}
	
	/* secondary level little arrow color */
	#nav li div ul li span:after {
		border-left: 3px solid  <?php echo $second_color; ?> !important;
	}
	
	/* hover color */
	#nav li div ul li a.act,
	#nav > li div ul li:hover > a,
	.nivo-directionNav span.a-r,
	.widget-info .head,
	.widget-info h3 a.head,
	.basic .accord:hover > a i:after,
	.basic .accord.selected > a i:after,
	.navig-nivo a span.a-r,
	#carousel-left span.a-r,
	#carousel-right span.a-r,
	.arrow span.a-r,
	.flex-prev span.a-r,
	.flex-next span.a-r,
	.toggle .question:hover i:after,
	.toggle .question.act i:after,
	.widget-info .head-capt,
	.widget-info .head,
	.widget-info .hide-me,
	.widget-info .folio-category a,
	.fs-controls .a-r
	{
		color: <?php echo $second_color_hoover; ?> !important;
	}
	
	.widget-info .folio-category .dot {
		background-color: <?php echo $second_color_hoover; ?> !important;
	}
	
	#nav li div ul li:hover {
		border-left: 3px solid <?php echo $second_color_hoover; ?> !important;
	}


	#nav > li > div > ul > li:hover > a:after,
	#nav li div ul li div ul li:hover > a:after {
		border-color: transparent transparent transparent <?php echo $second_color_hoover; ?>;
	}
	ul#nav li div ul li.act span:after, ul#nav li div ul li:hover span:after {
		border-left: 3px solid  <?php echo $second_color_hoover; ?> !important;
	}
	
	/* bg color */
	#nav li div ul li,
	.widget-info,
	.navig-nivo.onebyone a,
	.basic .accord > a i,
	.navig-nivo a,
	.slider-shortcode .flex-direction-nav li a,
	.toggle a.question i,
	.go-next,
	.go-prev {
		background: <?php echo $second_bg_color_rgb; ?> !important;
		background: <?php echo $second_bg_color_rgba; ?> !important;
	}
	#ie8 .widget-info,
	#ie8 .navig-nivo a {
		background: none !important;
		-ms-filter: "<?php echo $second_bg_color_rgb_ie; ?>" !important; 
	}

 
<?php
/*
 *	Buttons
 */

$btn_bg_color = of_get_option( 'buttons-bg_color', '#01c9d6' );
$btn_txt_color = of_get_option( 'buttons-font_color', '#ffffff' );
$btn_txt_shadow = dt_get_shadow_color( of_get_option( 'buttons-font_shadow', '#0096a0' ) );

$act_btn_bg_color = of_get_option( 'buttons-active_bg_color', '#c1c1c1' );
$act_btn_txt_color = of_get_option( 'buttons-active_font_color', '#ffffff' );
$act_btn_txt_shadow = dt_get_shadow_color( of_get_option( 'buttons-active_font_shadow', '#969696' ) );
?>	
/* Buttons */

	/* button normal */
	#footer .but-wrap,
	.but-wrap,
	.mobile-menu .but-wrap, .menu-container li > span
	{
		background-color: <?php echo $btn_bg_color; ?> !important;
	}
	.current-ico
	{
		color: <?php echo $btn_bg_color; ?>;
	}
	
	/* text color and shadow */
	#footer .but-wrap .button,
	.but-wrap .button,
	.widget-info a.details,
	.menu-container > li > span:after
	{
		color: <?php echo $btn_txt_color; ?> !important;
		text-shadow: <?php echo $btn_txt_shadow; ?> !important;
	}
	
	#main-menu .button.big span i, #mobile-menu .button.big span i.line-one, #mobile-menu .button.big span i.line-two, #mobile-menu .button.big span i.line-three, #mobile-menu .button.big span i.line-four
	{
		background-color: <?php echo $btn_txt_color; ?> !important;
	}
	
	/* button active */
	/* active bg */
/*	#footer .but-wrap,
	.but-wrap:hover,
	.widget-info .but-wrap:hover
	{
		background-color: <?php echo $act_btn_bg_color; ?>;
	}
*/	
	/* active text color and shadow */
	#footer .but-wrap a.button.act, 
	.but-wrap a.button.act,
	.widget-info .but-wrap a.details.act, 
	.navigation .paginator li.act .but-wrap
	{
		background-color: <?php echo $act_btn_bg_color; ?>;
		color: <?php echo $act_btn_txt_color; ?> !important;
		text-shadow: <?php echo $act_btn_txt_shadow; ?> !important;
	}
	.navigation .paginator li.act .but-wrap,
	.navig-category .but-wrap.act
	{
		background-color: <?php echo $act_btn_bg_color; ?>  !important;
	}
	.navigation .paginator li.act .but-wrap .button,
	.navig-category .but-wrap.act .button
	{
		color: <?php echo $act_btn_txt_color; ?> !important;
		text-shadow: <?php echo $act_btn_txt_shadow; ?> !important;
	}
	
	
<?php $color = of_get_option('fonts_footer-primary_color') . ' !important;'; ?>

	/* footer primary colors */
	#footer .text-photo,
	#footer .head,
	#footer .custom-menu li a,
	#footer .panel .panel-wrapper a,
	#footer .reviews-t,
	#footer .categories a,
	#footer .post a,
	#footer a.do-clear,
	#footer .c-clear,
	#footer .dt_captcha, .foot-cont
	{			
		color: <?php echo $color; ?>
	}
	#footer .custom-menu li a:after
	{
		border-left: solid 3px <?php echo $color; ?> !important;
		
	}
	#footer .SliderNamePrev span.a-l-s,
	#footer .SliderNamePrev2 span.a-l-s,
	#footer .SliderNameNext span.a-l-s,
	#footer .SliderNameNext2 span.a-l-s {
		color: <?php echo $color; ?> !important; 
	}

<?php
$color = of_get_option('fonts_footer-secondary_color') . ' !important;';
$shadow_color = dt_get_shadow_color( of_get_option('fonts_footer-secondary_shadow_color') );
?>

	#footer .author-position,
	#footer .mid-gray,
	#footer .panel-wrapper .blue-date,
	#footer p.autor,
	#footer p.autor a,
	#footer .goto-post span,
	#footer a,
	#footer .goto-post span,
	.foot-cont p.autor,
	.foot-cont p.autor a,
	 #footer #wp-calendar tfoot td a
	{
		color: <?php echo $color; ?>
	}
	#footer .custom-menu > li.current-menu-item > a,
	#footer .custom-menu > li > ul > li.current-menu-item > a,
	#footer .custom-menu > li > ul > li > ul > li.current-menu-item > a,
	#footer .custom-menu li a:hover
	{
		color: <?php echo $color; ?> !important;
	}
	#footer .custom-menu li a:hover:after,
	#footer .custom-menu > li.current-menu-item > a:after,
	#footer .custom-menu > li > ul > li.current-menu-item > a:after,
	#footer .custom-menu > li > ul > li > ul > li.current-menu-item > a:after
	{
		border-left: solid 3px <?php echo $color; ?> !important;
		
	}
	#footer .goto-post span .dot {
		background-color: <?php echo $color; ?>
	}


<?php
$color = of_get_option('fonts_content-bottomline_color') . ' !important;';
$shadow_color = dt_get_shadow_color( of_get_option('fonts_content-bottomline_shadow_color') );
?>
   /* bottom line */ 
	#footer .bottom-cont span, #footer .bottom-cont a { 
		color: <?php echo $color; ?>
	}
	
<?php 
$headers = array( 'h1', 'h2', 'h3', 'h4', 'h5', 'h6' );
foreach( $headers as $header ):
	$font_size = of_get_option('fonts-headers_size_' . $header);
?>
	/* font size */
	<?php echo $header; ?>,
	#container > <?php echo $header; ?>
	{
		font-size: <?php echo $font_size; ?>px !important;
	}
	
	<?php if( 'h3' == $header ): ?>
		#carousel .caption-head,
		#ps-slider .ps-head,
		.gallery .textwidget.text .head,
		.gallery .textwidget.text .hide-me, .header,
		.fs-title,
		.message-box-title
		{
			font-size: <?php echo $font_size; ?>px !important;
		}
	<?php endif; ?>

	<?php if( 'h2' == $header ): ?>
		#fancytile-slide .caption-head,
		#slider .caption-head,
		#form-holder .header
		{ 
			font-size: <?php echo $font_size; ?>px !important;
		}
	<?php endif; ?>
		
<?php endforeach; ?>
		
#slide .text-capt,
#slide .ps-cont
{
	color: #fff !important;
}

	<?php
	$content_color = of_get_option('fonts_content-headers_color');
	$content_shadow_color = dt_get_shadow_color( of_get_option('fonts_content-headers_shadow_color') );

	$footer_color = of_get_option('fonts_footer-headers_bottom_color');
	$footer_shadow_color = dt_get_shadow_color( of_get_option('fonts_footer-headers_shadow_color') );
	?> 

h1,
h1 a,
h2,
h2 a,
h3,
h3 a,
h4,
h4 a,
h5,
h5 a,
h6,
h6 a,
.double-header .first-head,
.header,
#form-holder .header,
a.next span.a-l-s,
a.prev span.a-l-s,
.textwidget.text .info a.head,
SliderNamePrev span.a-l-s,
.SliderNamePrev2 span.a-l-s,
.SliderNameNext span.a-l-s,
.SliderNameNext2 span.a-l-s

{
	color: <?php echo $content_color; ?> !important;
}

.foot-cont .header,
#footer a.next span.a-l-s,
#footer a.prev span.a-l-s,
#footer .SliderNamePrev span.a-l-s,
#footer .SliderNamePrev2 span.a-l-s,
#footer .SliderNameNext span.a-l-s,
#footer .SliderNameNext2 span.a-l-s
{
	color: <?php echo $footer_color; ?> !important;
}

/* accordion, toggle, tabs */ 
/*
.basic .accord:hover > a i:after, .basic .accord.selected > a i:after, .accord a.selected, .accord:hover > a, .nav-tab a, .toggle .question:hover, .toggle .question:hover i:after, .toggle .question.act i:after, .text-content .head, .toggle .question.act {
	color: <?php echo of_get_option('fonts_content-secondary_color'); ?> !important;
}
*/

.accord a.selected, #wp-calendar tfoot td a, .accord:hover > a, .text-content .head, .toggle .question.act, ul.nav-tab li:hover > a, .nav-tab a.current {
	color: <?php echo of_get_option('fonts_content-secondary_color'); ?> !important;
}

.accord a, .nav-tab a, .toggle .question {
	color: <?php echo of_get_option('fonts_content-primary_color'); ?> !important; 
}
.goto-post span .dot {
	background-color: <?php echo of_get_option('fonts_content-secondary_color'); ?>;
}

.SliderNamePrev span.a-l-s,
.SliderNamePrev2 span.a-l-s,
.SliderNameNext span.a-l-s,
.SliderNameNext2 span.a-l-s {
	color: <?php echo of_get_option('fonts_content-primary_color'); ?> !important; 
}
/* mobile logo */

@media only screen and (max-width: 1149px) {

	<?php if( of_get_option('main_bg-bg_mobile_hide') ): ?>
	
	body {
		background-image: none !important;
	}
	
	<?php endif; ?>

}

@media only screen and (max-width: 990px) {
	
	#home-bg, #bg {
		background-image: none !important;
	}
	
	
	/* background headers homepage background */
	.not-responsive #home-bg {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('header_homepage-bg_image', 'none'),
			of_get_option('header_homepage-bg_custom'),
			of_get_option('header_homepage-bg_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('header_homepage-bg_horizontal_pos'),
			of_get_option('header_homepage-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('header_homepage-bg_repeat'); ?>;
	}

	/* background headers content background */
	.not-responsive #bg {
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('header_content-bg_image', 'none'),
			of_get_option('header_content-bg_custom'),
			of_get_option('header_content-bg_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position(
			of_get_option('header_content-bg_horizontal_pos'),
			of_get_option('header_content-bg_vertical_pos')
		); ?>
		background-repeat: <?php echo of_get_option('header_content-bg_repeat'); ?>;
	}
	
	.contact-block span{
		color: <?php echo of_get_option('fonts_content-primary_color'); ?> !important; 
	}
	
	
	.dt-hide-in-mobile {
		display: none !important;
	}
	.not-responsive .dt-hide-in-mobile {
		display: block !important;
	}
	<?php if( of_get_option('divs_and_heads-footer_wide_divider_hide_if_no_footer') ): ?>
	
	.line-footer.dt-no-bg {
		background-image: none !important;
	}
	
	<?php endif; ?>
	
}