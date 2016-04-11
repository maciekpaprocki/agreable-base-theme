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
require_once "libs/services/CategoryService.php";

$context = Timber::get_context();
$post = new TimberPost();
$post->author_url = get_author_posts_url( $post->post_author );

$context['post'] = $post;
$context['category_hierarchy'] = AgreableCategoryService::get_post_category_hierarchy($post);

if ( post_password_required( $post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig' ), $context );
}
