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

if (!isset($context)) {
  $context = Timber::get_context();
  $post = new TimberPost();
  $context['category'] = get_category_by_slug('home');
  $context['post'] = $post;
} else {
  $context['category'] = $post;
}

if (isset($_GET["q"])) {
  // require_once 'libs/services/SearchService.php';
  // $context['searchResponse'] = AgreableSearchService::getSearchResults($_GET["q"]);
  // $context['query'] = $_GET["q"];
}
Timber::render('search-results.twig', $context, false);
