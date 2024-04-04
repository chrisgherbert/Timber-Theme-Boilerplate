<?php
/**
 *  Template Name: Home Page
 */

use Timber\Timber;

$context = Timber::context();

// Pull in current posts
$context['posts'] = Timber::get_posts([
	'post_type' => ['post']
]);

Timber::render(['page-' . $post->post_name . '.twig', 'page.twig'], $context);
