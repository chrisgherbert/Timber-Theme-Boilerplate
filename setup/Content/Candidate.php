<?php

namespace Content;

use Embed\Embed;

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

	public function get_social_media_image_url($platform){

		$platforms = [
			'facebook' => 'campaign_facebook',
			'instagram' => 'campaign_instagram',
			'youtube' => 'campaign_youtube',
			'website' => 'campaign_website'
		];

		if (!isset($platforms[$platform])){
			echo 'invalid platform';
			return false;
		}

		$meta_key = $platforms[$platform];

		$profile_url = $this->meta($meta_key);

		if (!$profile_url){
			echo 'no data for ' . $meta_key;
			return false;
		}

		$embed = new Embed();
		$info = $embed->get($profile_url);

		return (string) $info->image;

	}

}