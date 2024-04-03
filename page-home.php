<?php
/**
 *  Template Name: Home Page
 */

$context = Timber::context();
$post = Timber::get_post($post->ID);

$context['post'] = $post;

// Pull in current posts
$context['posts'] = Timber::get_posts([
	'post_type' => ['post']
], 'Content\Post');

Timber::render( ['page-' . $post->post_name . '.twig', 'page.twig'], $context, false, TimberLoader::CACHE_NONE );
