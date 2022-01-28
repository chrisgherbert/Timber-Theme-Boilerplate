<?php

namespace Theme;

use Carbon_Fields\Container;
use Carbon_Fields\Field;

class CarbonFieldsCustomFields {

	public function __construct(){

		add_action('carbon_fields_register_fields', [$this, 'candidate']);

		add_action( 'after_setup_theme', [$this, 'crb_load'] );

	}

	public function crb_load(){

		\Carbon_Fields\Carbon_Fields::boot();

	}

	public function candidate(){

		Container::make('post_meta', 'Media Items')
			->where('post_type', '=', 'candidate')
			->add_fields([
				Field::make('complex', 'media_items', 'Media Items')
					->set_layout('tabbed-vertical')
					->add_fields([
						Field::make('text', 'title', 'Title'),
						Field::make('image', 'image', 'Image'),
						Field::make('rich_text', 'description', 'Short Description'),
						Field::make('text', 'link', 'Link to content/original source')
					])
			]);

	}

}