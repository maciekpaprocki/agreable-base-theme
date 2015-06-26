<?php
class WidgetLoader {
  public function findByUsage($contextType = null, $contentSizes = array()) {
    $widget_layouts = array();

    // get_stylsheet_directory() returns child theme path.
    $directory = get_stylesheet_directory() . "/views/widgets";
    $acf_files = $this->traverseHierarchy($directory);
    $acf_files = array_merge($acf_files, $this->traversePlugins());

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

  protected function traverseHierarchy($path) {
    if(file_exists($path) === false){
      throw new RuntimeException("Widgets folder not found in: $path");
    }
    $return_array = array();
    $dir = opendir($path);
    while(($file = readdir($dir)) !== false) {
      if($file[0] == '.') continue;
      $fullpath = $path . '/' . $file;
      if(is_dir($fullpath))
        $return_array = array_merge($return_array, $this->traverseHierarchy($fullpath));
      elseif(substr($file, -7) == "acf.php")
        $return_array[] = $fullpath;
    }
    return $return_array;
  }

  protected function traversePlugins() {
    $return_array = array();
    if ( ! function_exists( 'get_plugins' ) ) {
      require_once ABSPATH . 'wp-admin/includes/plugin.php';
    }
    $all_plugins = get_plugins();
    // The keys in $all_plugins is the file path for plugin.
    foreach($all_plugins as $file => $obj){
      $fullpath = plugin_dir_path(WP_CONTENT_DIR.'/plugins/'.$file).'widget-loader-acf.php';
      // If plugin directory contains acf.php file and is slm prefixed...
      if(substr($file, 0, 3) === "slm" && file_exists($fullpath)){
        $return_array[] = $fullpath;
      }
    }
    return $return_array;
  }
}
