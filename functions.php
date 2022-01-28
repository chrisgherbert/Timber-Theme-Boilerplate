<?php

// Require Composer dependencies
require_once('vendor/autoload.php');

$timber = new \Timber\Timber();

////////////////////////////////
// Make sure Timber is loaded //
////////////////////////////////

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

/////////////////////////////////////
// Setup Timber template locations //
/////////////////////////////////////

Timber::$dirname = ['templates', 'views'];

////////////////////////////
// Initiate Theme Classes //
////////////////////////////

// Register the autoloaders
require( get_template_directory() . '/setup/autoloaders.php');

// Instantiate theme classes
new Theme\Assets();
new Theme\Menus();
new Theme\PostTypes();
new Theme\CustomFields();
new Theme\Taxonomies();
new Theme\SiteOptions();
new Theme\AdminCustomize();
new Theme\Timber\TwigFilters();
new Theme\Timber\Context();
new Theme\Hooks\Feeds();
new Theme\Hooks\Archives();
new Theme\Hooks\Ajax();
new Theme\Hooks\YoutubeFeaturedImage();
// new Theme\Hooks\PostCreateUpdate(); Not yet working

/////////////////////////
// Basic Theme Options //
/////////////////////////

// Theme Support
add_theme_support( 'post-formats', [] );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'menus' );
add_theme_support( 'title-tag' );
add_theme_support( 'html5', array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption' ) );

// Remove extraneous <head> tags
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

////////////////////////////////
// Posts-to-posts Connections //
////////////////////////////////

if (function_exists('p2p_register_connection_type')){

	add_action('p2p_init', function(){

		p2p_register_connection_type([
			'name' => 'candidates_to_race',
			'from' => 'race',
			'to' => 'candidate',
			'cardinality' => 'one-to-many',
			'title' => [
				'to' => 'Connected Race'
			]
		]);

	});

}
else {

	add_action('admin_notices', function(){

		echo '<div class="notice notice-error"><p>The Posts-to-Posts is not installed and/or activiated. This plugin is required. Please install it: <a href="https://github.com/scribu/wp-posts-to-posts">Posts-to-Posts plugin</a>.</p></div>';

	});

}

//////////////////////////
// Ballotpedia Importer //
//////////////////////////

/**
 * Import Ballotpedia data and optionally send a report email to the admin
 * @param  boolean $send_email Send an email to site admin
 */
function import_ballotpedia_data($send_email = false){

	$api_key = get_site_option('site_options_api_keys')['ballotpedia_api_key'] ?? false;

	if (!$api_key){
		return false;
	}

	$importer_api = new Content\Import\RacesBallotpediaImporterApi($api_key);

	$url = $importer_api->get_json_url();

	$json_importer = new Content\Import\RacesBallotpediaImporterJson($url);

	// Start timer
	$time_pre = microtime(true);

	// Import records
	$json_importer->import();

	// Stop timer
	$time_post = microtime(true);
	$exec_time = round($time_post - $time_pre);

	$message = "Completed Ballotpedia data import in $exec_time seconds";

	// Email import report
	if ($send_email){

		wp_mail(
			get_option('admin_email'),
			'Candidate Database Import Report',
			$message
		);

	}

}

