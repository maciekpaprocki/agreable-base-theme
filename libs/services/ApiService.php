<?php
class TroisiemeApiService {
  public static function handleRequest($pageType, $post, $currentPageIndex = 1) {
    header('Content-Type: application/json');

    if ($pageType === 'section') {
      self::handleSectionRequest($post, $currentPageIndex);
    } else {
      self::handleArticleRequest($post);
    }
  }

  protected static function handleSectionRequest($post, $currentPageIndex) {
    $response = new stdClass();
    $response->success = true;
    $response->articles = array();

    // foreach($post->get_field('rows') as $row) {
    //   if ($row->acf_fc_layout == 'section_widgets_rows_sidebar') {
    //     $widgets = $row->widget_main[0];
    //   } else {
    //     $widgets = $row->widgets;
    //   }
    // }

    $mostRecentList = Timber::get_post(928);
    require_once "ListService.php";

    $limit = 50;
    $offset = ($currentPageIndex -1) * $limit;

    $posts = TroisiemeListService::getPosts($mostRecentList, null, $limit, $offset);
    foreach($posts as $post) {
      $response->articles[] = self::getPostAsPlainObject($post);
    }

    // post.get_field('rows')
    echo json_encode($response);
    return;
  }

  protected static function handleArticleRequest($post) {
    $response = new stdClass();
    $response->success = true;
    $response->article = self::getPostAsPlainObject($post);

    echo json_encode($response);
    return;
  }

  public static function getPostAsPlainObject($post) {
    if ($post instanceof WP_Post) {
      $post = new TimberPost($post);
    }
    $data = new stdClass();
    $data->date = $post->post_date;
    $data->date_gmt = $post->post_date_gmt;
    $data->title = $post->post_title;
    $data->status = $post->post_status;
    $data->modified = $post->post_modified;
    $data->modified_gmt = $post->post_modified_gmt;
    $data->id = $post->id;
    $data->slug = $post->slug;

    $data->section = null;
    foreach($post->terms as $term) {
      if ($term->taxonomy === 'category') {
        $category = new stdClass();
        $category->name = $term->name;
        $category->slug = $term->slug;
        $category->id = $term->term_id;
        $data->section = $category;
        if (($parentCategory = get_category($category->id)) && ($parentCategory->slug !== $category->slug)) {
          $data->parentSection = new stdClass();
          $data->parentSection->name = $parentCategory->name;
          $data->parentSection->slug = $parentCategory->slug;
        }

        break;
      }
    }

    if (isset($data->parentSection)) {
      $data->path = '/' . $data->parentSection->slug;
    } else {
      $data->path = '';
    }

    $data->path .= '/' . $data->section->slug . '/' . $data->slug . '/';

    $data->sell = $post->sell;
    // $post->author = $post->author;
    $data->images = array();

    foreach($post->get_field('images') as $imageData) {
      $image = new stdClass();
      $image->title = $imageData['image']['title'];
      $image->alt = $imageData['image']['alt'];
      $image->filename = $imageData['image']['filename'];
      $image->sizes = $imageData['image']['sizes'];
      $image->sizes['Original'] = $imageData['image']['url'];
      $image->sizes['Original-width'] = $imageData['image']['width'];
      $image->sizes['Original-height'] = $imageData['image']['height'];
      $image->usage = $imageData['usage'];
      $data->images[] = $image;
    }

    $data->widgets = array();
    foreach($post->get_field('article_widgets') as $articleWidget) {
      $widget = new stdClass();
      $widget->type = $articleWidget['acf_fc_layout'];
      switch($articleWidget['acf_fc_layout']) {
        case 'html':
          $widget->html = $articleWidget['html'];
          break;
        case 'inline-image':
          $widget->image = new stdClass();
          $widget->image->title = $articleWidget['image']['title'];
          $widget->image->filename = $articleWidget['image']['filename'];
          $widget->image->alt = $articleWidget['image']['alt'];
          $widget->image->date = $articleWidget['image']['date'];
          $widget->image->sizes = $articleWidget['image']['sizes'];
          $widget->image->sizes['Original'] = $articleWidget['image']['url'];
          $widget->image->sizes['Original-width'] = $articleWidget['image']['width'];
          $widget->image->sizes['Original-height'] = $articleWidget['image']['height'];
          $widget->caption = $articleWidget['caption'];
          $widget->link = $articleWidget['link'];
          $widget->preferredCrop = $articleWidget['crop'];
          $widget->preferredWidth = $articleWidget['width'];
          $widget->preferredPosition = $articleWidget['position'];
          break;
        case 'gallery':
          $widget->galleryItems = array();
          foreach($articleWidget['gallery_items'] as $galleryItem) {
            $item = new stdClass();
            $item->id = $galleryItem['id'];
            $item->title = $galleryItem['title'];
            $item->filename = $galleryItem['filename'];
            $item->alt = $galleryItem['alt'];
            $item->description = $galleryItem['description'];
            $item->caption = $galleryItem['caption'];
            $item->date = $galleryItem['date'];
            $item->sizes = $galleryItem['sizes'];
            $item->sizes['Original'] = $galleryItem['url'];
            $item->sizes['Original-width'] = $galleryItem['width'];
            $item->sizes['Original-height'] = $galleryItem['height'];
            $widget->galleryItems[] = $item;
          }
          break;
      }

      $data->widgets[] = $widget;
    }
    
    return $data;

  }
}