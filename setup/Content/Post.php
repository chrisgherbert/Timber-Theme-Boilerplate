<?php
/**
 * The base Post class for our site
 */

namespace Content;

use chrisgherbert\ExtendedTimberClasses;

class Post extends ExtendedTimberClasses\Post {

	public $PostClass = '\Content\Post';

	public static function class_map(){

		return [
			'post' => '\Content\Post',
			'race' => '\Content\Race',
			'candidate' => '\Content\Candidate'
		];

	}

	public function update_featured_image_by_url($image_url, $replace_existing = false){

		if ($this->thumbnail() && !$replace_existing){
			return false;
		}

		$attachment_id = Lib\FileDownloader::create_attachment_from_url($image_url);

		if ($attachment_id){
			return set_post_thumbnail($this->id, $attachment_id);
		}

	}

}