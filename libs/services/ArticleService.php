<?php
class AgreableArticleService {

  public static function getGalleryItemCount($post) {
    foreach($post->get_field('article_widgets') as $widget) {
      if ($widget['acf_fc_layout'] === 'gallery') {
        return count($widget['gallery_items']);
      }
    }
    return 0;
  }

  public static function getWidgetFromPost($post, $widget_name, $post_type) {
    if ($post_type == NULL) {
      return false;
    }
    foreach($post->get_field($post_type) as $widget) {
      if ($widget['acf_fc_layout'] === $widget_name) {
        return true;
      }
    }
    return false;
  }

  protected static function getWidgetFromSystemPage($systemPostId) {
    $page = new TimberPost($systemPostId); // Load the page which contains the widget
    if ($page->post_title && count($page->widget) === 1) {

      return $page->get_field('widget')[0];
    }
    return null;
  }

  public static function getRelativePath($permalink) {
    $matches = [];
    preg_match_all('/http:\/\/[^\/]*(.*)/', $permalink, $matches);
    if (count($matches) === 2) {
      return $matches[1][0];
    }
    return;
  }
}
