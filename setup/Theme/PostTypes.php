<?php
/**
 * This class creates our post types
 */

namespace Theme;

class PostTypes {

	protected $types = [
		'candidate',
		'race'
	];

	public function __construct(){
		if ($this->types && !empty($this->types)){
			foreach ($this->types as $type) {
				$this->$type();
			}
		}
	}

	public function candidate(){

		register_via_cpt_core([
			'Candidate',
			'Candidates',
			'candidate'
		], [
			'menu_icon' => 'dashicons-businessperson',
			'supports' => ['title', 'editor', 'thumbnail'],
			'taxonomies' => [],
			'has_archive' => true
		]);

	}

	public function race(){

		register_via_cpt_core([
			'Race',
			'Races',
			'race'
		],[
			'menu_icon' => 'dashicons-thumbs-up',
			'supports' => ['title', 'editor'],
			'taxonomies' => [],
			'has_archive' => true
		]);

	}

}