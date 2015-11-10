<?php

include_once "WidgetLoader.php";

$articleWidgets = WidgetLoader::findByUsage('partnership-post');

register_field_group(array (
  'key' => 'partnership_widgets_group',
  'title' => 'Body',
  'fields' => array (
    array (
      'key' => 'partnership_widgets',
      'label' => 'Article Widgets',
      'name' => 'partnership_widgets',
      'prefix' => '',
      'type' => 'flexible_content',
      'instructions' => 'The body of the article is built up with widgets',
      'required' => 1,
      'conditional_logic' => 0,
      'button_label' => 'Add Widget',
      'min' => 1,
      'max' => '',
      'layouts' => $articleWidgets,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'partnership-post',
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
    1 => 'discussion',
    2 => 'comments',
  )
));

