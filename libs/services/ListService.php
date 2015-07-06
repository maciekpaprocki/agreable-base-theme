<?php
require_once "ArticleService.php";

class AgreableListService {
  protected static $dupes = array();

  public static function getPosts($lists, $manualPosts = null, $limitOverride = null, $offset = 0, $caresAboutDupes = true) {

    $context = Timber::get_context();

    if (!is_array($lists)) {
      $lists = array($lists);
    }

    // Add manual which are live
    $posts = array();
    if ($manualPosts) {
      if (!is_array($manualPosts)) {
        $manualPosts = array($manualPosts);
      }
      foreach($manualPosts as $manualPost) {
        if (AgreableArticleService::isLive($manualPost)) {
        // if (true) {
          if (is_integer($manualPost) || get_class($manualPost) === 'WP_Post') {
            $timberPost = new TimberPost($manualPost);
            if (!$timberPost) {
              throw new Exception('Expected Timber to initialise a post');
            }
          } else {
            $timberPost = $manualPost;
          }
          $posts[] = $timberPost;
          if ($caresAboutDupes) {
            self::$dupes[] = $timberPost->id;
          }
        }

      }
    }

    $limitOverride = $limitOverride - count($posts);

    // If manual lists already has enough content do not fetch from query
    if ($limitOverride <= 0) {
      return $posts;
    }

    $post_not_in = $caresAboutDupes ? self::$dupes : array();

    $date = date('Ymd H:i:s');
    $postsFromQuery = [];

    foreach($lists as $list) {
      if (!$list) {
        continue;
      }

      $sections = get_field("sections", $list->ID) ?: [];

      foreach($sections as $sectionId) {
        if (get_the_category_by_ID($sectionId) === 'CURRENT') {
          $sections[] = self::getCurrentSectionFromUrl();
        }
      }

      $query_args = array(
        'cat' => implode(',' , $sections),
        'post_type' => 'post',
        'posts_per_page' => $limitOverride ? $limitOverride : get_field("limit", $list->ID),
        // 'posts_per_page' => 100,
        'post__not_in' => $post_not_in,
        'no_found_rows' => 1,
        'offset' => $offset,
        'post_status' => 'publish',
        // 'meta_key'=>'display_date',
        // 'orderby' => 'meta_value',
        // 'orderby' => 'rand',
        'orderby' => 'date',
        'order' => 'DESC',
        // 'meta_query'  => array(
        //   'relation'    => 'AND',
        //   array(
        //     'relation'    => 'OR',
        //     array(
        //       'key'   => 'live_date',
        //       'compare' => '<=',
        //       'value'   => strtotime($date),
        //     ),
        //     array(
        //       'key'   => 'live_date',
        //       'compare' => '==',
        //       'value'   => '',
        //     )
        //   ),
        //   array(
        //     'relation'    => 'OR',
        //     array(
        //       'key'   => 'expiry_date',
        //       'compare' => '>=',
        //       'value'   => strtotime($date),
        //     ),
        //     array(
        //       'key'   => 'expiry_date',
        //       'compare' => '==',
        //       'value'   => '',
        //     )
        //   )
        // )

      );

      $the_query = new WP_Query( $query_args );
      $postsFromQuery = array_merge($postsFromQuery, $the_query->posts);
    }

    foreach ($postsFromQuery as $post) {
      if (get_class($post) === 'WP_Post') {
        $timberPost = new TimberPost($post);
      } else {
        $timberPost = new $post;
      }
      $posts[] = $timberPost;
      if ($caresAboutDupes) {
        self::$dupes[] = $post->ID;
      }
      if (!$timberPost) {
        var_dump($timberPost);
        exit;
      }
    }
    return $posts;
  }

  public static function getPostsByAuthor($authorId, $limit = 100) {
    $query_args = array(
      'post_type' => 'post',
      'author' => $authorId,
      'posts_per_page' => $limit,
      'no_found_rows' => 1,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
    );

    $the_query = new WP_Query( $query_args );
    if ($the_query && isset($the_query->posts)) {
      return $the_query->posts;
    }

    return [];
  }

  public static function getCurrentSectionFromUrl() {
    $path = substr($_SERVER['REQUEST_URI'], 1);
    if (strpos($path, '?') !== false) {
      $path = substr($path, 0, strpos($path, '?'));
    }
    $urlPieces = explode('/', $path);
    if (count($urlPieces) === 1) {
      $categorySlug = $urlPieces[0];
    } else {
      $categorySlug = $urlPieces[count($urlPieces) -2];
    }

    $category = get_category_by_slug($categorySlug);
    if ($category && isset($category->term_id)) {
      return $category->term_id;
    }

    return null;
  }
}
