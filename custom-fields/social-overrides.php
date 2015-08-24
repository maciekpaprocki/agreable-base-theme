<?php
$key = 'social_overrides';
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
  'title' => 'Social Media',
  'fields' => array (
    array (
      'key' => 'social_title',
      'label' => 'Share Title',
      'name' => 'share_title',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Leave blank to use Headline. Visible when sharing on Facebook, Google+ and Twitter.',
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
      'key' => 'social_description',
      'label' => 'Share Description',
      'name' => 'share_description',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Leave blank to use Sell. Visible when sharing on Facebook, Google+ and Twitter.',
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
      'key' => 'social_share_image',
      'label' => 'Share Image',
      'name' => 'share_image',
      'type' => 'image',
      'instructions' => 'Leave unset to use the first Hero image, or the global share image. Upload the largest possible image.',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'return_format' => 'array',
      'preview_size' => 'full',
      'library' => 'all',
      'min_width' => 800,
      'min_height' => 400,
      'min_size' => '',
      'max_width' => 3000,
      'max_height' => 1000,
      'max_size' => '',
      'mime_types' => '',
    ),
    array (
      'key' => 'social_twitter_text',
      'label' => 'Twitter Text',
      'name' => 'twitter_text',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Leave blank to use Headline or Share Title. Visible as a pre-composed Tweet when user clicks Twitter button.',
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
  'menu_order' => 5,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => '',
));

endif;