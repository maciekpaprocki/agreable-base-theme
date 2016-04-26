<?php
class AgreableWidgetService {

  protected static $widget_occurrences = [];

  public static function get_widget_by_name_from_post($post, $widget_name, $return_multiple_matching = false) {

    $matched_widgets = [];
    foreach($post->get_field('widgets') as $widget) {
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

  public static function check_widget_exists($post, $widget_name) {
    if (self::get_widget_by_name_from_post($post, $widget_name)) {
      return true;
    }
    return false;
  }

  public static function get_widget_occurrence($post, $widget) {
    if (!isset(self::$widget_occurrences[$post->ID])) {
      self::$widget_occurrences[$post->ID] = [];
    }

    if (!isset(self::$widget_occurrences[$post->ID][$widget['acf_fc_layout']])) {
      self::$widget_occurrences[$post->ID][$widget['acf_fc_layout']] = 1;
    } else {
      self::$widget_occurrences[$post->ID][$widget['acf_fc_layout']]++;
    }

    return self::$widget_occurrences[$post->ID][$widget['acf_fc_layout']];
  }
}
