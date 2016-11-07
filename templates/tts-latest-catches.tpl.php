<div class="cnc-recent-catches">
	<div class="carousel-container">
		<?php foreach ($catches as $catch): ?>
			<div class="catch-container">
				<?php $photo = get_field('catch_photo', $catch->ID); ?>
				<a href="<?php echo  get_permalink($catch->ID); ?>">
					<figure>
						<img src="<?php echo $photo['sizes']['cnc-catch-recent']; ?>" alt="<?php echo $photo['alt']; ?>" />
						<figcaption><?php echo $catch->post_title; ?></figcaption>
					</figure>
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
