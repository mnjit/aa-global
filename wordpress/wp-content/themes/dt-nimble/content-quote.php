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
        dt_get_date_link( array('class' => 'ico-link date', 'wrap' => '<span class="%CLASS%">%DATE%</span>') );
        dt_get_author_link( array('class' => 'ico-link author', 'wrap' => '<span %CLASS%><a %HREF%>%AUTHOR%</a></span>') );
        dt_get_taxonomy_link( 'category', '<span class="ico-link categories">%CAT_LIST%</span>' );
        dt_get_comments_link( $comments, array( 'no_coments' => '' ) );
        ?>

    </div>
    
<?php
    if( !post_password_required($post->ID) ) {
        if( 'dt_team' !== $post->post_type && 'dt_benefits' !== $post->post_type ) {
            dt_get_thumb_img( array(
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
