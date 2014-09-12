<?php
global $post;
$pg_opts = dt_storage('page_data');
$add_data = dt_storage('add_data');
?>
<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); ?>">

	<?php
	$caption = get_the_excerpt();
	$caption_hs = '<div class="highslide-caption">';
	$caption_hs .= $caption;
	
	if( dt_is_page_soc_buttons_enabled('photo') ) {
		$caption_hs .= dt_get_like_window( array(
			'img' => urlencode( current( wp_get_attachment_image_src( get_the_ID(), 'thumbnail' ) ) ),
			'full'	=> urlencode( current( wp_get_attachment_image_src( get_the_ID(), 'full' ) ) ),
			'src' => urlencode(get_permalink(get_the_ID()))
		), false );
	}
	
	$caption_hs .= '</div>';
	$img = dt_get_thumb_img( array(
		'class'         => 'photo highslide',
		'alt'			=> get_post_meta( $post->ID, '_wp_attachment_image_alt', true ),
		'img_meta'      => wp_get_attachment_image_src( $post->ID, 'full' ),
		'custom'        => ' onclick="return hs.expand(this, galleryOptions)"',//, {transitions: [\'expand\', \'crossfade\'], captionEval: null});"',//
		'title'         => strip_tags($caption),
		'thumb_opts'    => array('w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
		),
		'<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %ALT% %SRC% %IMG_CLASS% %SIZE%/></a>'.$caption_hs.'</div>', false
	);
	echo $img;
	?>
</div>