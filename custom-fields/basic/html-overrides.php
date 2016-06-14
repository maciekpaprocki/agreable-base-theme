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
    ),
    array (
      'key' => $key . '_html',
      'label' => 'Custom HTML',
      'name' => 'html',
      'type' => 'acf_code_field',
      'placeholder' => 'Enter overrides',
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
      array (
        'param' => 'current_user_role',
        'operator' => '==',
        'value' => 'administrator',
      ),
    ),
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'page',
      ),
      array (
        'param' => 'current_user_role',
        'operator' => '==',
        'value' => 'administrator',
      ),
    ),
  ),
  'menu_order' => 15,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
);

$html_overrides_acf = apply_filters('agreable_base_theme_html_overrides_acf', $html_overrides_acf);
register_field_group($html_overrides_acf);
