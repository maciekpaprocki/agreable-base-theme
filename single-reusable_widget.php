<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

require_once "libs/services/ArticleService.php";
require_once "libs/services/ReusableWidgetService.php";

$context = Timber::get_context();
$post = new TimberPost();

$context['widget'] = $post->get_field('widget')[0];
Timber::render('reusable-widget.twig', $context);
