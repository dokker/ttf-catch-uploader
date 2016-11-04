<?php
namespace cncTTS;

class Model {
	public function __construct()
	{
		
	}

	/**
	 * Get latest catches
	 * @param  integer $num Number of posts to get
	 * @return array       Query posts results
	 */
	public function getLatestCatches($num = -1)
	{
		$args = [
			'posts_per_page' => $num,
			'post_status' => 'publish',
			'post_type' => 'catch',
			'orderby' => 'post_date',
			'order' => 'DESC',
		];
		$query = new \WP_Query($args);
		return $query->posts;
	}
}