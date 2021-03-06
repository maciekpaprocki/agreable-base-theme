<?php
if( function_exists('register_field_group') ):

$tile_acf = array(
  'key' => 'tile_group',
  'title' => 'Tile',
  'fields' => array (
    array (
      'key' => 'tile_group_sell',
      'label' => 'Sell',
      'name' => 'sell',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Summary to entice the reader to view the full article.',
      'required' => 0,
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
      'key' => 'tile_group_image',
      'label' => 'Image',
      'name' => 'image',
      'prefix' => '',
      'type' => 'image',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'return_format' => 'array',
      'preview_size' => 'medium',
      'library' => 'all',
      'min_width' => 0,
      'min_height' => 0,
      'min_size' => 0,
      'max_width' => 0,
      'max_height' => 0,
      'max_size' => 0,
      'mime_types' => '',
    ),
    array (
      'key' => 'tile_group_url',
      'label' => 'URL',
      'name' => 'url',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Leave blank if you don\'t require a link',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
    ),
  ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'tile',
      ),
    ),
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'permalink',
    1 => 'the_content',
    2 => 'excerpt',
    3 => 'custom_fields',
    4 => 'discussion',
    5 => 'comments',
    6 => 'revisions',
    7 => 'author',
    8 => 'format',
    9 => 'page_attributes',
    10 => 'featured_image',
    11 => 'tags',
    12 => 'send-trackbacks'
  ),
);

$tile_acf = apply_filters('agreable_base_theme_tile_acf', $tile_acf);
register_field_group($tile_acf);


endif;
