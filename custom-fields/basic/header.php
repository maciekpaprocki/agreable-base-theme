<?php
$key = 'article_header';

// Reusable conditional
$options_conditional = array (
  array (
    array (
      'field' => $key . '_options',
      'operator' => '==',
      'value' => '1',
    ),
    array (
      'field' => $key . '_type',
      'operator' => '==',
      'value' => 'standard-hero',
    ),
  ),
);

$header_acf = array (
  'key' => $key . '_group',
  'title' => 'Opening Header',
  'fields' => array (
    array (
      'key' => $key . '_type',
      'label' => 'Type',
      'name' => 'type',
      'prefix' => '',
      'type' => 'select',
      'instructions' => 'Select the type of header for this content',
      'required' => 0,
      'choices' => array (
        'standard-hero' => 'Standard Hero',
      ),
      'default_value' => array (
        'standard-hero' => 'standard-hero',
      ),
      'wrapper' => array (
        'width' => '50%'
      ),
    ),
    array (
      'key' => $key . '_options',
      'label' => 'Options',
      'name' => 'options',
      'type' => 'true_false',
      'wrapper' => array (
        'class' => 'extra-widget-settings',
        'width' => '50%'
      ),
      'readonly' => 1
    ),
    array (
      'key' => $key . '_display_headline',
      'label' => 'Display Headline',
      'name' => 'display_headline',
      'prefix' => '',
      'type' => 'true_false',
      'instructions' => 'Whether the headline is displayed on the content or not',
      'conditional_logic' => $options_conditional,
      'default_value' => 1,
    ),
    array (
      'key' => $key . '_display_date',
      'label' => 'Display Date',
      'name' => 'display_date',
      'type' => 'true_false',
      'instructions' => 'Whether the date is displayed on the content or not',
      'conditional_logic' => $options_conditional,
      'default_value' => 1,
    ),
    array (
      'key' => $key . '_display_hero_image',
      'label' => 'Display Hero Image',
      'name' => 'display_hero_image',
      'type' => 'true_false',
      'instructions' => 'Whether the hero image is displayed on the content or not',
      'required' => 0,
      'conditional_logic' => $options_conditional,
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
  'menu_order' => 1,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
);

$header_acf = apply_filters('agreable_base_theme_header_acf', $header_acf);
register_field_group($header_acf);