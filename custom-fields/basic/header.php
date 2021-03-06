<?php
$key = 'article_header';


$header_acf = array (
  'key' => $key . '_group',
  'title' => 'Opening Header',
  'fields' => array (
    array (
      'key' => 'header_basic_details_tab',
      'label' => 'Basic Details',
      'type' => 'tab',
      'required' => 0,
      'conditional_logic' => 0,
      'placement' => 'left',
    ),
    array (
      'key' => $key . '_type',
      'label' => 'Header Type',
      'name' => 'header_type',
      'type' => 'select',
      'required' => 0,
      'choices' => array (
        'standard-hero' => 'Standard Hero',
      ),
      'default_value' => array (
        'standard-hero' => 'standard-hero',
      ),
      'wrapper' => array (
        'width' => '100%'
      ),
    ),
    array (
      'key' => 'header_advanced_details_tab',
      'label' => 'Advanced Details',
      'type' => 'tab',
      'required' => 0,
      'conditional_logic' => 0,
      'placement' => 'left',
    ),
    array (
      'key' => $key . '_display_headline',
      'label' => 'Display Headline',
      'name' => 'header_display_headline',
      'type' => 'true_false',
      'instructions' => 'Whether the headline is displayed in the content or not',
      'wrapper' => array (
        'width' => '50%',
      ),
      'default_value' => 1,
    ),
    array (
      'key' => $key . '_display_sell',
      'label' => 'Display Sell',
      'name' => 'header_display_sell',
      'type' => 'true_false',
      'instructions' => 'Whether the sell is displayed in the content or not',
      'wrapper' => array (
        'width' => '50%',
      ),
      'default_value' => 1,
    ),
    array (
      'key' => $key . '_display_date',
      'label' => 'Display Date',
      'name' => 'header_display_date',
      'type' => 'true_false',
      'instructions' => 'Whether the date is displayed in the content or not',
      'wrapper' => array (
        'width' => '50%',
      ),
      'default_value' => 1,
    ),
    array (
      'key' => $key . '_display_hero_image',
      'label' => 'Display Hero Image',
      'name' => 'header_display_hero_image',
      'type' => 'true_false',
      'instructions' => 'Whether the hero image is displayed in the content or not',
      'required' => 0,
      'default_value' => 1,
      'wrapper' => array (
        'width' => '50%',
      ),
      'min_width' => 800,
      'min_height' => 600,
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
);

$header_acf = apply_filters('agreable_base_theme_header_acf', $header_acf, $key);
register_field_group($header_acf);
