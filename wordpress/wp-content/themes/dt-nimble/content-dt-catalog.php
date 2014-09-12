<?php
global $post;
$page_data = dt_storage( 'page_data' );
$page_opts = ! empty( $page_data['page_options'] ) ? $page_data['page_options'] : array();
$add_data = dt_storage( 'add_data' );

$first_class = '';
if( 1 === dt_storage('post_is_first') ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$opts = get_post_meta($post->ID, '_dt_catalog-goods_options', true);
?>
<div class="<?php dt_portfolio_classes( '2_col-list', 'block' ); echo $first_class; ?>">

        <?php
		$h = 220;
		if ( ! empty ( $page_opts['thumb_height'] ) ) {
			$h = $page_opts['thumb_height'];
		}
		
		$img_id = get_post_thumbnail_id();
		
		// get alt
		$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
		if ( !$img_alt ) { $img_alt = get_the_title(); }
		
        dt_get_thumb_img( array(
			'alt'			=> $img_alt,
            'class'         => 'photo',
            'use_noimage'   => true,
            'href'          => get_permalink(),
            'thumb_opts'    => array( 'w' => 343, 'h' => $h )
            ),
            '<div class="textwidget-photo">
                <a %HREF% %CLASS% %TITLE% %CUSTOM%><img %ALT% %SRC% %IMG_CLASS% %SIZE% /></a>
            </div>'
        );
        ?>

	<div class="<?php dt_portfolio_classes( '2_col-list', 'info' ); ?>">
		<a class="<?php dt_portfolio_classes( '2_col-list', 'head' ); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		
		<?php if( !empty($opts['price']) ): ?>
        
		<span class="price"><?php _e('Price: ', LANGUAGE_ZONE); echo esc_html($opts['price']); ?></span>
		
		<?php endif; ?>
		
        <?php
        dt_the_content();
        dt_details_link();
        dt_edit_link();
        ?>

	</div>

</div>