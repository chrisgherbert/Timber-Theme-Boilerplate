<?php

namespace Content\Import;

class RaceRecord {

	public $data;

	public function __construct($row){

		$this->data = $row;

	}

	public function create_post(){

		echo 'Creating post object for ' . $this->title() . PHP_EOL;

		$post_id = $this->get_or_create_post();

		if (!$post_id){
			echo ' - Error creating post object' , PHP_EOL;
			return false;
		}

		// Set state
		if ($body = $this->state()){
			echo ' - Setting state: ' . $state . PHP_EOL;
			$state_term = get_term_by('slug', $state, 'state');
			wp_set_object_terms($post_id, $state_term->term_id, 'state');
		}

		// Set level
		if ($level = $this->level()){
			echo ' - Setting level: ' . $level . PHP_EOL;
			$this->set_term_by_name($post_id, $level, $taxonomy);
		}

		// Set branch
		if ($branch = $this->branch()){
			echo ' - Setting branch: ' . $branch . PHP_EOL;
			$this->set_term_by_name($post_id, $branch, $taxonomy);
		}

		// Set race_type
		if ($race_type = $this->race_type()){
			echo ' - Setting race_type: ' . $race_type . PHP_EOL;
			$this->set_term_by_name($post_id, $race_type, $taxonomy);
		}

		// Set stage
		if ($stage = $this->stage()){
			echo ' - Setting stage: ' . $stage . PHP_EOL;
			$this->set_term_by_name($post_id, $stage, $taxonomy);
		}

	}

	protected function get_or_create_post(){

		$existing_post = $this->existing_post();

		if (!$existing_post){

			$post_id = wp_insert_post([
				'post_type' => 'race',
				'post_title' => $this->title(),
				'post_status' => 'publish'
			]);

		}
		else {

			$post_id = $existing_post;

		}

		return $post_id;

	}

	// Check if the profile already exists using the Race ID
	public function existing_post(){

		$posts = get_posts([
			'post_type' => 'race',
			'meta_query' => [
				[
					'key' => 'ballotpedia_race_id',
					'value' => $this->race_id(),
					'compare' => '='
				]
			]
		]);

		if ($posts && isset($posts[0])) {
			return $posts[0]->ID;
		}
		else {
			return false;
		}

	}

	public function set_term_by_name($post_id, $name, $taxonomy){

		$term = get_term_by('name', $name, $taxonomy);

		if (!$term){
			$term = wp_insert_term($name, $taxonomy);
		}

		return wp_set_object_terms($post_id, $term->term_id, $taxonomy);

	}

	///////////////////////
	// General Post Data //
	///////////////////////

	public function title(){
		return trim($this->data['Office name']) ?? false;
	}

	public function state_abbrev(){
		$abbrev = $this->data['State'];
		return trim(strtolower($abbrev)) ?? false;
	}

	public function election_year(){
		return $this->data['Election Year'] ?? false;
	}

	public function race_id(){
		return $this->data['Race ID'] ?? false;
	}

	public function office_id(){
		return $this->data['Office ID'] ?? false;
	}

	public function stage(){
		return $this->data['Stage'] ?? false;
	}

	public function race_type(){
		return $this->data['Race Type'] ?? false;
	}

	public function level(){
		return $this->data['Office level'] ?? false;
	}

	public function branch(){
		return $this->data['Office branch'] ?? false;
	}

	public function district_name(){
		return $this->data['District name'] ?? false;
	}

	public function district_type(){
		return $this->data['District type'] ?? false;
	}

	public function district_ocdid(){
		return $this->data['District OCDID'] ?? false;
	}

	public function race_url(){
		return $this->data['Race URL'] ?? false;
	}

	public function election_date(){
		return $this->data['Election date'] ?? false;
	}

}