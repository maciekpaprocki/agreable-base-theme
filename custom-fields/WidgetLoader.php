<?php

class WidgetLoader {

  private static $initialized = false;
  protected static $config = array(
    'image_choices' => array(
      'square' => 'Square',
      'landscape' => 'Landscape',
      'portrait' => 'Portrait'
    ),
    'media_widths' => array (
      'full' => 'Full Width',
      'large' => 'Large',
      'medium' => 'Medium',
      'small' => 'Small',
    ),
    'tab_placement' => 'left'
  );

  private static function initialize(){
    if (self::$initialized)
      return;

    self::$initialized = true;
  }

  /*
   * Configures shared object for use throughout widgets.
   * @param array $config associative array of config options.
   */
  public static function configure($config){
    self::initialize();
    foreach($config as $key => $item){
      self::$config[$key] = $item;
    }
  }

  public static function findByUsage($contextType = null, $contentSizes = array()) {
    self::initialize();

    $widget_layouts = array();

    // get_stylsheet_directory() returns child theme path.
    $directory = get_stylesheet_directory() . "/views/widgets";
    $acf_files = self::traverseHierarchy($directory);
    $acf_files = array_merge($acf_files, self::traversePlugins());

    // Order files aphabetically.
    usort($acf_files, function($a, $b){

      include $a;
      $compareA = strtolower($widget_config['label']);

      include $b;
      $compareB = strtolower($widget_config['label']);

      return strcmp($compareA, $compareB);
    });

    foreach($acf_files as $file) {
      include $file;

      // If contextType is null, or if contentType matches, add widget to list
      if (!$contextType ||
            (in_array($contextType, $widget_config["content-types"]) &&
              (count($contentSizes) === 0 || in_array($contentSizes, $widget_config["content-sizes"]))
            )
          ){

        include_once "BaseWidget.php";
        $widget_config = BaseWidget::add_extras($widget_config);
        $widget_layouts[] = $widget_config;
      }
    }

    return $widget_layouts;
  }

  protected static function traverseHierarchy($path) {
    if(file_exists($path) === false){
      throw new RuntimeException("Widgets folder not found in: $path");
    }
    $return_array = array();

    foreach (new DirectoryIterator($path) as $fileInfo) {
      if($fileInfo->isDot()) continue;
      $file =  $fileInfo->getFilename();
      $fullpath = $path . '/' . $file;
      if(is_dir($fullpath))
        $return_array = array_merge($return_array, self::traverseHierarchy($fullpath));
      elseif(substr($file, -7) == "acf.php")
        $return_array[] = $fullpath;
    }
    return $return_array;
  }

  protected static function traversePlugins() {
    $return_array = array();
    if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $all_plugins = get_option('active_plugins');
    // The keys in $all_plugins is the file path for plugin.
    foreach($all_plugins as $file){
      $fullpath = plugin_dir_path(WP_CONTENT_DIR.'/plugins/'.$file).'widget-loader-acf.php';
      // If plugin directory contains acf.php file and is agreable prefixed...
      if(substr($file, 0, 8) === "agreable" && file_exists($fullpath)){
        $return_array[] = $fullpath;
      }
    }
    return $return_array;
  }
}
