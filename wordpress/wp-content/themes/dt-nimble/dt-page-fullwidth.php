<?php
/* Template Name: 03. Full-width Page (Default) */

get_header();
?>

<?php get_template_part('top-bg'); ?>

<?php get_template_part('nav'); ?>

<div id="container" class="full-width">

<?php
if( have_posts() ) {
    while( have_posts() ) { the_post(); the_content(); comments_template(); }
}
?>

</div>

<?php get_footer(); ?>