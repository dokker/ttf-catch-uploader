<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

<div id="theme-page" class="master-holder clear catch-page">
	<div class="theme-page-wrapper mk-main-wrapper mk-grid full-layout">
	<article>
		<div class="row">
			<?php $photo = get_field('catch_photo'); ?>
			<div class="photo-holder column">
				<div class="catch-photo catch-holder">
					<img src="<?php echo $photo['sizes']['medium_large']; ?>">
				</div>
			</div>

			<?php $location = get_field('catch_location');
			if( !empty($location) ): ?>
			<div class="map-holder column">
				<div class="acf-map">
					<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>"></div>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<div class="row">
			<div class="catch-holder column"><?php the_field('catch_description') ?></div>
		</div>

	</article>
	</div>
</div>

<?php endwhile; ?>

<?php get_footer(); ?>
