<?php
/**
 * This class creates our post types
 */

namespace Theme;

class PostTypes {

	protected $types = [
		// 'article',
	];

	public function __construct(){
		if ($this->types && !empty($this->types)){
			foreach ($this->types as $type) {
				$this->$type();
			}
		}
	}

	/**
	 * Sample "article" content type - used in place of the default "post" content type
	 * to allow a custom rewrite base.  This makes it easier to track blog/article traffic
	 * specifically in analytics software.  However, it also can complicate the development
	 * process.  Proceed with caution.
	 */
	public function article(){

		register_via_cpt_core(
			[
				'Article', // Singular Name
				'Articles', // Plural Name
				'article' // Post Type Slug
			],
			[
				'menu_icon' => 'dashicons-admin-page', // Dashicon icon (Reference: https://developer.wordpress.org/resource/dashicons/)
				'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
				'taxonomies' => ['category', 'post_tag'],
				'has_archive' => true
			]
		);

	}

}