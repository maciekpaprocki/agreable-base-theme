<?php
require_once __DIR__ . "/../services/WidgetService.php";
class AgreableTwigWidget extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_gallery_item_count', array('AgreableWidgetService','get_gallery_item_count')),
      new Twig_SimpleFunction('check_widget_exists', array('AgreableWidgetService','check_widget_exists')),
      new Twig_SimpleFunction('get_widget', array('AgreableWidgetService','get_widget_by_name_from_post')),
      new Twig_SimpleFunction('get_widget_occurrence', array('AgreableWidgetService','get_widget_occurrence')),
    );
  }
  public function getFilters() {
    return array(
      new Twig_SimpleFilter('get_relative_path', 'AgreableWidgetService::get_relative_path')
    );
  }

  public function getName() {
    return 'agreable_article';
  }
}