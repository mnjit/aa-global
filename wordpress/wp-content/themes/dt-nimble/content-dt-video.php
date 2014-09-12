<?php
$pg_opts = dt_storage('page_data');
$add_data = dt_storage('add_data');
$vid_opts = get_post_meta( get_the_ID(), '_dt_video_options', true);

$w_str = $h_str = '';
$custom = ' onclick="return false;"';

if( !empty($vid_opts['video_link']) && !post_password_required() ) {
    $video_html = dt_get_embed( $vid_opts['video_link'], ($vid_opts['width']?$vid_opts['width']:null), ($vid_opts['height']?$vid_opts['height']:null), false );
    
    preg_match('/width=[\"\'\s](\d+?)[\"\'\s]/', $video_html, $width);
    preg_match('/height=[\"\'\s](\d+?)[\"\'\s]/', $video_html, $height);
    
    if( isset($width[1]) )
        $w_str = ", width: " . intval($width[1]);

    if( isset($height[1]) )
        $h_str = ", height: " . intval($height[1]+5);

    $custom = ' onclick="return hs.htmlExpand(this, { captionEval: null, contentId: \'dt-content-id-'.get_the_ID().'\''.$w_str.$h_str.' });"';
}

$page_data = dt_storage('page_data');
if( $page_data && isset($page_data['page_options']) ) {
    $page_opts = $page_data['page_options'];
}else {
    $page_opts = array();
}

// pass protected

$pass_form = '';
$img_custom = ' onclick="jQuery(this).parents(\'.dt-hs-container\').find(\'.textwidget-photo:first a.photo\').click(); return false;"';
if( post_password_required() ) {
    $pass_form = get_the_password_form();
    $title_tag = '<h3><span class="%s">%s</span></h3>';
}else {
    $title_tag = '<h3><a class="%s" href="#"'.$img_custom.'>%s</a></h3>';
}

$title = sprintf( $title_tag, dt_portfolio_classes( $add_data['init_layout'], 'head', false ), get_the_title() );

// end pass protected
?>
<div class="dt-hs-container dt-video-item <?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); ?>">
        <?php
		
		if( !post_password_required() ) {
			$caption_hs = '<div class="highslide-caption">';
			$caption_hs .= get_the_excerpt();
			
			if ( dt_is_page_soc_buttons_enabled('video') && has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id( get_the_ID() );
				$caption_hs .= dt_get_like_window( array(
					'img' => urlencode( current( wp_get_attachment_image_src( $thumb_id, 'thumbnail' ) ) ),
					'full' => urlencode( current( wp_get_attachment_image_src( $thumb_id, 'full' ) ) ),
					'src' => urlencode(get_permalink(get_the_ID()))
				), false );
			}
					
			$caption_hs .= '</div>';
		}else {
			$caption_hs = '';
		}
		
		$img_id = get_post_thumbnail_id();
		
		// get alt
		$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		if ( !$img_alt ) { $img_alt = get_the_title(); }
		
        $img = dt_get_thumb_img( array(
			'alt'			=> $img_alt,
            'class'         => 'photo',
            'href'          => '#',
            'custom'        => $custom,
            'use_noimage'   => true,
            'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %ALT% %SRC% %SIZE%/></a>'. $caption_hs. '%P_FORM%</div>', false
        );
		
		$img = str_replace( '%P_FORM%', $pass_form, $img );
		
        echo $img;
        ?>

    <?php if( !isset($page_opts['show_meta']) || (isset($page_opts['show_meta']) && 'on' == $page_opts['show_meta']) ): ?>    

    <div class="widget-info">
    <?php echo $img; ?>
	    <div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'info' ); ?>">
            
			<?php echo $title; ?>

			<?php if( isset($pg_opts['page_options']) && (!isset($pg_opts['page_options']['show_category']) || 'on' == $pg_opts['page_options']['show_category']) ): ?>
			
				<ul class="folio-category">
				<?php echo get_the_term_list( get_the_ID(), 'dt_video_category', '<li>', '<div class="dot"></div></li><li>', '</li>' ); ?>
				</ul>
			
			<?php endif; ?>
			
			<?php if ( ! post_password_required() ): ?>
			<?php
			dt_the_content();
			if ( 'list' == $pg_opts['layout'] ) { dt_edit_link( 'Edit', null, 'button' ); }
			?>
			<?php endif; ?>
			
		</div>
    </div>

    <?php endif; ?>
	
	<?php if( !post_password_required() ): ?>
    <div class="highslide-maincontent" id="dt-content-id-<?php the_ID(); ?>"><?php echo $video_html; ?></div>
	<?php endif; ?>
	
</div>
