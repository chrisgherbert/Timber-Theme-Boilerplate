<?php

namespace Content\Lib;

use SoftCreatR\MimeDetector\MimeDetector;
use SoftCreatR\MimeDetector\MimeDetectorException;

class FileDownloader {

	public $external_url;

	public function __construct($external_url){
		$this->external_url = $external_url;
	}

	public function create_attachment_object(){

		$desc = 'Attachment imported from ' . $this->external_url;

		$tmp_name = download_url( $this->external_url );

		// If error storing temporarily, return the error.
		if ( is_wp_error( $tmp_name ) ) {
			return $tmp_name;
		}

		// Create file name that won't upset WordPress
		$safe_name = $this->create_safe_file_name($this->external_url);

		// Get proper extension using mimetype
		$extension = $this->get_real_file_extension($tmp_name);

		$new_file_name = $safe_name . "." . $extension;

		$file_array = [
			'name' => $new_file_name,
			'tmp_name' => $tmp_name
		];

		// Do the validation and storage stuff.
		$id = media_handle_sideload( $file_array, 0, $desc );

		// If error storing permanently, unlink.
		if ( is_wp_error( $id ) ) {
			@unlink( $file_array['tmp_name'] );
			error_log(print_r($id));
			return $id;
		}

		return $id;

	}

	public function get_real_file_extension($path){

		$mime_detector = new MimeDetector();

		// set our file to read
		try {
			$mime_detector->setFile($path);
		} catch (MimeDetectorException $e) {
			die('An error occurred while trying to load the given file.');
		}

		$file_data = $mime_detector->getFileType();

		if (isset($file_data['ext'])){
			return $file_data['ext'];
		}

	}

	public function create_safe_file_name($file_name){

		// Remove query string etc from file, leaving ONLY the name (without extension)
		$name = pathinfo(parse_url($file_name, PHP_URL_PATH), PATHINFO_FILENAME);

		// Truncate the filename to 200 chars, just to be safe
		return substr($name, 0, 200);

	}

	public static function create_attachment_from_url($url){

		$downloader = new self($url);

		return $downloader->create_attachment_object();

	}

}