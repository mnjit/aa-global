<?php
global $post;
$slider_cats = get_post_meta( $post->ID, '_dt_obo_slider_layout_slideshows', true );
//$slider_opts = get_post_meta( $post->ID, '_dt_obo_slider_layout_options', true );

// get obo slider posts based on selected category, exclude password protected or private posts
$args = array(
	'no_found_rows'		=> 1,
    'post_type'         => 'dt_obo_slider',
    'posts_per_page'    => -1,
    'order'             => 'DESC',
    'orderby'           => 'date',
    'post_status'       => 'publish'
);

// if selected not all categories - create tax_query
if( 'all' != $slider_cats['select'] ) {
	
	$args['tax_query'] = array( array(
		'taxonomy'  => 'dt_obo_slider_category',
		'field'     => 'id',
		'terms'		=> array_values($slider_cats['slider_cats'])
	) );
	
	if( 'only' == $slider_cats['select'] ) {
		$args['tax_query'][0]['operator'] = 'IN';
	} else {
		$args['tax_query'][0]['operator'] = 'NOT IN';
	}
	
}

$slides_ids = $slides_arr = array();

// fire query
add_filter( 'posts_where', 'dt_exclude_post_protected_filter' );
$slides = new WP_Query( $args );
remove_filter( 'posts_where', 'dt_exclude_post_protected_filter' );

// fill data array's
if( $slides->have_posts() ) {
    while( $slides->have_posts() ) {
		$slides->the_post();
        
		// for filter attachments by post_parent
		$slides_ids[] = intval($post->ID);
	
		// post ontions + content
		$slides_arr[$post->ID] = array();
		$slides_arr[$post->ID]['options'] = get_post_meta( $post->ID, '_dt_obo_slider_options', true );
		$slides_arr[$post->ID]['options']['post_content'] = apply_filters('the_content', get_the_content());
    }
	wp_reset_postdata();
}

// prepare attachments query
$args = array(
    'no_found_rows'		=> 1,
	'post_type'         => 'attachment',
    'post_mime_type'    => 'image',
    'post_status'       => 'inherit',
    'order'             => 'ASC',
    'orderby'           => 'menu_order',     
    'posts_per_page'    => -1
);

// pass params to where filter
dt_storage( 'where_filter_param', implode(',', $slides_ids) ); 

// fire query
add_filter( 'posts_where' , 'dt_core_parents_where_filter' );
$images = new WP_Query( $args );
remove_filter( 'posts_where' , 'dt_core_parents_where_filter' );

global $current_user, $paged;

// if this is first page then show slider
if( $paged >= 0 && $paged <= 1 ):

    while( $images->have_posts() ) { $images->the_post();
		$tmp_arr = array();
		
		// get image position
        $tmp_arr['pos_left'] = intval( get_post_meta($post->ID, '_dt_obo_slider_pos_left', true) );
		$tmp_arr['pos_top'] = intval( get_post_meta($post->ID, '_dt_obo_slider_pos_top', true) );
        
		// get image src
        $img = wp_get_attachment_image_src( $post->ID, 'full' );
        if( $img ) {		
			$tmp_arr['src'] = $img[0];
			$tmp_arr['size_str'] = image_hwstring( $img[1], $img[2] );
		}
		
		// get image title
		if( $post->post_title )
			$tmp_arr['title'] = get_the_title();
		
		// add data to final array
        $slides_arr[$post->post_parent][] = $tmp_arr;
    }
	wp_reset_postdata();
	?>

	<div class="dt-slider-container">
		<?php dt_get_obo_slider( $slides_arr ); ?>
	</div>
	
<?php
endif;
?>
