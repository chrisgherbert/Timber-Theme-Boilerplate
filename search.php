<?php
/**
 * Search results page
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$templates = ['search.twig', 'archive.twig', 'index.twig'];
$context = Timber::context();

$context['title'] = 'Search results for '. get_search_query();
$context['posts'] = Timber::get_posts(false);
$context['pagination'] = Timber::get_pagination();

Timber::render( $templates, $context );
