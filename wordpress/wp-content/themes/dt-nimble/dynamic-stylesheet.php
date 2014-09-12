<?php

global $post;
$template = dt_core_get_template_name();

?>

<style type="text/css">

	<?php
	$po = array();
	if ( ! empty( $post ) && ! dt_storage( 'is_index' ) && ! is_archive() ) {
		$po = get_post_meta( $post->ID, '_dt_background_options', true );
	}
	
	$bg_fixed = false;
	if ( empty( $po['enable'] ) ) { 
		$main_bg_img = dt_style_options_get_image(
			array(),
			of_get_option('background-bg_image', 'none'),
			of_get_option('main_bg-bg_custom'),
			of_get_option('main_bg-bg_upload')
		);
		
		$main_bg_pos = dt_style_options_get_bg_position( of_get_option('main_bg-bg_horizontal_pos'), of_get_option('main_bg-bg_vertical_pos') );
		$main_bg_color = of_get_option('main_bg-bg_color');
		$bg_repeat = of_get_option('main_bg-bg_repeat');
	} else {
		if ( ! empty( $po['bg_image'] ) ) {
			$main_bg_img = 'url("' . $po['bg_image'] . '")'; 
		} else {
			$main_bg_img = 'none';
		}
		$main_bg_img .= ' !important;';
		
		$main_bg_pos = dt_style_options_get_bg_position( isset( $po['h_pos'] ) ? $po['h_pos'] : 'center', isset( $po['v_pos']) ? $po['v_pos'] : 'center' );
		$main_bg_color = ! empty( $po['color'] ) ? $po['color'] : '#000';
		$bg_repeat = isset( $po['repeat'] ) ? $po['repeat'] : 'repeat';
		if ( ! empty( $po['fixed'] ) ) { $bg_fixed = true; }
	}
	?>
	
	/* appearance background font-family content-text-color content-text-shadow-color */    
	body {
		background-image: <?php echo $main_bg_img; ?>
		background-position: <?php echo $main_bg_pos; ?>

		background-color: <?php echo $main_bg_color; ?>;
		background-repeat: <?php
		if ( 'full-screen' != $bg_repeat ):
			echo $bg_repeat;
		else : ?>no-repeat;
			-webkit-background-size: cover !important;
			-moz-background-size: cover !important;
			-o-background-size: cover !important;
			background-size: cover !important;
		<?php endif; ?>;
		
		<?php if( of_get_option('main_bg-bg_fixed') || 'full-screen' == $bg_repeat || $bg_fixed ): ?>
		background-attachment: fixed !important;
		<?php endif;?>
	}
	
	<?php
	$page_opts = array();
	if ( ! empty( $post ) ) {
		$page_opts = get_post_meta( $post->ID, '_dt_obo_slider_layout_options', true );
	}
	
	if( $page_opts ):
	?>
	
	/* OneByOne slider */
	#header.for-byOne {
		margin-bottom: <?php echo !empty($page_opts['position_top'])?$page_opts['position_top']:0; ?>px !important;
	}
	
	.oneByOne1,
	#banner .oneByOne_item
	{
		height: <?php echo !empty($page_opts['height'])?$page_opts['height']:50; ?>px;
	}
	
	<?php endif; ?>

	/* background footer wide divider */
	.line-footer, .not-responsive .line-footer.dt-no-bg {
		
		<?php
		if( isset($post) ) {
			$f_opts = get_post_meta( $post->ID, '_dt_layout_footer_options', true );
		}else {
			$f_opts = array();
		}

		$show_widgetarea = ( empty($f_opts) || (isset($f_opts['footer']) && 'show' == $f_opts['footer']) );

		if( !( !$show_widgetarea && of_get_option('divs_and_heads-footer_wide_divider_hide_if_no_footer') ) ):
		?>
		
		background-image: <?php echo dt_style_options_get_image(
			array(),
			of_get_option('divs_and_heads-footer_wide_divider', 'none'),
			of_get_option('divs_and_heads-footer_wide_divider_custom'),
			of_get_option('divs_and_heads-footer_wide_divider_upload')
		);
		?>
		background-position: <?php echo dt_style_options_get_bg_position( 'bottom', 'left' ); ?>
		background-repeat: <?php echo of_get_option('divs_and_heads-footer_wide_divider_repeatx')?'repeat-x':'no-repeat'; ?>;
		
		<?php else: ?>
		
		background-image: none !important;
		
		<?php endif; ?>
		
	}

<?php
$show_everywhere = true;
if( in_array($template, array('dt-obo-homepage-blog.php', 'dt-obo-slideshow-fullwidth.php', 'dt-obo-slideshow-sidebar.php')) ) {
	$opts = get_post_meta( $post->ID, '_dt_obo_slider_layout_options', true );
	$show_everywhere = isset($opts['display_on']) && 'everywhere' == $opts['display_on'];
}elseif( in_array($template, array('dt-homepage-blog.php', 'dt-slideshow-fullwidth.php', 'dt-slideshow-sidebar.php')) ) {
	$opts = get_post_meta( $post->ID, '_dt_slider_layout_options', true );
	$show_everywhere = isset($opts['display_on']) && 'everywhere' == $opts['display_on'];
}

if( ! $show_everywhere ):
?>

@media only screen and (max-width: 739px) {
	#slide,
	.navig-nivo,
	#fs-slideshow {
		display: none !important;
	}
	.not-responsive #slide,
	.not-responsive .navig-nivo,
	.not-responsive #fs-slideshow {
		display: block !important;
	}
}

<?php endif; ?>

<?php if ( ! of_get_option( 'misc-static_css', true ) ): ?>

<?php get_template_part( 'static-stylesheet' ); ?>

<?php endif; ?>

</style>
