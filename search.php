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

use Timber\Timber;

$context = Timber::context();

$context['title'] = 'Search results for '. get_search_query();

$templates = ['search.twig', 'archive.twig', 'index.twig'];
Timber::render( $templates, $context );
