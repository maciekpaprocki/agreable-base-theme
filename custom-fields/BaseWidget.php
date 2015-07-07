<?php
class BaseWidget {
  public static function addWidgetDeviceTargetting($widgetConfig) {

    $widgetConfig["sub_fields"][] = array (
      'key' => $widgetConfig["key"] . '_show_advanced_widget_settings',
      'label' => 'Show advanced settings',
      'name' => 'show_advanced_settings',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => 'advanced-widget-settings',
        'id' => '',
      ),
      'choices' => array (
        '' => '',
      ),
      'default_value' => 0,
      'layout' => 'vertical',
    );

    $widgetConfig["sub_fields"][] = array (
      'key' => $widgetConfig["key"] . '_device_targetting',
      'label' => 'Display on devices',
      'name' => 'display_on_devices',
      'prefix' => '',
      'type' => 'checkbox',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => $widgetConfig["key"] . '_show_advanced_widget_settings',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '',
        'class' => 'display-on-devices',
        'id' => '',
      ),
      'choices' => array (
        'mobile' => 'Mobile',
        'tablet' => 'Tablet',
        'desktop' => 'Desktop',
      ),
      'default_value' => array (
        'mobile' => 'mobile',
        'tablet' => 'tablet',
        'desktop' => 'desktop',
      ),
      'layout' => 'vertical',
    );

    return $widgetConfig;
  }
}
