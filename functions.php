<?php

if ( ! class_exists( 'Timber' ) ) {
  add_action( 'admin_notices', function() {
      echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
    } );
  return;
}

class AgreableBase extends TimberSite {

  function __construct() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');

    $this->hide_wordpress_admin_bar();

    add_theme_support('post-formats');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');

    add_filter('timber_context', array($this, 'add_to_context'));
    add_filter('get_twig', array($this, 'add_to_twig'));
    add_filter('custom_menu_order', array($this, 'custom_menu_order'));
    add_filter('menu_order', array($this, 'custom_menu_order'));

    add_action('init', array($this, 'register_taxonomies'));
    add_action('init', array($this, 'register_post_types'));
    add_action('init', array($this, 'register_custom_fields'));
    add_action('after_setup_theme', array($this, 'remove_wordpress_meta_from_head'));
    add_action('do_meta_boxes', array($this, 'remove_unused_meta_box'));
    add_action('do_meta_boxes', array( $this, 'move_featured_image_meta_box') );

    add_action('admin_menu', array($this, 'remove_unused_cms_menus'));
    add_action('login_enqueue_scripts', array($this, 'change_login_logo'));

    add_action('acf/save_post', array($this, 'prevent_show_advanced_settings_save'), 1);

    // Admin Customisations with Jigsaw https://wordpress.org/plugins/jigsaw/
    Jigsaw::add_css('admin-customisations/agreable-admin.css');
    parent::__construct();
  }

  protected function hide_wordpress_admin_bar() {
    add_filter('show_admin_bar', '__return_false');
  }

  function prevent_show_advanced_settings_save() {
    // Bail early if no ACF data.
    if(empty($_POST['acf']) || isset($_POST['acf']['article_widgets']) === false){
        return;
    }

    // Ensure that the advanced settings checkbox isn't saved as true so that
    // it always starts closed.
    $search_key_suffix = '_show_advanced_widget_settings';
    $len = count($_POST['acf']['article_widgets']);
    if ($len) {
      foreach($_POST['acf']['article_widgets'] as $widget) {
        foreach($widget as $key=>$val){
          if(substr($key, 0-strlen($search_key_suffix)) === $search_key_suffix){
            $widget[$key] = 0;
          }
        }
      }
    }
  }

  function custom_menu_order($menu_order) {
    if (!$menu_order){
       return true;
    }

    // Move Pages next to Posts.
    unset($menu_order[array_search("edit.php?post_type=page", $menu_order)]);
    array_splice($menu_order, 3, 0, "edit.php?post_type=page");

    // Remove media and reinsert above comments.
    unset($menu_order[array_search("upload.php", $menu_order)]);
    $comments_index = array_search("edit-comments.php", $menu_order);
    array_splice($menu_order, $comments_index-1, 0, "upload.php");

    return $menu_order;
  }

  function change_login_logo() {

    $login_image = get_field('login_image', 'options')['url'];
    echo <<<HTML
        <style type="text/css">
            .login h1 a {
                background-image: url($login_image);
            }
        </style>
HTML;

  }

  function remove_unused_cms_menus(){
    remove_menu_page('edit-comments.php');
  }

  function move_featured_image_meta_box () {
    remove_meta_box( 'postimagediv', 'post', 'side' );
    add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'post', 'normal', 'high');
  }

  function remove_unused_meta_box() {
    remove_meta_box('postimagediv', 'post', 'side');
    remove_meta_box('commentsdiv','post','normal');
    remove_meta_box('commentstatusdiv', 'post', 'normal');
    remove_meta_box('formatdiv','post','side');
    remove_meta_box('tagsdiv-post_tag','post','side');
  }

  function remove_wordpress_meta_from_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'feed_links_extra', 3);
  }

  function register_custom_fields() {

    include_once('custom-fields/article-basic-details.php');
    include_once('custom-fields/article-widgets.php');
    include_once("custom-fields/article-related.php");
    include_once("custom-fields/article-layout.php");
    include_once("custom-fields/article-social.php");
    include_once('custom-fields/section-widgets.php');
    include_once('custom-fields/list.php');
    include_once('custom-fields/reusable-widgets.php');
    include_once('custom-fields/tile.php');

    include_once("custom-fields/options-page.php");
    acf_add_options_page();
  }

  function register_post_types() {
    include_once __DIR__ . '/custom-post-types/reusable-widget.php';
    include_once __DIR__ . '/custom-post-types/list.php';
    include_once __DIR__ . '/custom-post-types/tile.php';
  }

  function register_taxonomies() {
    //this is where you can register custom taxonomies
  }

  function add_to_context($context) {
    $context['user'] = new TimberUser();
    $context['menu'] = new TimberMenu('main');
    $context['menu_footer'] = new TimberMenu('footer');
    $context['site'] = $this;
    $context['options'] = get_fields('options');
    $context['environment'] = WP_ENV;
    return $context;
  }

  function add_to_twig( $twig ) {
    require_once "libs/twig-extension/TwigArticle.php";
    $twig->addExtension(new AgreableTwigArticle());

    require_once "libs/twig-extension/TwigList.php";
    $twig->addExtension(new AgreableTwigList());

    require_once "libs/twig-extension/TwigReusableWidget.php";
    $twig->addExtension(new AgreableTwigReusableWidget());

    return $twig;
  }

}

new AgreableBase();
