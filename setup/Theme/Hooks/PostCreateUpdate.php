<?php

namespace Theme\Hooks;

use Embed\Embed;
use chrisgherbert\WordpressImageDownload\WordpressImageDownload;

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

		$post = new \Content\Candidate($post_id);

		if (has_post_thumbnail($post_id)){
			return false;
		}

		$embed = new Embed();
		$info = $embed->get($meta_value);
		$image_url = (string) $info->image;

		if ($image_url){

			$downloader = new WordpressImageDownload($image_url);

			$attachment_id = $downloader->create_media_attachment();

			if ($attachment_id){
				return set_post_thumbnail($post_id, $attachment_id);
			}

		}
		else {
			error_log('Could not get image URL using embed\embed');
		}

	}

	public static function update_featured_image_by_url($post_id, $image_url){

		$downloader = new WordpressImageDownload($image_url);

		$attachment_id = $downloader->create_media_attachment();

		if ($attachment_id){
			return set_post_thumbnail($post_id, $attachment_id);
		}

	}


}