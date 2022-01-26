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

}