<?php
include_once __DIR__ . "/../WidgetLoader.php";

$articleWidgets = WidgetLoader::findByUsage("post");

$widgets_acf = array(
  'key' => 'article_widgets_group',
  'title' => 'Body',
  'fields' => array (
    array (
      'key' => 'article_widgets',
      'label' => 'Article Widgets',
      'name' => 'widgets',
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
        'value' => 'post',
      ),
    )
  ),
  'menu_order' => 2,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'the_content',
    1 => 'discussion',
    2 => 'comments',
  )
);

$widgets_acf = apply_filters('agreable_base_theme_widgets_acf', $widgets_acf);
register_field_group($widgets_acf);

