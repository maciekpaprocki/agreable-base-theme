<?php
if(!function_exists('register_field_group') ) {
  return;
}

include_once "WidgetLoader.php";

$widgets = WidgetLoader::findByUsage();

register_field_group(array (
  'key' => 'reusable_widgets_group',
  'title' => 'Reusable widgets',
  'fields' => array (
    array (
      'key' => 'reusable_widget',
      'label' => 'Widget',
      'name' => 'widget',
      'prefix' => '',
      'type' => 'flexible_content',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'button_label' => 'Add widget',
      'min' => '1',
      'max' => '1',
      'layouts' => $widgets
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'reusable_widget',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'the_content',
  )

));
