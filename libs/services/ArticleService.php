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

  public static function getWidgetByNameFromPost($post, $widget_name, $return_multiple_matching = false) {
    $post_type = get_post_type($post);

    switch ($post_type) {
      case 'post':
        $widget_type = 'article_widgets';
        break;
      case 'partnership-post':
        $widget_type = 'partnership_widgets';
        break;
      case 'features-post':
        $widget_type = 'features_widgets';
        break;
      default:
        return false;
    }

    $matched_widgets = [];
    foreach($post->get_field($widget_type) as $widget) {
      if ($widget['acf_fc_layout'] === $widget_name) {
        $matched_widgets[] = $widget;
      }
    }

    if (count($matched_widgets) === 0) {
      return null;
    }

    if ($return_multiple_matching) {
      return $matched_widgets;
    } else {
      return $matched_widgets[0];
    }
  }

  public static function checkWidgetExists($post, $widget_name) {
    if (self::getWidgetByNameFromPost($post, $widget_name)) {
      return true;
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
