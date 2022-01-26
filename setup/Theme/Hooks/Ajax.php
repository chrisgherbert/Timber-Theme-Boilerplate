<?php

namespace Theme\Hooks;

class Ajax {

	public function __construct(){

		add_action('wp_ajax_update_ballotpedia_data', [$this, 'update_ballotpedia_data']);
		add_action('wp_ajax_nopriv_update_ballotpedia_data', [$this, 'update_ballotpedia_data']);

	}

	public function update_ballotpedia_data(){

		// Update Ballotpedia data and send report email
		import_ballotpedia_data(true);

	}

}