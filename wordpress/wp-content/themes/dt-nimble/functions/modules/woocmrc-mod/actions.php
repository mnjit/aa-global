<?php
/*
 *	Woocommerce related actions
 **/
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function dt_woocommerce_before_main_content () {
	dt_storage('have_sidebar', true);
	get_template_part('top-bg');
?>
	<div id="wrapper">
		
		<?php get_template_part('nav'); ?>
		
		<div id="container">
<?php
}
add_action( 'woocommerce_before_main_content', 'dt_woocommerce_before_main_content' );

function dt_woocommerce_after_main_content () {
?>
	</div>
<?php
}
add_action( 'woocommerce_after_main_content', 'dt_woocommerce_after_main_content' );

function dt_woocommerce_sidebar () {
?>
	</div>
<?php
}
add_action( 'woocommerce_sidebar', 'dt_woocommerce_sidebar', 11 );

/* add woocommerce support */
add_action( 'after_setup_theme', 'dt_theme_add_woocommerce_support', 11 );
function dt_theme_add_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
