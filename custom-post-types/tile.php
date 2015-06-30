<?php

$labels = array(
  'name'                => _x('Tiles', 'Post Type General Name', 'text_domain'),
  'singular_name'       => _x('Tile', 'Post Type Singular Name', 'text_domain'),
  'menu_name'           => __('Tiles', 'text_domain'),
  'parent_item_colon'   => __('Parent Item:', 'text_domain'),
  'all_items'           => __('All Tiles', 'text_domain'),
  'view_item'           => __('View Tile', 'text_domain'),
  'add_new_item'        => __('Add New Tile', 'text_domain'),
  'add_new'             => __('Add New', 'text_domain'),
  'edit_item'           => __('Edit Tile', 'text_domain'),
  'update_item'         => __('Update Tile', 'text_domain'),
  'search_items'        => __('Search Tiles', 'text_domain'),
  'not_found'           => __('Not found', 'text_domain'),
  'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
);
$args = array(
  'description'         => __('A tile in a grid optionally with link to article or off-site', 'text_domain'),
  'labels'              => $labels,
  'supports'            => array('title'),
  'taxonomies'          => array(),
  'hierarchical'        => false,
  'public'              => true,
  'show_ui'             => true,
  'show_in_menu'        => true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 8,
  'menu_icon'           => 'dashicons-screenoptions',
  'can_export'          => true,
  'has_archive'         => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
);

register_post_type('tile', $args);
