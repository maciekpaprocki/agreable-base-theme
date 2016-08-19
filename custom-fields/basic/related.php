<?php
$key = 'related';

$show_related_conditional = array (
  array (
    array (
      'field' => $key . '_show_related_content',
      'operator' => '==',
      'value' => '1',
    ),
  ),
);

$related_acf = array (
  'key' => $key . '_group',
  'title' => 'Related Content',
  'fields' => array (
    array (
      'key' => $key . '_show_related_content',
      'label' => 'Show Related Content',
      'name' => $key . '_show',
      'type' => 'true_false',
      'instructions' => 'Whether related content is displayed at the end of this content.',
      'default_value' => 1,
      'wrapper' => array (
        'width' => '50%'
      ),
    ),
    array (
      'key' => $key . '_limit',
      'label' => 'Amount of items',
      'name' => $key . '_limit',
      'type' => 'number',
      'conditional_logic' => array (
        array (
          array (
            'field' => $key . '_show_related_content',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
      'default_value' => '6',
      'wrapper' => array (
        'width' => '50%'
      ),
    ),
    array (
      'key' => $key . '_lists',
      'label' => 'Lists',
      'name' => $key . '_lists',
      'type' => 'post_object',
      'instructions' => 'Add a List to populate the related content',
      'conditional_logic' => $show_related_conditional,
      'post_type' => array (
        0 => 'list',
      ),
      'multiple' => 1,
      'return_format' => 'object',
    ),
    array (
      'key' => $key . '_posts_manual',
      'label' => 'Manually insert content (Posts, Tiles, etc.)',
      'name' => $key . '_manual_posts',
      'type' => 'post_object',
      'required' => 0,
      'conditional_logic' => $show_related_conditional,
      'post_type' => array (
        0 => 'post',
        1 => 'tile',
      ),
      'multiple' => 1,
      'return_format' => 'object',
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'post',
      ),
    ),
  ),
  'menu_order' => 8,
  'label_placement' => 'top',
  'instruction_placement' => 'label',
);

$related_acf = apply_filters('agreable_base_theme_related_acf', $related_acf, $key);
register_field_group($related_acf);
