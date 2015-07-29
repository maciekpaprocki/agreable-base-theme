<?php
$key = 'article_related_group';
$acf_groups = acf_get_local_field_groups($key);
foreach($acf_groups as $group){
  // Aready defined in app theme.
  if($group['key'] === $key){
    return false;
  }
}

if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => $key,
  'title' => 'Related Articles',
  'fields' => array (
    array (
      'key' => 'article_related_limit',
      'label' => 'Amount of items',
      'name' => 'related_limit',
      'type' => 'number',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '6',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'article_related_lists',
      'label' => 'Lists',
      'name' => 'related_lists',
      'prefix' => '',
      'type' => 'post_object',
      'instructions' => 'Add a List of content to add if any of the manual related articles are unavailable. ',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'post_type' => array (
        0 => 'list',
      ),
      'taxonomy' => '',
      'allow_null' => 0,
      'multiple' => 1,
      'return_format' => 'object',
      'ui' => 1,
    ),
    array (
      'key' => 'article_related_posts_manual',
      'label' => 'Manually insert content (Posts or Tiles)',
      'name' => 'related_posts',
      'prefix' => '',
      'type' => 'post_object',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'post_type' => array (
        0 => 'post',
        1 => 'tile',
      ),
      'taxonomy' => '',
      'allow_null' => 0,
      'multiple' => 1,
      'return_format' => 'object',
      'ui' => 1,
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
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
