<?php
$pg_opts = dt_storage('page_data');
if ( isset( $pg_opts['page_options'] ) ) {
	$page_opts = $pg_opts['page_options'];
} else {
	$page_opts = dt_metabox_portfolio_layout_options();
}

$add_data = dt_storage('add_data');

$layout = explode('-', $add_data['init_layout']);
if( isset($layout[1]) ) {
    $layout = $layout[1];
}else {
    $layout = 'list';
}

$first_class = '';
if( (1 === dt_storage('post_is_first')) && ('grid' != $layout) ) {
    $first_class = ' first';
    dt_storage( 'post_is_first', -1 );
}

$pass_form = $img_custom = '';
if( post_password_required() ) {
    $pass_form = get_the_password_form();
    $title_tag = '<h3><span class="%1$s">%2$s</span></h3>';
    $img_href = '#';
    $img_custom = 'onclick="return: false;"';
}else {
    $img_href = get_permalink();
    $title_tag = '<h3><a href="%3$s" class="%1$s">%2$s</a></h3>';
}

$title = sprintf(
	$title_tag,
	dt_portfolio_classes( $add_data['init_layout'], 'head', false ),
	get_the_title(),
	get_permalink()
);

?>
<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'block' ); echo $first_class; ?>">

	<?php
	$img_id = get_post_thumbnail_id();
	
	// get alt
	$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );
	if ( !$img_alt ) { $img_alt = get_the_title(); }
	
	$img = dt_get_thumb_img( array(
		'alt'			=> $img_alt,
		'class'         => 'photo',
		'href'          => $img_href,
		'custom'        => $img_custom,
		'use_noimage'   => true,
		'thumb_opts'    => array( 'w' => $add_data['thumb_w'], 'h' => $add_data['thumb_h'] )
		),
		'<div class="textwidget-photo"><a %HREF% %CLASS% %TITLE% %CUSTOM%><img %SRC% %IMG_CLASS% %SIZE% %ALT% /></a>%P_FORM%</div>', false
	);

	echo str_replace( '%P_FORM%', $pass_form, $img );      
	?>

    <?php
	if(
		'list' == $pg_opts['layout'] ||
		!isset($page_opts['show_grid_text']) ||
		(isset($page_opts['show_grid_text']) && 'on' == $page_opts['show_grid_text'])
	):
	?>

    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        <div class="widget-info">
    <?php endif;// grid	?>

	<div class="<?php dt_portfolio_classes( $add_data['init_layout'], 'info' ); ?>">

        <?php if ( 'on' == $page_opts['show_title'] ) { echo $title; } ?>

		<?php if( 'on' == $page_opts['show_category'] ): ?>

			<ul class="folio-category">
			<?php echo get_the_term_list( get_the_ID(), 'dt_portfolio_category', '<li>', '<div class="dot"></div></li><li>', '</li>' ); ?>
			</ul>

		<?php endif; ?>

		<?php if( !post_password_required() ): ?>

            <?php
			if( 'on' == $page_opts['show_excerpt'] ) { the_excerpt(); }

			if( 'on' == $page_opts['show_details'] && 'list' == $layout ) {
				dt_details_link( null, 'button' );
			}

			dt_edit_link( 'Edit', null, ( 'grid' == $layout ) ? 'details' : 'button' );
            ?>

        <?php endif;// pass protected ?>

    </div>

    <?php if( 'grid' == $pg_opts['layout'] ): ?>
        </div>
    <?php endif;// grid ?>
    
    <?php endif;// show meta or list layout ?>

</div>