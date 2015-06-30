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

    $this->add_image_sizes();
    $this->hide_wordpress_admin_bar();

		add_theme_support('post-formats');
		add_theme_support('post-thumbnails');
		add_theme_support('menus');
		add_filter('timber_context', array($this, 'add_to_context'));
		add_filter('get_twig', array($this, 'add_to_twig'));
		add_action('init', array($this, 'register_taxonomies'));
		add_action('init', array($this, 'register_post_types'));
		add_action('init', array($this, 'register_custom_fields'));

    add_filter('custom_menu_order', array($this, 'custom_menu_order'));
    add_filter('menu_order', array($this, 'custom_menu_order'));
    /*
    add_action('do_meta_boxes', array($this, 'move_featured_image_meta_box'));
    add_action('admin_menu', array($this, 'remove_unused_cms_menus'));

     */
    // Admin Customisations with Jigsaw https://wordpress.org/plugins/jigsaw/
    Jigsaw::add_css('admin-customisations/agreable-admin.css');
		parent::__construct();
	}

  protected function hide_wordpress_admin_bar() {
    add_filter('show_admin_bar', '__return_false');
  }

  protected function add_image_sizes() {
    update_option('thumbnail_size_w', 720);
    update_option('thumbnail_size_h', 720);
    update_option('thumbnail_crop', 1);
    add_image_size('portrait', 720, 960, true);
    add_image_size('landscape', 1680, 1120, true);
    add_image_size('letterbox', 1680, 840, true);
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

  function remove_unused_cms_menus(){
    remove_menu_page('edit-comments.php');
  }

  function move_featured_image_meta_box() {
    remove_meta_box('postimagediv', 'post', 'side');
    add_meta_box('postimagediv', __('Featured Image'), 'post_thumbnail_meta_box', 'post', 'normal', 'high');
  }

  function register_custom_fields() {
    include_once('custom-fields/article-basic-details.php');
    include_once('custom-fields/list.php');
    include_once('custom-fields/reusable-widgets.php');
    include_once("custom-fields/article-images.php");
    include_once('custom-fields/article-widgets.php');
    include_once('custom-fields/section-widgets.php');

    // TODO - Elliot handling.
    // include_once("custom-fields-acf/article-related.php");
    // include_once("custom-fields-acf/article-scheduling.php");
    // TODO - Perhaps not needed?
    // include_once("custom-fields-acf/article-commenting.php");
    // include_once("custom-fields-acf/article-layout.php");
    // TODO - ???
    // include_once("custom-fields-acf/article-social.php");
    // include_once("custom-fields-acf/options-page.php");
    // acf_add_options_page();
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
		$context['site'] = $this;
    $context['environment'] = WP_ENV;
    return $context;
  }

	function add_to_twig( $twig ) {
		$twig->addExtension(new Twig_Extension_StringLoader());

    require_once "libs/twig-extension/TwigArticle.php";
    $twig->addExtension(new TroisiemeTwigArticle());

    require_once "libs/twig-extension/TwigList.php";
    $twig->addExtension(new TroisiemeTwigList());

    require_once "libs/twig-extension/TwigReusableWidget.php";
    $twig->addExtension(new TroisiemeTwigReusableWidget());

		return $twig;
	}

}

new AgreableBase();
