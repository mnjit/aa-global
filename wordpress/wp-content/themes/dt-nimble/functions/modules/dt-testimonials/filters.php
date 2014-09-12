<?php
// add custon column 'dt_testimonials_cat' in testimonials list for category
function dt_f_testimonials_col_cat( $defaults ) {
    $defaults['dt_testimonials_cat'] = _x( 'Category', 'backend testimonials', LANGUAGE_ZONE );

    return $defaults;
}
add_filter('manage_edit-dt_testimonials_columns', 'dt_f_testimonials_col_cat', 1);

// fields filter for custom uploader
function dt_f_testimonials_att_fields($fields, $post) {
	if( 'dt_testimonials' == get_post_type($post->post_parent) ) {
        unset($fields['align']);
        unset($fields['image-size']);
        unset($fields['post_content']);
        unset($fields['image_alt']);
        unset($fields['url']);
	}
	return $fields;
}
add_filter('attachment_fields_to_edit', 'dt_f_testimonials_att_fields', 99, 2);
?>