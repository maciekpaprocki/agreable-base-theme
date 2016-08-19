<?php
$key = 'social_overrides';

$social_overrides_acf = array (
  'key' => $key . '_group',
  'title' => 'Social Media',
  'fields' => array (
    array (
      'key' => $key . '_title',
      'label' => 'Share Title',
      'name' => 'share_title',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'Leave blank to use Headline. Visible when sharing on Facebook, Google+ and Twitter.',
    ),
    array (
      'key' => $key . '_description',
      'label' => 'Share Description',
      'name' => 'share_description',
      'type' => 'text',
      'instructions' => 'Leave blank to use Sell. Visible when sharing on Facebook, Google+ and Twitter.',
    ),
    array (
      'key' => $key . '_share_image',
      'label' => 'Share Image',
      'name' => 'share_image',
      'type' => 'image',
      'instructions' => 'Leave unset to use the first Hero image, or the global share image. Upload the largest possible image.',
      'return_format' => 'array',
      'preview_size' => 'full',
      'library' => 'all',
      'min_width' => 800,
      'min_height' => 400,
      'min_size' => '',
    ),
    array (
      'key' => $key . '_twitter_text',
      'label' => 'Twitter Text',
      'name' => 'twitter_text',
      'type' => 'text',
      'instructions' => 'Leave blank to use Headline or Share Title. Visible as a pre-composed Tweet when user clicks Twitter button.',
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
);

$social_overrides_acf = apply_filters('agreable_base_theme_social_media_acf', $social_overrides_acf, $key);
register_field_group($social_overrides_acf);
