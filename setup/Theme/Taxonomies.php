<?php
/**
 * Class to define our taxonomies
 *
 * Depends on the webdevstudios/taxonomy_core library
 */

namespace Theme;

class Taxonomies {

	protected $taxonomies = [
		'political_party',
		'state',
		'level',
		'branch',
		'race_type',
		'stage'
	];

	public function __construct(){

		if ( ! class_exists( 'Taxonomy_Core' ) ){
			error_log('Please load the webdevstudios/taxonomy_core library');
			return false;
		}

		if ($this->taxonomies && !empty($this->taxonomies)){
			foreach ($this->taxonomies as $taxonomy) {
				$this->$taxonomy();
			}
		}

	}

	////////////////
	// Taxonomies //
	////////////////

	public function political_party(){

		register_via_taxonomy_core([
			'Political Party',
			'Political Parties',
			'political-party'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[	
			'candidate'
		]);

	}

	public function state(){

		register_via_taxonomy_core([
			'State',
			'States',
			'state'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[	
			'race'
		]);

	}

	public function level(){

		register_via_taxonomy_core([
			'Level',
			'Levels',
			'level'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[	
			'race'
		]);

	}

	public function branch(){

		register_via_taxonomy_core([
			'Branch',
			'Branches',
			'branch'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[
			'race'
		]);

	}

	public function race_type(){

		register_via_taxonomy_core([
			'Race Type',
			'Race Types',
			'race-type'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[
			'race'
		]);

	}

	public function stage(){

		register_via_taxonomy_core([
			'Stage',
			'Stages',
			'stage'
		],[
			'hierarchical' => false,
			'show_ui' => true,
			'show_admin_column' => true,
			'query_var' => true
		],[
			'candidate'
		]);

	}

	// Methods for creating empty taxonomy terms

	public static function create_election_year_terms(){

		$start = date('Y') - 3;
		$options = range($start, ($start + 6) );

		foreach ($options as $option){
			self::create_term_if_not_exists($option, 'election-year');
		}

	}

	public static function create_political_party_terms(){

		$options = [
			"Democratic Party",
			"Republican Party",
			"Action For Change",
			"American Independent Party",
			"Conservative Party",
			"Constitution Party",
			"Constitutional Party",
			"Democratic-Farmer Labor Party",
			"Federalist Party",
			"Freedom Party",
			"Green Party",
			"Green Party of Pennsylvania",
			"Independent",
			"Independent-Green Party",
			"Legal Marijuana Now Party",
			"Libertarian Party",
			"Minnesota Democratic-Farmer-Labor Party",
			"New Progressive Party",
			"No Party Affiliation",
			"Nonpartisan",
			"Other",
			"Patriot Party",
			"Peace and Freedom Party",
			"Reform Party",
			"Socialist Labor Party",
			"U.S. Taxpayers Party",
			"Unaffiliated",
			"Unenrolled",
			"Unity Party",
			"Veterans Party of America Party"
		];

		foreach ($options as $option){
			self::create_term_if_not_exists($option, 'political-party');
		}

	}

	public static function create_state_terms(){

		$options = [
			'AL' => 'Alabama',
			'AK' => 'Alaska',
			'AZ' => 'Arizona',
			'AR' => 'Arkansas',
			'CA' => 'California',
			'CO' => 'Colorado',
			'CT' => 'Connecticut',
			'DE' => 'Delaware',
			'DC' => 'Washington DC',
			'FL' => 'Florida',
			'GA' => 'Georgia',
			'HI' => 'Hawaii',
			'ID' => 'Idaho',
			'IL' => 'Illinois',
			'IN' => 'Indiana',
			'IA' => 'Iowa',
			'KS' => 'Kansas',
			'KY' => 'Kentucky',
			'LA' => 'Louisiana',
			'ME' => 'Maine',
			'MD' => 'Maryland',
			'MA' => 'Massachusetts',
			'MI' => 'Michigan',
			'MN' => 'Minnesota',
			'MS' => 'Mississippi',
			'MO' => 'Missouri',
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',
			'OK' => 'Oklahoma',
			'OR' => 'Oregon',
			'PA' => 'Pennsylvania',
			'PR' => 'Puerto Rico',
			'RI' => 'Rhode Island',
			'SC' => 'South Carolina',
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',
			'TX' => 'Texas',
			'UT' => 'Utah',
			'VT' => 'Vermont',
			'VI' => 'Virgin Islands',
			'VA' => 'Virginia',
			'WA' => 'Washington',
			'WV' => 'West Virginia',
			'WI' => 'Wisconsin',
			'WY' => 'Wyoming',
		];

		foreach ($options as $abbrev => $name){

			if (!term_exists($name, 'state')){
				wp_insert_term($name, 'state', [
					'slug' => $abbrev
				]);
			}
			else {
				return false;
			}

		}

	}

	public static function create_level_terms(){

		$taxonomy = 'level';

		$options = [
			'Federal',
			'State',
			'Local'
		];

		foreach ($options as $option){
			self::create_term_if_not_exists($option, $taxonomy);
		}

	}

	public static function create_branch_terms(){

		$taxonomy = 'branch';

		$options = [
			'Executive',
			'Judicial',
			'Legislative'
		];

		foreach ($options as $option){
			self::create_term_if_not_exists($option, $taxonomy);
		}

	}

	public static function create_race_type_terms(){

		$taxonomy = 'race-type';

		$options = [
			'Recall',
			'Regular',
			'Special'
		];

		foreach ($options as $option){
			self::create_term_if_not_exists($option, $taxonomy);
		}

	}

	public static function create_stage_terms(){

		$taxonomy = 'stage';

		$options = [
			'General',
			'Primary',
			'Convention',
			'Primary Runoff'
		];

		foreach ($options as $option){
			self::create_term_if_not_exists($option, $taxonomy);
		}

	}

	protected static function create_term_if_not_exists($term_name, $taxonomy){

		if (!term_exists($term_name, $taxonomy)){
			wp_insert_term($term_name, $taxonomy);
		}
		else {
			return false;
		}

	}


}
