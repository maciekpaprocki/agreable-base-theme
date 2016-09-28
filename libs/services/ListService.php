<?php
class AgreableListService
{
    protected static $dupes = array();

    public static function get_posts($lists, $manualPosts = null, $limitOverride = null, $offset = 0, $caresAboutDupes = true, $excludePosts = null)
    {
        global $post;

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
            foreach ($manualPosts as $manualPost) {
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

        if ($excludePosts) {
            foreach ($excludePosts as $excludePost) {
                if (is_numeric($excludePost)) {
                    $post_not_in[] = $excludePost;
                } elseif (get_class($excludePost) === 'WP_Post' || get_class($excludePost) === 'TimberPost') {
                    $post_not_in[] = $excludePost->ID;
                }
            }
        }

        $date = date('Ymd H:i:s');
        $postsFromQuery = [];

        foreach ($lists as $list) {
            if (!$list) {
                continue;
            }

            $list_id = is_numeric($list) ? $list : $list->ID;

            if (!method_exists($list, 'get_field')) {
                $list = new TimberPost($list->ID);
            }

            $categories = [];
            if ($list->get_field('categories_configuration') === 'current-category-and-children') {
                $categories[] = self::get_current_category_from_url();
            } else {
                $categories = get_field("categories", $list_id) ?: [];
            }

            $post_type = null;
            if ($list->get_field('post_type_configuration') === 'current') {
                if ($post && isset($post->post_type)) {
                    $post_type = $post->post_type;
                }
            }

            $query_args = array(
        'cat' => implode(',', $categories),
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

            if ($post_type) {
                $query_args['post_type'] = $post_type;
            }

            $the_query = new WP_Query($query_args);
      // Merge each lists resulting post IDs into
      // $post_not_in to avoid dupes.
      $post_not_in = array_merge($post_not_in, array_map(
        function ($p) {
            return $p->ID;
        },
        $the_query->posts
      ));
            $postsFromQuery = array_merge($postsFromQuery, $the_query->posts);
      // Reduce the limit by amout of posts received.
      $limitOverride -= count($the_query->posts);
            if ($limitOverride <= 0) {
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

    public static function get_default_related_list()
    {
        $slug = 'most-recent-current-content-type-and-category';
        if (!$list = get_page_by_path($slug, OBJECT, 'list')) {
            $list_data = array(
        'post_title'    => 'Most recent (system default)',
        'post_name'    => $slug,
        'post_content'  => '',
        'post_status'   => 'publish',
        'post_author'   => 1,
        'post_type'     => 'list'
      );
            $id = wp_insert_post($list_data);
            update_post_meta($id, 'limit', 1000);
            update_post_meta($id, '_limit', 'list_limit');

            update_post_meta($id, 'categories_configuration', 'current-category-and-children');
            update_post_meta($id, '_categories_configuration', 'list_categories_configuration');

            update_post_meta($id, 'post_type_configuration', 'current');
            update_post_meta($id, '_post_type_configuration', 'list_post_type_configuration');

            update_post_meta($id, 'order', 'newest');
            update_post_meta($id, '_order', 'list_order');
            $list = new TimberPost($id);
        } else {
            $list = new TimberPost($list);
        }
        return $list;
    }

    public static function get_current_category_from_url()
    {
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
