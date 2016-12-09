<?php get_header(); ?>
<?php get_template_part('content', 'page'); ?>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<div class="mk-grid">
<?php while (have_posts()) : the_post(); ?>
	<?php $photo = get_field('catch_photo'); ?>
	<article class="mk-col-3-12 col-md-3 col-sm-4d">
		<div class="entry-wrap">
			<a href="<?php echo  get_permalink($catch->ID); ?>">
				<figure>
					<img src="<?php echo $photo['sizes']['cnc-catch-recent']; ?>" alt="<?php echo $photo['alt']; ?>" />
					<figcaption><?php echo the_title(); ?></figcaption>
				</figure>
			</a>
		</div>
	</article>
<?php endwhile; ?>
</div>

<?php //the_posts_navigation(); ?>
<?php the_posts_pagination(['mid-size' => 5]); ?>

<?php get_footer(); ?>
