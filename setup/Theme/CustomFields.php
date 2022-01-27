<?php
/**
 * This class defines custom fields for our post types
 */

namespace Theme;

class CustomFields {

	/**
	 * Optional custom field prefix
	 * @var string
	 */
	protected $prefix;
	/**
	 * Array of box names - correspond to method names
	 * @var array
	 */
	protected $boxes = [
		'candidate',
		'candidate_contact_info',
		'candidate_read_only',
		'race',
		'race_read_only'
	];

	/**
	 * Constructor - should fire off all metabox creation when called.
	 */
	public function __construct(){
		$this->add_show_on_filters();
		$this->load_boxes();
	}

	///////////////
	// Metaboxes //
	///////////////

	/**
	 * Loop through our boxes property and invoke the corresponding
	 * function that will define its metabox(es)
	 */
	protected function load_boxes(){
		if ($this->boxes && !empty($this->boxes)){
			foreach ($this->boxes as $box) {
				add_action('cmb2_admin_init', [$this, $box]);
			}
		}
	}

	public function front(){

		$cmb2 = new_cmb2_box([
			'id' => 'front_page_details',
			'title' => 'Front Page Details',
			'object_types' => ['page'],
			'show_on' => ['key' => 'front-page']
		]);

		$cmb2->add_field( [
			'id' => 'hero_image',
			'name' => 'Hero Image',
			'type' => 'file',
			'desc' => 'An image that will appear prominently on the front page.',
			'options' => [
				'url' => false
			]
		]);

		$this->subtitle_field($cmb2);

	}

	public function candidate(){

		$cmb2 = new_cmb2_box([
			'id' => 'candidate',
			'title' => 'Candidate Details',
			'object_types' => ['candidate'],
		]);

		$cmb2->add_field([
			'id' => 'last_name',
			'name' => 'Last Name',
			'description' => 'For alphabetization',
			'type' => 'text'
		]);

		$cmb2->add_field([
			'id' => 'bioguide_id',
			'name'=> 'Bioguide ID',
			'description' => 'For existing federal office-holders only. <a target="_blank" href="https://bioguide.congress.gov/search">Search here</a>, then pull the ID string out of the matching URL',
			'type' => 'text'
		]);

		$cmb2->add_field([
			'id' => 'ballotpedia_url',
			'name' => 'Ballotpedia URL',
			'type' => 'text_url'
		]);

		$cmb2->add_field([
			'id' => 'political_party_taxonomy',
			'name' => 'Political Party',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'political-party',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

		$cmb2->add_field([
			'id' => 'stage_taxonomy',
			'name' => 'Race Stage',
			'description' => 'Primary, general election, etc',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'stage',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

		$cmb2->add_field([
			'id' => 'election_date',
			'name' => 'Date of next election (primary or general election)',
			'type' => 'text_date',
			'date_format' => 'Y-m-d'
		]);

	}

	public function candidate_contact_info(){

		$cmb2 = new_cmb2_box([
			'id' => 'candidate_contact_info',
			'title' => 'Contact Info',
			'object_types' => ['candidate'],
		]);

		$contact_info_elements = [
			'campaign_facebook' => 'Campaign Facebook',
			'campaign_twitter' => 'Campaign Twitter',
			'campaign_instagram' => 'Campaign Instagram',
			'campaign_youtube' => 'Campaign YouTube',
			'campaign_website' => 'Campaign website',
			'campaign_email' => 'Campaign email',
			'campaign_mailing_address' => 'Campaign mailing address',
			'campaign_phone' => 'Campaign phone'
		];

		// Create various social media custom fields
		foreach ($contact_info_elements as $key => $value) {

			$cmb2->add_field([
				'id' => $key,
				'name' => $value,
				'type' => 'text'
			]);

		}

	}

	public function candidate_read_only(){

		$cmb2 = new_cmb2_box([
			'id' => 'candidate_read_only',
			'title' => 'Read Only Data',
			'object_types' => ['candidate'],
		]);

		$cmb2->add_field([
			'id' => 'ballotpedia_person_id',
			'name'=> 'Ballotpedia Person ID',
			'type' => 'text_small',
			'save_field' => false,
			'attributes' => [
				'readonly' => 'readonly',
				'disabled' => 'disabled'
			]
		]);

	}

	public function race(){

		$cmb2 = new_cmb2_box([
			'id' => 'race',
			'title' => 'Race Details',
			'object_types' => ['race'],
		]);

		$cmb2->add_field([
			'id' => 'ballotpedia_url',
			'name' => 'Ballotpedia URL',
			'type' => 'text_url'
		]);

		$cmb2->add_field([
			'id' => 'election_date',
			'name' => 'Election Date',
			'type' => 'text_date',
			'date_format' => 'Y-m-d'
		]);

		$cmb2->add_field([
			'id' => 'district_name',
			'name' => 'District Name',
			'type' => 'text',
			'description' => 'Area in which people are eligible to vote for this race. For example, a US Senate race would be the name of the state.'
		]);

		$cmb2->add_field([
			'id' => 'state_taxonomy',
			'name' => 'State',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'state',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

		$cmb2->add_field([
			'id' => 'branch_taxonomy',
			'name' => 'Branch',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'branch',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

		$cmb2->add_field([
			'id' => 'level_taxonomy',
			'name' => 'Office Level',
			'description' => 'Federal/State/Local',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'level',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

		$cmb2->add_field([
			'id' => 'race_type_taxonomy',
			'name' => 'Race Type',
			'type' => 'taxonomy_select',
			'remove_default' => true,
			'taxonomy' => 'race-type',
			'query_args' => [
				'orderby' => 'slug',
				'hide_empty' => false
			]
		]);

	}

	public function race_read_only(){

		$cmb2 = new_cmb2_box([
			'id' => 'race_read_only',
			'title' => 'Read Only',
			'object_types' => ['race'],
		]);

		$cmb2->add_field([
			'id' => 'ballotpedia_race_id',
			'name' => 'Ballotpedia Race ID',
			'type' => 'text',
			'save_field' => false,
			'attributes' => [
				'readonly' => 'readonly',
				'disabled' => 'disabled'
			]
		]);

		$cmb2->add_field([
			'id' => 'district_ocdid',
			'name' => 'District OCDID',
			'type' => 'text',
			'save_field' => false,
			'attributes' => [
				'readonly' => 'readonly',
				'disabled' => 'disabled'
			]
		]);

	}

	public function article(){

		$cmb2 = new_cmb2_box([
			'id' => 'article_details',
			'title' => 'Article Details',
			'object_types' => ['article'],
		]);

		$this->subtitle_field($cmb2);

		$this->featured_video_url_field($cmb2);

	}

	/////////////////////
	// Reusable Fields //
	/////////////////////
	//
	// Easily reuse field definitions by passing in the
	// current $cmb2 object being manipulated

	/**
	 * Subtitle field
	 * @param  object $cmb2
	 */
	protected function subtitle_field($cmb2){
		return $cmb2->add_field([
			'id'       => 'subtitle',
			'name'     => 'Subtitle',
			'type'     => 'textarea_small',
			'desc'     => '(Optional) Enter a subtitle',
		]);
	}

	/**
	 * Featured Video URL field
	 */
	protected function featured_video_url_field($cmb2){
		return $cmb2->add_field([
			'id'       => 'featured_video_url',
			'name'     => 'Featured Video URL',
			'type'     => 'oembed',
			'desc'     => '(YouTube only) Add the URL of the YouTube video you would like featured. This will attempt to retrieve the thumbnail from YouTube and set it as the featured image.',
		]);
	}

	/////////////////////
	// Show On Filters //
	/////////////////////

	/**
	 * Create any custom show_on filters that we may want to utilize
	 */
	protected function add_show_on_filters(){
		add_filter('cmb2_show_on', [$this, 'show_on_front_page'], 10, 2);
	}

	public function show_on_front_page($display, $meta_box){

		// Move along if we haven't defined a "show_on" property
		if ( ! isset( $meta_box['show_on']['key'] ) ){
			return $display;
		}

		// Ignore if not the front-page "show_on"
		if ( 'front-page' !== $meta_box['show_on']['key'] ) {
			return $display;
		}

		$post_id = 0;

		// If we're showing it based on ID, get the current ID
		if ( isset( $_GET['post'] ) ) {
			$post_id = $_GET['post'];
		} elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = $_POST['post_ID'];
		}

		if ( ! $post_id ) {
			return false;
		}

		// Get ID of page set as front page, 0 if there isn't one
		$front_page = get_option('page_on_front');

		// there is a front page set and we're on it!
		return $post_id == $front_page;

	}

}