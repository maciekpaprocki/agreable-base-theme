<?php
if( function_exists('register_field_group') ):

$list_acf = array(
  'key' => 'list_group',
  'title' => 'List',
  'fields' => array (
    array (
      'key' => 'list_sections',
      'label' => 'Sections',
      'name' => 'sections',
      'prefix' => '',
      'type' => 'taxonomy',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'taxonomy' => 'category',
      'field_type' => 'multi_select',
      'allow_null' => 0,
      'load_save_terms' => 0,
      'return_format' => 'id',
      'multiple' => 0,
    ),
    array (
      'key' => 'list_limit',
      'label' => 'Limit',
      'name' => 'limit',
      'prefix' => '',
      'type' => 'number',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => 50,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 1,
      'max' => 1000,
      'step' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'list_tags',
      'label' => 'Tags',
      'name' => 'tags',
      'prefix' => '',
      'type' => 'taxonomy',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'taxonomy' => 'post_tag',
      'field_type' => 'multi_select',
      'allow_null' => 1,
      'load_save_terms' => 0,
      'return_format' => 'id',
      'multiple' => 0,
    ),
    array (
      'key' => 'list_order',
      'label' => 'Order',
      'name' => 'order',
      'prefix' => '',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        'recent' => 'Recent',
        'popular' => 'Popular',
      ),
      'default_value' => array (
        '' => '',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'ajax' => 0,
      'placeholder' => '',
      'disabled' => 0,
      'readonly' => 0,
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'list',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
);

$list_acf = apply_filters('agreable_base_theme_list_acf', $list_acf);
register_field_group($list_acf);

endif;