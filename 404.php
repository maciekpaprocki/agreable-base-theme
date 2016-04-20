<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();

$post = get_page_by_path('not-found',OBJECT, 'page');

if ($post){
  $timber_post = new TimberPost($post->ID);
  $context['post'] = $timber_post;
  Timber::render('page.twig', $context);
} else {
  Timber::render( '404.twig', $context );
}
