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

    add_action('admin_menu', array($this, 'remove_unused_cms_menus'));
    add_action('login_enqueue_scripts', array($this, 'change_login_logo'));

    add_action('admin_menu', array($this, 'wphidenag'));
    add_action('admin_menu', array($this, 'notify_environment'));


    add_action('after_setup_theme', array($this, 'remove_post_formats'), 11);

    add_action('acf/save_post', array($this, 'prevent_show_advanced_settings_save'), 1);
    add_filter('acf/update_value/key=article_basic_hero_images', array($this, 'article_image_set_wp_thumbnail'), 10, 3);

    add_filter('robots_txt', array($this, 'force_robots_txt_disallow_non_production'), 10, 2);

    add_filter('upload_mimes', array($this, 'allowAdditionalUploadMimeTypes'));

    add_filter('tiny_mce_before_init', array($this, 'mce_mod'));
    add_filter('mce_buttons', array($this, 'my_mce_buttons'));

    add_filter( 'acf/render_field/type=flexible_content', array($this, 'add_collapse_all'), 9, 1 );
    add_filter( 'acf/update_value/key=article_related_lists', array($this, 'add_default_list'), 11, 3);

    // Recrop images clear out Timber resize() images
    include_once __DIR__ . '/libs/services/ImageService.php';
    add_action('yoimg_post_crop_image', array('AgreableImageService', 'delete_timber_resized_images'), 1, 1);

    // Set JPEG quality to 80
    add_filter( 'jpeg_quality', function() { return 80; });

    // Force WP to crop images to largest possible size based on thumbnail settings.
    // Previously attempt at cropping would be abandoned if source was too small.
    add_filter('image_resize_dimensions', array($this, 'image_crop_dimensions'), 10, 6);

    // Admin Customisations with Jigsaw https://wordpress.org/plugins/jigsaw/
    Jigsaw::add_css('admin-customisations/agreable-admin.css');

    parent::__construct();
  }

  function remove_post_formats() {
      remove_theme_support('post-formats');
  }

  function wphidenag() {
    remove_action( 'admin_notices', 'update_nag', 3 );
  }

  function notify_environment() {
    if (WP_ENV !== 'production') {
      Jigsaw::show_notice("<b>NOTICE</b>: You are currently on the <b>".strtolower(WP_ENV)."</b> site", 'error');
    }
  }

  /*
   * Forces Wordpress to crop even if the source image is too small
   */
  function image_crop_dimensions($default, $orig_w, $orig_h, $new_w, $new_h, $crop){

    if(!$crop){
      return null;
    }

    $aspect_ratio = $orig_w / $orig_h;
    $size_ratio = max($new_w / $orig_w, $new_h / $orig_h);

    $crop_w = round($new_w / $size_ratio);
    $crop_h = round($new_h / $size_ratio);

    $s_x = floor( ($orig_w - $crop_w) / 2 );
    $s_y = floor( ($orig_h - $crop_h) / 2 );

    // If the new crop is larger than source crop then do not upscale.
    // Remove this conditional if we want to upscale the image.
    if($crop_w < $new_w || $crop_h < $new_h){
      $new_w = $crop_w;
      $new_h = $crop_h;
    }

    return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
  }

  function allowAdditionalUploadMimeTypes($mimeTypes) {
    // Extra mimetypes to whitelist
    $mimeTypes['svg'] = 'image/svg+xml';
    return $mimeTypes;
  }

  function article_image_set_wp_thumbnail($values, $post_id){
    // Use the first image in gallery as the post thumbnail.
    set_post_thumbnail($post_id, $values[0]);
    return $values;
  }

  /**
   * robots.txt to show "disallow all" on staging and development
   */
  function force_robots_txt_disallow_non_production($rv, $public) {
    if (WP_ENV === 'production') {
      return $rv;
    }

    $disallow = "User-agent: *" . PHP_EOL . "Disallow: /";

    return $disallow;
  }

  function prevent_show_advanced_settings_save() {
    // Bail early if no ACF data...
    if(empty($_POST['acf'])){
        return;
    }

    // ...or no widgets.
    $has_widgets = isset($_POST['acf']['article_widgets']) && ! empty($_POST['acf']['article_widgets']);
    if($has_widgets === false){
        return;
    }

    // Ensure that the advanced settings checkbox isn't saved as true so that
    // it always starts closed.
    $search_key_suffix = '_show_advanced_widget_settings';
    $len = isset($_POST['acf']['article_widgets'])
      ? count($_POST['acf']['article_widgets'])
      : false;

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

    $login_image = (isset(get_field('login_image', 'options')['url'])) ? get_field('login_image', 'options')['url'] : "";

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
    include_once('custom-fields/page-basic-details.php');
    include_once("custom-fields/social-overrides.php");
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

    $twig->addFilter( new Twig_SimpleFilter( 'resize', array( $this, 'resize' ) ) );

    return $twig;
  }

  public function resize( $src, $w, $h = 0, $crop = 'default', $force = false ) {

    // Get the upload directory paths
    $wp_uploads = wp_upload_dir();
    $wp_base_dir = $wp_uploads['basedir'];
    $src_path = parse_url($src)['path'];
    // Replace src path url slugs with file path.
    $file_path = str_replace(CONTENT_DIR.'/uploads', $wp_base_dir, $src_path);

    // Make sure image is in the WP filesystem in the first place.
    if (strpos($src, $wp_uploads['baseurl']) !== false && file_exists($file_path)){
      $img_size = getimagesize($file_path);
      // If attempt to create image that is larger than the original we
      // return the original src url.
      if($img_size !== false && $w > $img_size[0]){
        return $src;
      } else {
        return call_user_func_array('TimberImageHelper::resize', func_get_args());
      }
    } else {
      return call_user_func_array('TimberImageHelper::resize', func_get_args());
    }
  }

  function mce_mod( $init ) {
    //hide h1
    $init['block_formats'] = "Paragraph=p; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Preformatted=pre";
    //make sure kitchen sink is displayed by default
    $init['wordpress_adv_hidden'] = true;
    //force 'plain text paste' to be on
    $init['paste_as_text'] = true;
    return $init;
  }

  function my_mce_buttons($buttons) {
    $buttons = array('formatselect','bold','italic','strikethrough','superscript','subscript','underline','forecolor','blockquote','hr','bullist','numlist','alignjustify','alignleft','aligncenter','alignright','link','unlink','pastetext','removeformat','charmap','undo','redo');
    return $buttons;
  }

  function add_collapse_all(){
    echo '<a href="#" class="acf-fc-collapse-all" onclick="event.preventDefault();toggle_fc(event);">Collapse all</a>';
    echo "<script type=\"text/javascript\">function toggle_fc(e) {if(window.jQuery) jQuery(e.target).closest('.acf-field-flexible-content').find('.values > .layout[data-toggle=\"open\"] .acf-fc-layout-handle').trigger('click');}</script>";
  }

  /*
   * Ensures there is always a default list with an article
   */
  function add_default_list($value, $post_id, $field){
    global $post;

    if($post->post_type !== 'post'){
      return $value;
    }

    if(!empty($value)){
      return $value;
    }

    $lists = get_posts(array('post_type'=>'list', 'orderby' => 'ID', 'order' => 'ASC'));
    if($lists){
      return array($lists[0]->ID);
    } else {
      return $value;
    }
  }

}

new AgreableBase();
