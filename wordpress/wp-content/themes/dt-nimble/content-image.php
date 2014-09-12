<?php
global $post;
$first_class = '';
if( 1 === dt_storage('post_is_first') ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$title = get_the_title(); 
$comments = '<a href="#" title="" class="ico-link comments" onclick="return false;">%COUNT%</a>'; 
if( !post_password_required($post->ID) ) {
    $title = '<a href="'.get_permalink().'">'.$title.'</a>';
    $comments ='<span class="ico-link comments"><a href="%HREF%" title="">%COUNT%</a></span>'; 
}
?>
<div class="item-blog<?php echo $first_class; ?>">
    <h2><?php echo $title; ?></h2>
    <div class="entry-meta">

        <?php
        dt_get_date_link( array('class' => 'ico-link date', 'wrap' => '<span class="%CLASS%"><span>%DATE%</span></span>') );
        dt_get_author_link( array('class' => 'ico-link author', 'wrap' => '<span %CLASS%><a %HREF%>%AUTHOR%</a></span>') );
        dt_get_taxonomy_link( 'category', '<span class="ico-link categories">%CAT_LIST%</span>' );
        dt_get_comments_link( $comments, array( 'no_coments' => '' ) );
        ?>

    </div>
    
<?php
    if( !post_password_required($post->ID) ) {
		
		// thumbnail
		if ( has_post_thumbnail() ) {
			$img_id = get_post_thumbnail_id();
			
			// get alt
			$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			if ( !$img_alt ) { $img_alt = get_the_title(); }
			
			$t_w = 710;
			
			$thumb_args = array(
				'alt'			=> $img_alt,
				'class'         => 'alignleft text img-posts',
				'href'          => get_permalink(),
				'img_meta'		=> dt_get_thumb_meta( dt_storage( 'thumbs_array' ) )
			);
			
			if ( $thumb_args['img_meta'][1] > $t_w ) {
				$thumb_args['thumb_opts'] = array( 'w' => $t_w );
			}
			
			dt_get_thumb_img( $thumb_args );
		}
		
        dt_the_content();
        dt_details_link();
        dt_edit_link();
    }else {
        echo get_the_password_form(); 
    }
?>

</div>