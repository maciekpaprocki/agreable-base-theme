<?php
$key = 'article_header_group';
$acf_groups = acf_get_local_field_groups($key);
foreach($acf_groups as $group){
  // Aready defined in app theme.
  if($group['key'] === $key){
    return false;
  }
}

if( function_exists('register_field_group') ):

$header_acf = array (
  'key' => $key,
  'title' => 'Header',
  'fields' => array (
    array (
      'key' => $key . '_type',
      'label' => 'Type',
      'name' => 'type',
      'prefix' => '',
      'type' => 'select',
      'instructions' => 'Select the type of header for this content',
      'required' => 1,
      'choices' => array (
        'standard-hero' => 'Standard Hero',
        'super-hero' => 'Super Hero'
      ),
      'default_value' => array (
        'standard-hero' => 'standard-hero',
      ),
    ),
    array (
      'key' => $key . '_display_options',
      'label' => 'Display options',
      'name' => 'display_options',
      'type' => 'true_false',
      'instructions' => '',
      'wrapper' => array (
        'class' => '',
      ),
      'readonly' => 1,
      'layout' => 'vertical',
      'default_value' => 0,
    ),
    array (
      'key' => $key . '_display_headline',
      'label' => 'Show Headline',
      'name' => 'show_headline',
      'prefix' => '',
      'type' => 'true_false',
      'instructions' => 'Whether the headline is displayed on the site for this article.',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => $key . '_display_options',
            'operator' => '==',
            'value' => '1',
          ),
          array (
            'field' => $key . '_type',
            'operator' => '==',
            'value' => 'standard-hero',
          ),
        ),
      ),
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
  ),
  'menu_order' => 8,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
);

$header_acf = apply_filters('agreable_base_theme_header_acf', $header_acf);
register_field_group($header_acf);

endif;
