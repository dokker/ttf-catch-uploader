<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="theme-page" class="master-holder clear">
<article>
	<?php $photo = get_field('catch_photo'); ?>
	<div class="catch-photo"><img src="<?php echo $photo['sizes']['medium_large']; ?>"></div>
	<div><?php the_field('catch_description') ?></div>
	<?php $location = get_field('catch_location');
	if( !empty($location) ): ?>
	<div class="acf-map">
		<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
	</div>
<?php endif; ?>

</article>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
