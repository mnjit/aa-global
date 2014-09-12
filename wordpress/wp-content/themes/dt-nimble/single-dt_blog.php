<div class="entry-meta">

<?php
dt_get_date_link( array('class' => 'ico-link date', 'wrap' => '<span class="%CLASS%"><span>%DATE%</span></span>') );
dt_get_author_link( array('class' => 'ico-link author', 'wrap' => '<span %CLASS%><a %HREF%>%AUTHOR%</a></span>') );
dt_get_taxonomy_link( 'category', '<span class="ico-link categories">%CAT_LIST%</span>' );
dt_get_comments_link( '<span class="ico-link comments"><a href="%HREF%" class="">%COUNT%</a></span>', array( 'no_coments' => '' ) );
?>
</div>

<?php
global $post;

// thumbnail
$thumb_id = get_post_thumbnail_id( $post->ID );
$big = wp_get_attachment_image_src( $thumb_id, 'full' );
$post_opts = get_post_meta( $post->ID, '_dt_meta_post_options', true );
if( $big && (!isset($post_opts['hide_thumb']) || !$post_opts['hide_thumb']) ) {
    $big[3] = image_hwstring( $big[1], $big[2] );
	
	$alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
	if ( !$alt ) { $alt = get_the_title(); }
	
	$thmb_args = array( 'w' => 210, 'h' => 210 );
	$classes = array( 'alignleft', 'highslide' );
	$thumb_pattern = '<a class="%6$s" href="%1$s"  onclick="return hs.expand(this)"><img src="%2$s" %3$s alt="%5$s" title="%4$s" /></a>';
	if ( 'image' == get_post_format() ) {
		$t_w = 710;
		$thmb_args = array( 'w' => $t_w );
		$classes[] = 'img-posts';
		if ( $big[1] <= $t_w ) {
			$classes = array( 'alignleft' );
			$thmb_args = array();
			$thumb_pattern = '<span class="%6$s"><img src="%2$s" %3$s alt="%5$s" title="%4$s" /></span>';
		}
	}
	
	$classes = implode( ' ', $classes );
	$thumb = dt_get_resized_img( $big, $thmb_args );
	
	printf(
		$thumb_pattern,
        $big[0], $thumb[0], $thumb[3], get_the_title(), $alt, $classes
    );
}
the_content();
wp_link_pages();

dt_get_taxonomy_link( 'post_tag', '<p><span class="ico-link tags">%CAT_LIST%</span></p>' );
if( dt_is_page_soc_buttons_enabled('post') ) {
	dt_get_like_buttons( get_the_ID() );
}
?>

<?php if( of_get_option('misc-show_author_details') ): ?>

<p class="gap"></p>
<p class="hr hr-narrow gap-small"></p>
<div class="about-autor full-width">
    <?php echo str_replace( "class='", "class='alignleft ", get_avatar( get_the_author_meta('ID'), 80 ) ); ?>
<p class="autor-head"><?php printf(
    __('This article was written by %s', LANGUAGE_ZONE),
    get_the_author_meta('nickname')
); ?></p>
<p><?php echo get_the_author_meta('description'); ?></p>

</div>

<?php endif; ?>

<p class="gap"></p>

<?php comments_template(); ?>