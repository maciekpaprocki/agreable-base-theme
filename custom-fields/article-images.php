<?php
$key = 'article_images_group';
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
  'title' => 'Images',
  'fields' => array (
    array (
      'key' => 'article_images',
      'label' => 'Images',
      'name' => 'images',
      'prefix' => '',
      'type' => 'repeater',
      'instructions' => '',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'min' => '',
      'max' => '',
      'layout' => 'table',
      'button_label' => 'Add Image',
      'sub_fields' => array (
        array (
          'key' => 'article_images_image',
          'label' => 'Image',
          'name' => 'image',
          'prefix' => '',
          'type' => 'image',
          'instructions' => '',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'return_format' => 'array',
          'preview_size' => 'thumbnail',
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
          'key' => 'article_images_usage',
          'label' => 'Usage',
          'name' => 'usage',
          'prefix' => '',
          'type' => 'checkbox',
          'instructions' => 'Tick if the image should appear in the Hero Image carousel',
          'required' => 1,
          'conditional_logic' => 0,
          'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
          ),
          'choices' => array (
            'hero' => 'Hero',
            'thumbnail' => 'Thumbnail',
            'social' => 'Social',
          ),
          'default_value' => array (
            '' => '',
          ),
          'layout' => 'vertical',
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
  ),
  'menu_order' => 1,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;
