<?php
class TroisiemeArticleService {
  public static function isLive($post) {
    $liveTimestamp = get_field('live_date', $post);
    $expiryTimestamp = get_field('expiry_date', $post);

    $nowTimestamp = strtotime(date('Ymd H:i:s'));

    if ($liveTimestamp && $nowTimestamp < $liveTimestamp) {
      return false;
    }

    if ($expiryTimestamp && $nowTimestamp > $expiryTimestamp) {
      return false;
    }

    return true;
  }

  public static function getGalleryItemCount($post) {
    foreach($post->get_field('article_widgets') as $widget) {
      if ($widget['acf_fc_layout'] === 'gallery') {
        return count($widget['gallery_items']);
      }
    }
    return 0;
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