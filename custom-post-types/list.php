<?php

$labels = array(
  'name'                => _x('Lists', 'Post Type General Name', 'text_domain'),
  'singular_name'       => _x('List', 'Post Type Singular Name', 'text_domain'),
  'menu_name'           => __('Lists', 'text_domain'),
  'parent_item_colon'   => __('Parent Item:', 'text_domain'),
  'all_items'           => __('All Lists', 'text_domain'),
  'view_item'           => __('View List', 'text_domain'),
  'add_new_item'        => __('Add New List', 'text_domain'),
  'add_new'             => __('Add New', 'text_domain'),
  'edit_item'           => __('Edit List', 'text_domain'),
  'update_item'         => __('Update List', 'text_domain'),
  'search_items'        => __('Search Lists', 'text_domain'),
  'not_found'           => __('Not found', 'text_domain'),
  'not_found_in_trash'  => __('Not found in Trash', 'text_domain'),
);

$args = array(
  'label'               => __('list', 'text_domain'),
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
  'menu_position'       => 6,
  'menu_icon'           => 'dashicons-list-view',
  'can_export'          => true,
  'has_archive'         => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'page',
);

register_post_type('list', $args);