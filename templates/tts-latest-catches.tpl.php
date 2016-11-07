<div class="cnc-recent-catches">
	<div class="carousel-container">
		<?php foreach ($catches as $catch): ?>
			<div class="catch-container">
				<?php $photo = get_field('catch_photo', $catch->ID); ?>
				<a href="<?php echo  get_permalink($catch->ID); ?>">
					<img src="<?php echo $photo['sizes']['cnc-catch-recent']; ?>" alt="<?php echo $photo['alt']; ?>" />
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
