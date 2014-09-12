<?php
/* Template Name: 04. Page with Sidebar */

dt_storage( 'have_sidebar', true );

get_header();
?>

<?php get_template_part( 'top-bg' ); ?>


<div id="wrapper">

<?php get_template_part( 'nav' ); ?>

<div id="container"<?php echo dt_get_container_class(); ?>>

<?php
if ( have_posts() ) {
    while ( have_posts() ) { the_post(); the_content(); comments_template(); }
}
?>

</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>