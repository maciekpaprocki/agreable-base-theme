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

register_field_group(array (
  'key' => $key,
  'title' => 'Basic Details',
  'fields' => array (
    array (
      'key' => 'article_basic_short_headline',
      'label' => 'Short Headline',
      'name' => 'short_headline',
      'prefix' => '',
      'type' => 'text',
      'instructions' => 'A concise heading used when space is limited for example in Related Content or Homepage grids.',
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
      'instructions' => 'Summary to entice the reader to view the full article.',
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
      'key' => 'article_basic_hero_images',
      'label' => 'Hero image(s)',
      'name' => 'hero_images',
      'prefix' => '',
      'type' => 'gallery',
      'instructions' => 'One or more images that will be at the top of the article. Multiple images will automaticall create a carousel. The first image will be used as the tease image in grids of articles.',
      'required' => 1,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => '',
        'id' => '',
      ),
      'min' => '',
      'max' => '',
      'preview_size' => 'thumbnail',
      'library' => 'all',
    ),
    array(
      'key' => 'article_basic_show_hero_settings',
      'label' => 'Show hero customisations',
      'name' => 'show_hero_settings',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '',
        'class' => 'extra-widget-settings',
        'id' => '',
      ),
      'choices' => array (
        '' => '',
      ),
      'default_value' => 0,
      'layout' => 'vertical',
    ),
    array (
      'key' => 'article_basic_hero_default_crop',
      'label' => 'Default crop',
      'name' => 'article_basic_hero_default_crop',
      'prefix' => '',
      'type' => 'select',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'article_basic_show_hero_settings',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        'square' => 'Square',
        'portrait' => 'Portrait',
        'landscape' => 'Landscape',
        'letterbox' => 'Letterbox'
      ),
      'default_value' => 'landscape',
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'ajax' => 0,
      'placeholder' => '',
      'disabled' => 0,
      'readonly' => 0,
    ),
    array(
      'key' => 'article_basic_hero_show_chevrons',
      'label' => 'Show next and previous buttons',
      'name' => 'hero_show_buttons',
      'type' => 'true_false',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => array (
        array (
          array (
            'field' => 'article_basic_show_hero_settings',
            'operator' => '==',
            'value' => '1',
          ),
        ),
      ),
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
      'choices' => array (
        '' => '',
      ),
      'default_value' => 1,
      'layout' => 'vertical',
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
        'article' => 'Standard Article',
        'gallery' => 'Gallery'
      ),
      'default_value' => array (
        'article' => 'article',
      ),
      'allow_null' => 0,
      'multiple' => 0,
      'ui' => 0,
      'ajax' => 0,
      'placeholder' => '',
      'disabled' => 0,
      'readonly' => 0,
    ),
    array (
      'key' => 'article_promo_start_time',
      'label' => 'Promo Start Date & Time',
      'name' => 'start_time',
      'prefix' => '',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => 'acf-hide',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 1,
      'disabled' => 0,
    ),
    array (
      'key' => 'article_promo_end_time',
      'label' => 'Promo End Date & Time',
      'name' => 'end_time',
      'prefix' => '',
      'type' => 'text',
      'instructions' => '',
      'required' => 0,
      'conditional_logic' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => 'acf-hide',
        'id' => '',
      ),
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'maxlength' => '',
      'readonly' => 1,
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
