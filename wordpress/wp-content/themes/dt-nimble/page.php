<?php get_header(); ?>
<?php dt_storage('have_sidebar', true); ?>

<?php get_template_part('top-bg'); ?>

<div id="wrapper">

<?php get_template_part('nav'); ?>

<div id="container">

<?php
if( have_posts() ) {
    while( have_posts() ) {
        the_post();
        the_content();
        comments_template();
    }
}
?>

</div>

<?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>