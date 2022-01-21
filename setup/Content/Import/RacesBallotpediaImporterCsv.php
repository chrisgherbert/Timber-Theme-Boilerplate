<?php

namespace Content\Import;

use League\Csv\Reader;

class RacesBallotpediaImporterCsv {

	public $csv_path;

	public function __construct($csv_path){

		$this->csv_path = $csv_path;

		if (!file_exists($this->csv_path)){
			return 'Invalid path';
		}

	}

	public function import(){

		$csv = Reader::createFromPath($this->csv_path, 'r');

		$csv->setHeaderOffset(0);

		// Get records and convert to array
		$iterator = $csv->getRecords();
		$records = iterator_to_array($iterator);

		foreach ($records as $row){

			$race_record = new RaceRecord($row);

			$race_record->create_post();

		}

	}

}
