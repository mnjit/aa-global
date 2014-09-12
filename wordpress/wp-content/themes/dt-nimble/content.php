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
$taxonomy_posttype = array(
	'post'			=> 'category',
	'dt_portfolio'	=> 'dt_portfolio_category',
	'dt_gallery'	=> 'dt_gallery_category'
);
$taxonomy = isset( $taxonomy_posttype[ get_post_type() ] ) ? $taxonomy_posttype[ get_post_type() ] : false;
?>
<div class="item-blog<?php echo $first_class; ?>">
    <h2><?php echo $title; ?></h2>
    <div class="entry-meta">

        <?php
        dt_get_date_link( array('class' => 'ico-link date', 'wrap' => '<span class="%CLASS%"><span>%DATE%</span></span>') );
        dt_get_author_link( array('class' => 'ico-link author', 'wrap' => '<span %CLASS%><a %HREF%>%AUTHOR%</a></span>') );
        dt_get_taxonomy_link( $taxonomy, '<span class="ico-link categories">%CAT_LIST%</span>' );
        dt_get_comments_link( $comments, array( 'no_coments' => '' ) );
        ?>

    </div>
    
<?php
    if( !post_password_required($post->ID) ) {
        if( has_post_thumbnail() && 'dt_team' !== $post->post_type && 'dt_benefits' !== $post->post_type ) {
            $img_id = get_post_thumbnail_id( $post->ID );
			
			// get alt
			$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
			if ( !$img_alt ) { $img_alt = get_the_title( $post->ID ); }
			
			dt_get_thumb_img( array(
				'alt'			=> $img_alt,
                'class'         => 'alignleft text',
                'href'          => get_permalink(),
                'thumb_opts'    => array('w' => 210, 'h' => 210)
            ) );
        }
        dt_the_content();
        dt_details_link();
        dt_edit_link();
    }else {
        echo get_the_password_form(); 
    }
?>

</div>