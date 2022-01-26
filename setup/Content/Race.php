<?php

namespace Content;

class Race extends Post {

	public function connected_candidates(){

		$query = [
			'connected_type' => 'candidates_to_race',
			'connected_items' => get_queried_object(),
			'nopaging' => true,
			'suppress_filters' => false
		];

		$posts = \Timber::get_posts($query, '\Content\Candidate');

		return $posts;

	}

}