<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="theme-page" class="master-holder clear">
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
