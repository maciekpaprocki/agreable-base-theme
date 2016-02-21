<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/views/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

if (!isset($context)) {
  $context = Timber::get_context();
  $post = new TimberPost();
  $context['category'] = get_category_by_slug('home');
  $context['post'] = $post;
} else {
  $context['category'] = $post;
}

if (!isset($_GET['format'])) {
  $_GET['format'] = 'html';
}

if ($_GET["format"] === 'json') {
  if (isset($_GET['currentPage'])) {
    $currentPage = $_GET['currentPage'];
  } else {
    $currentPage = 1;
  }
  require_once 'libs/services/ApiService.php';
  return AgreableApiService::handleRequest("section", $post, $currentPage);
}

// A category archive page with no widgets gets populated
// with latest posts from this category.
if($post->object_type === 'term'){

  $term = new TimberTerm($post->ID);

  if(!$term->rows || (isset($term->rows[0]['widgets']) && $term->rows[0]['widgets'] === false)) {
    // 'manual_posts' is the variable being accessed by the Grid widget.
    $context['manual_posts'] = Timber::get_posts();
    Timber::render('category-default.twig', $context, false);
    return;
  }
}

if ($_GET['format'] === 'widgets-only') {
  Timber::render('partials/section-widgets.twig', $context, false);
} else {
  Timber::render(['page-' . $post->ID . '.twig', 'page-' . $post->slug . '.twig', 'page.twig'], $context, false);
}
