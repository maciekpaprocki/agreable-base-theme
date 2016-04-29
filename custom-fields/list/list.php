<?php
if( function_exists('register_field_group') ):

$list_acf = array(
  'key' => 'list_group',
  'title' => 'List',
  'fields' => array (
    array (
      'key' => 'list_categories_configuration',
      'label' => 'Filter categories type',
      'name' => 'categories_configuration',
      'type' => 'select',
      'instructions' => '',
      'required' => 1,
      'choices' => array (
        'manual' => 'Manual selection of categories',
        'current-category' => 'Include only from the current category',
        'current-category-and-children' => 'Current Category and children',
      ),
    ),
    array (
      'key' => 'list_categories',
      'label' => 'Categories',
      'name' => 'categories',
      'type' => 'taxonomy',
      'instructions' => 'Which categories to filter?',
      'required' => 0,
      'conditional_logic' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'list_categories_configuration',
            'operator' => '==',
            'value' => 'manual',
          ),
        ),
      ),
      'taxonomy' => 'category',
      'field_type' => 'multi_select',
      'load_save_terms' => 0,
      'return_format' => 'id',
    ),
    array (
      'key' => 'list_post_type_configuration',
      'label' => 'Filter by type of content',
      'name' => 'post_type_configuration',
      'type' => 'select',
      'instructions' => 'Which types of content do you want to include?',
      'required' => 1,
      'choices' => array (
        'current' => 'Include only the current content type',
        'manual' => 'Manually select which content types to include'
      ),
    ),
    array (
      'key' => 'list_post_types',
      'label' => 'Select content types',
      'name' => 'post_types',
      'type' => 'post_type_selector',
      'instructions' => 'Select which types of content this List includes',
      'required' => 1,
      'select_type' => 2,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'list_post_type_configuration',
            'operator' => '==',
            'value' => 'manual',
          ),
        ),
      ),
    ),
    array (
      'key' => 'list_limit',
      'label' => 'Limit',
      'name' => 'limit',
      'type' => 'number',
      'instructions' => 'Leave blank for unlimited',
      'conditional_logic' => 0,
      'default_value' => 50,
      'min' => 1,
      'max' => 1000,
    ),
    array (
      'key' => 'list_order',
      'label' => 'Order',
      'name' => 'order',
      'type' => 'select',
      'instructions' => 'In which order does the content populate?',
      'required' => 0,
      'choices' => array (
        'newest' => 'Newest first',
        'oldest' => 'Recent first'
      ),
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
  'hide_on_screen' => array (
    0 => 'comments',
    1 => 'discussion',
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
