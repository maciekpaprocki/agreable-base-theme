<?php
class TroisiemeReusableWidgetService {
  public static function getWidget($widgetSlug) {
    $args = array(
      'name' => $widgetSlug,
      'post_type'   => 'reusable_widget',
      'numberposts' => 1
    );
    $my_posts = get_posts($args);

    if ($my_posts) {
      $post = new TimberPost($my_posts[0]->ID);
      if ($post) {
        return $post->get_field('widget')[0];
      }
    }

    return null;
  }
}