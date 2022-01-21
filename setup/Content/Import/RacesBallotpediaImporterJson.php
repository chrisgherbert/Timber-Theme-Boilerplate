<?php

namespace Content\Import;

use League\Csv\Reader;

class RacesBallotpediaImporterJson {

	public $json_url;

	public function __construct($json_url){

		$this->json_url = $json_url;

		if (!file_exists($this->json_url)){
			return 'Invalid path';
		}

	}

	public function import(){

		$file = file_get_contents($this->json_url);
		$data = json_decode($file);

		foreach ($data as $row){

			$race_record = new RaceRecord($row);

			$race_record->create_post();

		}

	}

}
