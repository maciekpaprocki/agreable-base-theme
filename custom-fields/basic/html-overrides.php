<?php
$key = 'html_overrides';

$html_overrides_acf = array (
  'key' => $key . '_group',
  'title' => 'Developers',
  'fields' => array (
    array (
      'key' => $key . '_allow',
      'label' => 'Add custom HTML/CSS/JS to this content?',
      'name' => 'allow',
      'type' => 'true_false',
      'instructions' => 'Please ask a developer before making any changes',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'message' => '',
      'default_value' => 0,
    ),
    array (
      'key' => $key . '_html',
      'label' => 'Custom HTML',
      'name' => 'html',
      'type' => 'textarea',
      'instructions' => 'Add HTML/CSS/JS',
      'conditional_logic' => array (
        array (
          array (
            'field' => $key . '_allow',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
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
        'value' => 'page',
      ),
    ),
  ),
  'menu_order' => 15,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
);

$html_overrides_acf = apply_filters('agreable_base_theme_html_media_acf', $html_overrides_acf);
register_field_group($html_overrides_acf);