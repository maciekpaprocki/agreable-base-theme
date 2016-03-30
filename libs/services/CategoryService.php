<?php

class AgreableCategoryService {

  /**
   * Helper function to organise parent/child categories
   */
  public static function get_post_category_hierarchy($post) {

    $post_categories = \wp_get_post_categories($post->id);
    $hierarchy_categories = new stdClass();
    $hierarchy_categories->child = null;
    $hierarchy_categories->parent = null;

    foreach($post_categories as $c) {
      $cat = get_category($c);
      $category = new stdClass();
      $category->id = $cat->id;
      $category->name = $cat->name;
      $category->slug = $cat->slug;

      if ($cat->parent) { // This is a child category
        $hierarchy_categories->child = $category;
      } else {
        $hierarchy_categories->parent = $category;
      }
    }

    return apply_filters('agreable_category_hierarchy_filter', $hierarchy_categories);
  }
}
