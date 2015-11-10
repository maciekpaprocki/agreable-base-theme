<?php
$key = 'article_layout_group';
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
  'title' => 'Layout',
  'fields' => array (
    array (
      'key' => 'article_layout_display_date',
      'label' => 'Show Display Date',
      'name' => 'show_display_date',
      'prefix' => '',
      'type' => 'true_false',
      'instructions' => 'Whether the display date is displayed on the site for this article.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 1,
    ),
    array (
      'key' => 'article_layout_display_hero',
      'label' => 'Show Hero Image',
      'name' => 'show_hero_image',
      'prefix' => '',
      'type' => 'true_false',
      'instructions' => 'Whether the Hero Image is displayed on the site for this article.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 1,
    ),
    array (
      'key' => 'article_layout_display_headline',
      'label' => 'Show Headline',
      'name' => 'show_headline',
      'prefix' => '',
      'type' => 'true_false',
      'instructions' => 'Whether the headline is displayed on the site for this article.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 1,
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
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'partnership-post',
      ),
    ),
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'features-post',
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
