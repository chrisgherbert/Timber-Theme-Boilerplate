<?php

/*
 Ballotpedia allows automatic downloads of updated data. But the process for
 getting it is annoying. First, you make a call to an endpoint that returns a
 query ID. Then you use that query ID with another endpoint to get the actual
 URL of the file to download. You can get that in either JSON or CSV format.
 */

namespace Content\Import;

use Curl\Curl;

class RacesBallotpediaImporterApi {

	public $api_key;

	protected $query_list_endpoint = 'https://api.ballotpedia.org/getQueryList';
	protected $query_results_endpoint = 'https://api.ballotpedia.org/getQueryResults';

	public function __construct($api_key){
		$this->api_key = $api_key;
	}

	public function get_query_id(){

		$curl = new Curl();

		$curl->setHeader('x-api-key', $this->api_key);

		$data = $curl->get($this->query_list_endpoint);

		if ($data->success){

			return $data->data[0]->id;

		}

	}

	public function get_json_url(){
		return $this->get_download_url('json');
	}

	public function get_csv_url(){
		return $this->get_download_url('csv');
	}

	protected function get_download_url($type){

		$curl = new Curl();

		$curl->setHeader('x-api-key', $this->api_key);
		$curl->setHeader("Content-Type", "application/json");

		$data = $curl->post($this->query_results_endpoint, json_encode([
			'id' => $this->get_query_id(),
			'format' => $type
		]));

		if ($data->success){

			return $data->data->url;

		}

	}

}