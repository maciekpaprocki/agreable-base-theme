<?php
class AgreableListService {
  protected static $dupes = array();

  public static function getPosts($lists, $manualPosts = null, $limitOverride = null, $offset = 0, $caresAboutDupes = true, $excludePosts = null) {

    $context = Timber::get_context();

    if (!is_array($lists)) {
      $lists = array($lists);
    }


    // Add manual which are live
    $posts = array();
    if ($manualPosts) {
      if (!is_array($manualPosts)) {
        $manualPosts = $manualPosts->get_posts();
      }
      foreach($manualPosts as $manualPost) {
        if (get_post_status($manualPost) === 'publish') {
          // if (true) {
          if (is_numeric($manualPost) || get_class($manualPost) === 'WP_Post') {
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

    if($excludePosts){
      foreach($excludePosts as $excludePost) {
        if (is_numeric($excludePost)) {
          $post_not_in[] = $excludePost;
        } elseif (get_class($excludePost) === 'WP_Post' || get_class($excludePost) === 'TimberPost'){
          $post_not_in[] = $excludePost->ID;
        }
      }
    }

    $date = date('Ymd H:i:s');
    $postsFromQuery = [];

    foreach($lists as $list) {
      if (!$list) {
        continue;
      }

      $list_id = is_numeric($list) ? $list : $list->ID;
      $categories = get_field("categories", $list_id) ?: [];

      foreach($categories as $sectionId) {
        if (get_the_category_by_ID($sectionId) === 'CURRENT') {
          $categories[] = self::getCurrentSectionFromUrl();
        }
      }

      $query_args = array(
        'cat' => implode(',' , $categories),
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
        // Meta query checks for presence of override_end_time &
        // override_start_time. If they don't exist then we assume
        // this post doesn't have  any other expiry rules (i.e.
        // isn't a promo or similar). If it does have both then we
        // check that time() is within these bounds. Assumes that
        // meta_value is stored as unix timestamp (seconds).
        'meta_query'  => array(
          'relation'    => 'AND',
          array(
            'relation'    => 'OR',
            array(
              'relation'    => 'AND',
              array(
                'key'   => 'override_end_time',
                'compare' => 'NOT EXISTS',
                'value'   => '1'
              ),
              array(
                'key'   => 'override_start_time',
                'compare' => 'NOT EXISTS',
                'value'   => '1'
              ),
            ),
            array(
              'relation'    => 'AND',
              array(
                'relation'    => 'OR',
                array(
                  'key'   => 'override_end_time',
                  'compare' => '>=',
                  'value'   => time()
                ),
                array(
                  'key'   => 'override_end_time',
                  'compare' => '==',
                  'value'   => '',
                ),
              ),
              array(
                'relation'    => 'OR',
                array(
                  'key'   => 'override_start_time',
                  'compare' => '<=',
                  'value'   => time()
                ),
                array(
                  'key'   => 'override_start_time',
                  'compare' => '==',
                  'value'   => '',
                )
              ),
            ),
          ),
        )
      );

      $the_query = new WP_Query( $query_args );
      // Merge each lists resulting post IDs into
      // $post_not_in to avoid dupes.
      $post_not_in = array_merge($post_not_in, array_map(
        function($p){ return $p->ID; },
        $the_query->posts
      ));
      $postsFromQuery = array_merge($postsFromQuery, $the_query->posts);
      // Reduce the limit by amout of posts received.
      $limitOverride -= count($the_query->posts);
      if($limitOverride <= 0){
        break;
      }

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
