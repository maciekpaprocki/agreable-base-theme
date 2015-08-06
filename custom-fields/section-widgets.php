<?php
if(!function_exists('register_field_group') ) {
  return;
}

$contextType = "section";
include_once "WidgetLoader.php";

$widget_layouts_main = WidgetLoader::findByUsage("section", "main");
$widget_layouts_sidebar = WidgetLoader::findByUsage("section", "sidebar");

if(get_field('enable_sidebar', 'option')){
  register_field_group(array (
    'key' => 'section_widgets_group',
    'title' => 'Section widgets',
    'fields' => array (
      array (
        'key' => 'section_widgets_rows',
        'label' => 'Rows',
        'name' => 'rows',
        'prefix' => '',
        'type' => 'flexible_content',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'button_label' => 'Add row',
        'min' => 1,
        'max' => '',
        'layouts' => array (
          array (
            'key' => 'section_widgets_rows_main',
            'name' => 'section_widgets_rows_main',
            'label' => 'Widgets row (main)',
            'display' => 'block',
            'sub_fields' => array (
              array (
                'key' => 'section_widgets_rows_main_widget',
                'label' => 'Widget',
                'name' => 'widgets',
                'prefix' => '',
                'type' => 'flexible_content',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'button_label' => 'Add widget',
                'min' => 1,
                'max' => 100,
                'layouts' => $widget_layouts_main
              ),
            ),
            'min' => '',
            'max' => '',
          ),
          array (
            'key' => 'section_widgets_rows_sidebar',
            'name' => 'section_widgets_rows_sidebar',
            'label' => 'Widget row (with sidebar)',
            'display' => 'block',
            'sub_fields' => array (
              array (
                'key' => 'section_widgets_rows_sidebar_2col_widget',
                'label' => 'Widget (2 column)',
                'name' => 'widget_main',
                'prefix' => '',
                'type' => 'flexible_content',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                  'width' => '60%',
                  'class' => '',
                  'id' => '',
                ),
                'button_label' => 'Add widget (2 column)',
                'min' => 1,
                'max' => 100,
                'layouts' => $widget_layouts_main
              ),
              array (
                'key' => 'section_widgets_rows_sidebar_1col_widget',
                'name' => 'widget_sidebar',
                'label' => 'Widget (1 column)',
                'prefix' => '',
                'type' => 'flexible_content',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array (
                  'width' => 40,
                  'class' => '',
                  'id' => '',
                ),
                'button_label' => 'Add widget (1 column)',
                'min' => 1,
                'max' => 100,
                'layouts' => $widget_layouts_sidebar
              ),
            ),
            'min' => '',
            'max' => '',
          ),
        ),
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

  ));
}else{
  register_field_group(array (
    'key' => 'section_widgets_group',
    'title' => 'Section widgets',
    'fields' => array (
      array (
        'key' => 'section_widgets_rows',
        'label' => 'Rows',
        'name' => 'rows',
        'prefix' => '',
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
          'width' => '',
          'class' => '',
          'id' => '',
        ),
        'button_label' => 'Add row',
        'min' => 1,
        'max' => '',
        'sub_fields' => array (
              array (
                'key' => 'section_widgets_rows_main_widget',
                'label' => '',
                'name' => 'widgets',
                'prefix' => '',
                'type' => 'flexible_content',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                  'width' => '',
                  'class' => '',
                  'id' => '',
                ),
                'button_label' => 'Add widget',
                'min' => 1,
                'max' => 100,
                'layouts' => $widget_layouts_main
              ),
            ),
        'layout' => 'block',
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

  ));
}