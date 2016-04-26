<?php
include_once __DIR__ . "/../WidgetLoader.php";

$content_widgets = WidgetLoader::findByUsage("post");

$widgets_acf = array(
  'key' => 'widgets_group',
  'title' => 'Body',
  'fields' => array (
    array (
      'key' => 'article_widgets',
      'label' => 'Content Widgets',
      'name' => 'widgets',
      'prefix' => '',
      'type' => 'flexible_content',
      'instructions' => 'The body of the content is built up of widgets',
      'required' => 1,
      'button_label' => 'Add Widget',
      'min' => 1,
      'layouts' => $content_widgets,
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
);

$widgets_acf = apply_filters('agreable_base_theme_widgets_acf', $widgets_acf);
register_field_group($widgets_acf);

