<?php

namespace Content;

class Candidate extends Post {

	public function connected_race(){

		$query = [
			'connected_type' => 'candidates_to_race',
			'connected_items' => get_queried_object(),
			'nopaging' => true,
			'suppress_filters' => false
		];

		$posts = \Timber::get_posts($query, Post::class_map());

		if (isset($posts[0])){
			return $posts[0];
		}

	}

}