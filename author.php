<?php
/**
 * The template for displaying Author Archive pages
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

use Timber\Timber;

global $wp_query;

$data = Timber::context();

if ( isset( $wp_query->query_vars['author'] ) ) {
	$author = new TimberUser( $wp_query->query_vars['author'] );
	$data['author'] = $author;
	$data['title'] = 'Author Archives: ' . $author->name();
}

Timber::render( ['author.twig', 'archive.twig'], $data );