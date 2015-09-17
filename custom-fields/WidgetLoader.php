<?php

class WidgetLoader {

  private static $initialized = false;
  protected static $config = array(
    'image_choices' => array(
        'square' => 'Square',
        'landscape' => 'Landscape',
        'portrait' => 'Portrait'
      )
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

    foreach($acf_files as $file) {
      include $file;

      // If contextType is null, or if contentType matches, add widget to list
      if (!$contextType ||
            (in_array($contextType, $widget_config["content-types"]) &&
              (count($contentSizes) === 0 || in_array($contentSizes, $widget_config["content-sizes"]))
            )
          ){

        include_once "BaseWidget.php";
        $widget_config = BaseWidget::addWidgetDeviceTargetting($widget_config);
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
    $dir = opendir($path);

    // Order files aphabetically.
    $files_ordered = array();
    foreach (new DirectoryIterator($path) as $fileInfo) {
      if($fileInfo->isDot()) continue;
      $files_ordered[] =  $fileInfo->getFilename();
    }
    sort($files_ordered);

    foreach ($files_ordered as $file) {
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
    $all_plugins = get_plugins();
    // The keys in $all_plugins is the file path for plugin.
    foreach($all_plugins as $file => $obj){
      $fullpath = plugin_dir_path(WP_CONTENT_DIR.'/plugins/'.$file).'widget-loader-acf.php';
      // If plugin directory contains acf.php file and is slm prefixed...
      if(substr($file, 0, 8) === "agreable" && file_exists($fullpath)){
        $return_array[] = $fullpath;
      }
    }
    return $return_array;
  }
}
