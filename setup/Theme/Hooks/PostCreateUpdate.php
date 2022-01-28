<?php

namespace Theme\Hooks;

use Embed\Embed;
use Content\Lib\FileDownloader;

class PostCreateUpdate {

	public function __construct(){

		add_action('updated_post_meta', [$this, 'update_featured_images_using_social_media_profiles'], 10, 4);
		add_action('added_post_meta', [$this, 'update_featured_images_using_social_media_profiles'], 10, 4);

	}

	/**
	 * Update the featured image for the campaign CPT using social media platform images.
	 */
	public function update_featured_images_using_social_media_profiles($meta_id, $post_id, $meta_key, $meta_value){

		$relevant_keys = [
			'campaign_facebook',
			'campaign_instagram',
			'campaign_youtube',
			'campaign_website'
		];

		if (!in_array($meta_key, $relevant_keys)){
			return false;
		}

		if (has_post_thumbnail($post_id)){
			return false;
		}

		$embed = new Embed();

		try {
			$info = $embed->get($meta_value);
			$image_url = (string) $info->image;
		} catch (\Embed\Http\NetworkException $e) {
			$msg = $e->getMessage();
			error_log($msg);
			return false;
		}

		error_log('Image URL is: ' . $image_url);

		if ($image_url){

			self::update_featured_image_by_url($post_id, $image_url);

		}
		else {
			error_log('Could not get image URL using embed\embed');
		}

	}

	public static function update_featured_image_by_url($post_id, $image_url){

		$attachment_id = FileDownloader::create_attachment_from_url($image_url);

		if (is_wp_error($attachment_id)){
			error_log(print_r($attachment_id));
			return false;
		}

		return set_post_thumbnail($post_id, $attachment_id);

	}


}