<?php

$labels = array(
  'name'                => _x('Reusable Widgets', 'Post Type General Name', 'text_domain'),
  'singular_name'       => _x('Reusable Widget', 'Post Type Singular Name', 'text_domain'),
  'menu_name'           => __('Reusable Widgets', 'text_domain'),
  'parent_item_colon'   => __('Parent Item:', 'text_domain'),
  'all_items'           => __('All Reusable Widgets', 'text_domain'),
  'view_item'           => __('View Reusable Widget', 'text_domain'),
  'add_new_item'        => __('Add New Reusable Widget', 'text_domain'),
  'add_new'             => __('Add New', 'text_domain'),
  'edit_item'           => __('Edit Reusable Widget', 'text_domain'),
  'update_item'         => __('Update Reusable Widget', 'text_domain'),
  'search_items'        => __('Search Reusable Widgets', 'text_domain'),
  'not_found'           => __('Not found', 'text_domain'),
  'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
);
$args = array(
  'description'         => __('Widgets that can be reused across the site', 'text_domain'),
  'labels'              => $labels,
  'supports'            => array('title'),
  'taxonomies'          => array(),
  'hierarchical'        => false,
  'public'              => true,
  'show_ui'             => true,
  'show_in_menu'        => true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 7,
  'menu_icon'           => 'dashicons-networking',
  'can_export'          => true,
  'has_archive'         => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
);

register_post_type('reusable_widget', $args);
