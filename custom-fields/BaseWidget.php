<?php
class BaseWidget {
  public static function addWidgetDeviceTargetting($widgetConfig) {
    $displayOnDevices = array (
      'key' => $widgetConfig["key"] . '_device_targetting',
      'label' => 'Display on devices',
      'name' => 'display_on_devices',
      'prefix' => '',
      'type' => 'checkbox',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
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

    $widgetConfig["sub_fields"][] = $displayOnDevices;
    return $widgetConfig;
  }
}