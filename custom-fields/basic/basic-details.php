<?php
$key = 'basic';

$article_basic_acf = array (
  'key' => $key . '_group',
  'title' => 'Basic Details',
  'fields' => array (
    array (
      'key' => $key . '_short_headline',
      'label' => 'Short Headline',
      'name' => 'short_headline',
      'type' => 'text',
      'instructions' => 'A concise heading used when space is limited for example in Related Content or Homepage grids.',
      'required' => 1,
      'placeholder' => 'This is my short headline',
      'maxlength' => '100',
    ),
    array (
      'key' => $key . '_sell',
      'label' => 'Sell',
      'name' => 'sell',
      'type' => 'text',
      'instructions' => 'Summary to entice the reader to view the full article.',
      'required' => 1,
      'maxlength' => 160,
    ),
    array (
      'key' => $key . '_category',
      'label' => 'Category',
      'name' => 'category',
      'type' => 'taxonomy',
      'instructions' => 'Select a category for this content to live in.',
      'required' => 0,
      'taxonomy' => 'category',
      'field_type' => 'select',
      'allow_null' => 0,
      'add_term' => 0,
      'save_terms' => 1,
      'load_terms' => 1,
      'return_format' => 'object',
      'multiple' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
    ),
    array (
      'key' => $key . '_tags',
      'label' => 'Tags',
      'name' => 'tags',
      'type' => 'taxonomy',
      'instructions' => 'Add tags to this post, use uppercase first letter on each word: "Football, Supercars, Premier League"',
      'required' => 0,
      'taxonomy' => 'post_tag',
      'field_type' => 'multi_select',
      'allow_null' => 0,
      'add_term' => 1,
      'save_terms' => 1,
      'load_terms' => 1,
      'return_format' => 'object',
      'multiple' => 0,
      'wrapper' => array (
        'width' => '50%',
        'class' => '',
        'id' => '',
      ),
    ),
    array (
      'key' => $key . '_hero_images',
      'label' => 'Image(s)',
      'name' => 'hero_images',
      'type' => 'gallery',
      'instructions' => 'One or more images that will be at the top of the article. Multiple images will automatically create a carousel. The first image will be used as the tease image in grids of articles.',
      'required' => 1,
      'preview_size' => 'landscape'
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
    array(
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'page',
      ),
    )
  ),
  'menu_order' => 0,
  'position' => 'normal',
  'style' => 'default',
  'label_placement' => 'top',
  'instruction_placement' => 'label',
  'hide_on_screen' => array (
    0 => 'the_content',
    1 => 'categories',
    2 => 'featured_image',
    3 => 'tags'
  ),
);

$article_basic_acf = apply_filters('agreable_base_theme_article_basic_acf', $article_basic_acf, $key);
register_field_group($article_basic_acf);
