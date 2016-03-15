<?php
$key = 'page_basic_group';
$acf_groups = acf_get_local_field_groups($key);
foreach($acf_groups as $group){
  // Aready defined in app theme.
  if($group['key'] === $key){
    return false;
  }
}

if( function_exists('register_field_group') ):

$page_basic_options_acf = array(
  'key' => $key,
  'title' => 'Basic Details',
  'fields' => array (
    array (
      'key' => 'page_basic_short_headline',
      'label' => 'Short Headline',
      'name' => 'short_headline',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'A concise heading used when space is limited for example in Related Content or Homepage grids.',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 0,
      'disabled' => 0,
    ),
    array (
      'key' => 'page_basic_sell',
      'label' => 'Sell',
      'name' => 'sell',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Summary to entice the reader to view the full page.',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => 160,
      'readonly' => 0,
      'disabled' => 0,
    ),
  ),
  'location' => array (
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
  ),
);

$page_basic_options_acf = apply_filters('agreable_base_theme_page_basic_options_acf', $page_basic_options_acf);
register_field_group($page_basic_options_acf);

endif;
