<?php
/**
 * Class for creating a tabbed site options page
 * Extends the cmb2-metatabs-options library
 */

namespace Theme;

class SiteOptions {

	/**
	 * Key used for database key and prefixes
	 * @var string
	 */
	protected $options_key = 'site_options';

	/**
	 * Constructor function
	 * Hooks into cmb2_admin_init to create page
	 */
	public function __construct(){
		add_action( 'cmb2_admin_init', [$this, 'initialize'] );
	}

	/**
	 * Creates instance of Cmb2_Metatabs_Options with parameters
	 * defined within this class.
	 */
	public function initialize(){

		$this->social_options_main_page();
		$this->tracking_options_page();
		$this->footer_options_page();

	}

	public function social_options_main_page(){

		/**
		 * Registers main options page menu item and form.
		 */
		$args = [
			'id'           => $this->options_key . '_page',
			'title'        => 'Site Options',
			'object_types' => [ 'options-page' ],
			'option_key'   => $this->options_key,
			'tab_group'    => $this->options_key,
			'tab_title'    => 'General',
		];

		$main_options = new_cmb2_box( $args );
		/**
		 * Options fields ids only need
		 * to be unique within this box.
		 * Prefix is not needed.
		 */

		$main_options->add_field( [
			'name' => 'Public Phone Number',
			'desc' => 'Your organization\'s public phone number',
			'id'   => 'phone',
			'type' => 'text',
		] );

		$main_options->add_field( [
			'name' => 'Public Email Address',
			'desc' => 'Your organization\'s public email address',
			'id'   => 'email',
			'type' => 'text',
		] );

		$main_options->add_field( [
			'name' => 'Facebook Page URL',
			'desc' => 'Insert your Facebook URL here i.e. (https://facebook.com/example/)',
			'id'   => 'facebook_url',
			'type' => 'text_url',
		] );

		$main_options->add_field( [
			'name' => 'Twitter Profile URL',
			'desc' => 'Insert your Twitter URL here (i.e. https://twitter.com/example/)',
			'id'   => 'twitter_url',
			'type' => 'text_url',
		] );

		$main_options->add_field( [
			'name' => 'LinkedIn Page URL',
			'desc' => 'Insert your LinkedIn URL here (i.e. https://linkedin.com/company/example/)',
			'id'   => 'linkedin_url',
			'type' => 'text_url',
		] );

		$main_options->add_field( [
			'name' => 'Instagram Page URL',
			'id'   => 'instagram_url',
			'type' => 'text_url',
		] );

		$main_options->add_field( [
			'name' => 'YouTube Page URL',
			'id'   => 'youtube_url',
			'type' => 'text_url',
		] );

	}

	public function tracking_options_page(){

		/**
		 * Registers secondary options page, and set main item as parent.
		 */
		$suffix = '_tracking';

		$args = [
			'id'           => $this->options_key . '_page' . $suffix,
			'title'        => 'Tracking Options',
			'menu_title'   => 'Tracking Options', // Use menu title, & not title to hide main h2.
			'object_types' => [ 'options-page' ],
			'option_key'   => $this->options_key . $suffix,
			'parent_slug'  => $this->options_key,
			'tab_group'    => $this->options_key,
			'tab_title'    => 'Tracking',
		];

		$tracking_options = new_cmb2_box( $args );

		$tracking_options->add_field( [
			'name'    => 'After opening &lt;head&gt;',
			'desc'    => 'This code will be output immediately after the opening &lt;head&gt; tag.',
			'id'      => 'after_opening_head',
			'type'    => 'textarea_code',
		] );

		$tracking_options->add_field( [
			'name'    => 'Before closing &lt;/head&gt;',
			'desc'    => 'This code will be output immediately before the closing &lt;/head&gt; tag.',
			'id'      => 'before_closing_head',
			'type'    => 'textarea_code',
		] );

		$tracking_options->add_field( [
			'name'    => 'After opening &lt;body&gt;',
			'desc'    => 'This code will be output immediately after the opening &lt;body&gt; tag.',
			'id'      => 'after_opening_body',
			'type'    => 'textarea_code',
		] );

		$tracking_options->add_field( [
			'name'    => 'Before closing &lt;/body&gt;',
			'desc'    => 'This code will be output immediately before the closing &lt;/body&gt; tag.',
			'id'      => 'before_closing_body',
			'type'    => 'textarea_code',
		] );

	}

	public function footer_options_page(){

		/**
		 * Registers footer options page, and set main item as parent.
		 */
		$suffix = '_footer';

		$args = [
			'id'           => $this->options_key . '_page' . $suffix,
			'title'        => 'Footer Options',
			'menu_title'   => 'Footer Options', // Use menu title, & not title to hide main h2.
			'object_types' => [ 'options-page' ],
			'option_key'   => $this->options_key . $suffix,
			'parent_slug'  => $this->options_key,
			'tab_group'    => $this->options_key,
			'tab_title'    => 'Footer',
		];

		$tracking_options = new_cmb2_box( $args );

		$tracking_options->add_field( [
			'name'    => 'Footer Content',
			'id'      => 'footer_content',
			'type'    => 'wysiwyg',
			'options' => [
				'textarea_rows' => 5
			]
		] );

	}

}