<?php
/**
 * The base Post class for our site
 */

namespace Content;

use chrisgherbert\ExtendedTimberClasses;
use chrisgherbert\WordpressImageDownload\WordpressImageDownload;

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

		error_log(get_called_class() . ' Featured image url is: ' . $image_url);

		if ($this->thumbnail() && !$replace_existing){
			return false;
		}

		$downloader = new WordpressImageDownload($image_url);

		$attachment_id = $downloader->create_media_attachment();

		if ($attachment_id){
			return set_post_thumbnail($this->id, $attachment_id);
		}

	}

}