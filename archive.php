<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.2
 */

/**
 *
 * Redirect archive.php to page.php due to same widget system populating both types
 *
 */

$context = Timber::get_context();
$post = new TimberTerm();
$context['post'] = $post;
include __DIR__ . '/page.php';
