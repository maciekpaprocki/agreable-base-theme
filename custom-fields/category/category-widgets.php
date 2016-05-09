<?php
if(!function_exists('register_field_group') ) {
  return;
}

$contextType = "category";
include_once __DIR__ . "/../WidgetLoader.php";

$widget_layouts_main = WidgetLoader::findByUsage("category", "main");
$widget_layouts_sidebar = WidgetLoader::findByUsage("category", "sidebar");

$category_widgets_acf = array(
  'key' => 'category_widgets_group',
  'title' => 'Category widgets',
  'fields' => array (
    array (
      'key' => 'category_widgets',
      'label' => 'Category Widgets',
      'name' => 'widgets',
      'prefix' => '',
      'type' => 'flexible_content',
      'instructions' => 'The widgets that make up this category',
      'required' => 0,
      'button_label' => 'Add Widget',
      'min' => 1,
      'layouts' => $widget_layouts_main,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'taxonomy',
        'operator' => '==',
        'value' => 'category',
      ),
    ),
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'page',
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

);

$category_widgets_acf = apply_filters('agreable_base_theme_category_widgets_acf', $category_widgets_acf);
register_field_group($category_widgets_acf);
