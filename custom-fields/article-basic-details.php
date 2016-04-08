<?php
$key = 'article_basic_group';
$acf_groups = acf_get_local_field_groups($key);
foreach($acf_groups as $group){
  // Aready defined in app theme.
  if($group['key'] === $key){
    return false;
  }
}

if( function_exists('register_field_group') ):

$article_basic_acf = array (
  'key' => $key,
  'title' => 'Basic Details',
  'fields' => array (
    array (
      'key' => 'article_basic_short_headline',
      'label' => 'Short Headline',
      'name' => 'short_headline',
      'type' => 'text',
      'instructions' => 'A concise heading used when space is limited for example in Related Content or Homepage grids.',
      'required' => 1,
      'placeholder' => 'This is my short headline',
      'maxlength' => '100',
    ),
    array (
      'key' => 'article_basic_sell',
      'label' => 'Sell',
      'name' => 'sell',
      'type' => 'text',
      'instructions' => 'Summary to entice the reader to view the full article.',
      'required' => 1,
      'maxlength' => 160,
    ),
    array (
      'key' => 'article_basic_hero_images',
      'label' => 'Image(s)',
      'name' => 'hero_images',
      'type' => 'gallery',
      'instructions' => 'One or more images that will be at the top of the article. Multiple images will automaticall create a carousel. The first image will be used as the tease image in grids of articles.',
      'required' => 1,
    ),
    array (
      'key' => 'article_override_start_time',
      'label' => 'Override Start Date & Time',
      'name' => 'override_start_time',
      'type' => 'text',
      'wrapper' => array (
        'class' => 'acf-hide',
      ),
    ),
    array (
      'key' => 'article_override_end_time',
      'label' => 'Override End Date & Time',
      'name' => 'override_end_time',
      'type' => 'text',
      'wrapper' => array (
        'class' => 'acf-hide',
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
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'the_content',
  ),
);

$article_basic_acf = apply_filters('agreable_base_theme_article_basic_acf', $article_basic_acf);
register_field_group($article_basic_acf);

endif;
