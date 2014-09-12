<?php
global $post;
$pg_opts = dt_storage( 'page_data' );
if ( isset( $pg_opts['page_options'] ) ) {
	$page_opts = $pg_opts['page_options'];
} else {
	$page_opts = dt_metabox_portfolio_layout_options();
}

$add_data = dt_storage( 'add_data' );

$layout = explode( '-', $add_data['init_layout'] );

if ( isset( $layout[1] ) ) {
    $layout = $layout[1];
} else {
    $layout = 'list';
}

$first_class = '';
if ( ( 1 === dt_storage( 'post_is_first' ) ) && ( 'grid' != $layout ) ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$pass_form = '';
$img_custom = 'onclick="jQuery(this).parents(\'.dt-hs-container\').find(\'.hidden-container a:first\').click(); return false;"';
if ( post_password_required() ) {
    $pass_form = get_the_password_form();
    $title_tag = '<h3><span class="%s">%s</span></h3>';
} else {
    $title_tag = '<h3><a class="%s" href="#"'.$img_custom.'>%s</a></h3>';
}

$type = isset( $add_data['init_layout'] ) ? $add_data['init_layout'] : null;
$title = sprintf( $title_tag, dt_portfolio_classes( $type, 'head', false ), get_the_title() );
?>
<div class="dt-hs-container <?php dt_portfolio_classes( $type, 'block' ); echo $first_class; ?>">

        <?php
        $post_opts = get_post_meta( $post->ID, '_dt_gal_p_options', true );
        $thumb_id = get_post_thumbnail_id( $post->ID );
        
        $args = array(
			'no_found_rows'		=> 1,
            'post_type'         => 'attachment',
            'post_mime_type'    => 'image',
            'post_status'       => 'inherit',
            'post_parent'       => $post->ID,        
            'orderby'           => $post_opts['orderby'],
            'order'             => $post_opts['order'],
            'posts_per_page'    => -1
        );
        
        if ( has_post_thumbnail() && $post_opts['hide_thumbnail'] ) {
            $args['post__not_in'] = array($thumb_id); 
        }

        $images = new WP_Query( $args );

        if ( has_post_thumbnail() ) {
            $thumb_meta = wp_get_attachment_image_src( $thumb_id, 'full' );
        } elseif( $images->have_posts() ) {
            $thumb_meta = wp_get_attachment_image_src( $images->posts[0]->ID, 'full' );
        }else {
            $thumb_meta = null;
        }
        
		// get alt
		$img_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
		if ( !$img_alt ) { $img_alt = get_the_title(); }
		
        $img = dt_get_thumb_img( array(
            'class'         => 'photo highslide',
            'img_meta'      => $thumb_meta,
			'alt'			=> $img_alt,
            'custom'        => $img_custom,
            'use_noimage'   => true,
            'thumb_opts'    => array( 'w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
            ),
            '<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %SIZE% %ALT% /></a>%P_FORM%</div>', false
        );

        echo str_replace( '%P_FORM%', $pass_form, $img );
        ?>
    
    <?php
	if ( 'list' == $pg_opts['layout'] ||
		! isset( $page_opts['show_grid_text'] ) ||
		( isset( $page_opts['show_grid_text'] ) && 'on' == $page_opts['show_grid_text'] )
	):
	?>
    
    <?php if ( 'grid' == $pg_opts['layout'] ): ?>
        <div class="widget-info">
    <?php endif; ?>

	<div class="<?php dt_portfolio_classes( $type, 'info' ); ?>">

        <?php if ( 'on' == $page_opts['show_title'] ) { echo $title; } ?>
		
		<?php if ( 'on' == $page_opts['show_category'] ): ?>
			
			<ul class="folio-category">
			<?php echo get_the_term_list( get_the_ID(), 'dt_gallery_category', '<li>', '<div class="dot"></div></li><li>', '</li>' ); ?>
			</ul>
			
		<?php endif; ?>
		
        <?php if ( ! post_password_required() ): ?>
            
			<?php
			if ( 'on' == $page_opts['show_excerpt'] ) { the_excerpt(); }
			if ( 'list' == $pg_opts['layout'] ) { dt_edit_link( 'Edit', null, 'button' ); }
			?>
        
		<?php endif; ?>

	</div>

    <?php if ( 'grid' == $pg_opts['layout'] ): ?>
        </div>
    <?php endif; ?>
    
    <?php endif;// show excerpt in grid layout ?>

        <?php
		// if there are images - put it to the "hidden container"
		if ( $images->have_posts() && ! post_password_required() ):
        $hs_group = 'dt_gallery_' . $post->ID;
        ?>
        
            <div class="hidden-container" data-hs_group="<?php echo $hs_group; ?>">

            <?php
            foreach ( $images->posts as $image ) {
                dt_get_thumb_img( array(
                    'class'         => 'highslide',
					'alt'			=> get_post_meta( $image->ID, '_wp_attachment_image_alt', true ),
                    'img_meta'      => wp_get_attachment_image_src( $image->ID, 'full' ),
                    'title'         => esc_attr( strip_tags( $image->post_excerpt ) ),
                    'thumb_opts'    => array( 'w' => 90, 'h' => 90 )
                    ),
                    '<a %HREF% %CLASS% %TITLE% %CUSTOM%><img %ALT% %SRC% %SIZE% /></a>'
                );

				?>
				<div class="highslide-caption"><?php
				echo $image->post_excerpt;
				
				// show like mini button
				if ( dt_is_page_soc_buttons_enabled( 'gallery' ) ) {
					dt_get_like_window( array(
						'img' => urlencode( current( wp_get_attachment_image_src( $image->ID, 'thumbnail' ) ) ),
                        'full'  => urlencode( current( wp_get_attachment_image_src( $image->ID, 'full' ) ) ),
						'src' => urlencode( get_permalink( $image->ID ) )
					) );
				}
				
				?></div>
                <?php
			}
            ?>

        </div>
        <?php endif; ?>
</div>