<?php
class BaseWidget {
  public static function add_extras($widget_config) {

    $widget_config["sub_fields"][] = array (
      'key' => $widget_config["key"] . '_hide_widget_from_page',
      'label' => 'Hide this widget from display',
      'name' => 'hide_widget_from_page',
      'type' => 'true_false',
      'default_value' => 0,
      'layout' => 'vertical',
    );

    return apply_filters('add_custom_advanced_settings', $widget_config);
  }
}
