<?php
if( function_exists('register_field_group') ):

register_field_group(array (
  'key' => 'article_basic_group',
  'title' => 'Basic Details',
  'fields' => array (
    array (
      'key' => 'article_basic_short_headline',
      'label' => 'Short Headline',
      'name' => 'short_headline',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'A concise heading used when space is limited.',
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
      'key' => 'article_basic_sell',
      'label' => 'Sell',
      'name' => 'sell',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Summary to entice the reader to view the full article. This will display on many widgets.',
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
    array (
      'key' => 'article_basic_type',
      'label' => 'Article Type',
      'name' => 'article_type',
      'prefix' => '',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        'article' => 'Standard Article'
      ),
      'default_value' => array (
        '' => '',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'ajax' => 0,
      'placeholder' => '',
      'disabled' => 0,
      'readonly' => 0,
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
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'the_content',
  ),
));

endif;
