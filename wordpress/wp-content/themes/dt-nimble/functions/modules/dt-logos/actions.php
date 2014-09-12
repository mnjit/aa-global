<?php

// admin logos list thumbnail column action
function dt_a_logos_col_thumb($column_name, $id){
	if( 'dt_logos_thumbs' === $column_name ){
		dt_admin_thumbnail( $id );
    }
}
add_action('manage_posts_custom_column', 'dt_a_logos_col_thumb', 5, 2);

// admin logos list category column action
function dt_a_logos_col_cat($column_name, $id){
    if( 'dt_logos_cat' === $column_name ){
        $post_type = get_post_type($id);
        
        if( 'dt_logos' == $post_type ) {
            $taxonomy = 'dt_logos_category';
        }else {
            return false;
        }

        $categories = '';
        $before = '';
        $after = '';
        $sep = ', ';
        $terms = get_the_terms( $id, $taxonomy );
  
        if( $terms ) {
            foreach ( $terms as $term ) {
                $link = add_query_arg( array( 'post_type' => $post_type, $taxonomy => $term->slug ), admin_url( 'edit.php' ) );
				$term_links[] = '<a href="' . $link . '" rel="tag">' . $term->name . ' (' . $term->term_id . ')' . '</a>';
            }
            $categories = $before . join( $sep, $term_links ) . $after;
        }

        echo $categories;

    }
}
add_action('manage_posts_custom_column', 'dt_a_logos_col_cat', 5, 2);

?>