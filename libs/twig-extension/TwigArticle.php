<?php
require_once __DIR__ . "/../services/ArticleService.php";
class AgreableTwigArticle extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_gallery_item_count', array('AgreableArticleService','getGalleryItemCount')),
      new Twig_SimpleFunction('check_widget_exists', array('AgreableArticleService','checkWidgetExists')),
      new Twig_SimpleFunction('get_widget', array('AgreableArticleService','getWidgetByNameFromPost')),
      new Twig_SimpleFunction('get_widget_occurrence', array('AgreableArticleService','getWidgetOccurrence')),
    );
  }
  public function getFilters() {
    return array(
      new Twig_SimpleFilter('get_relative_path', 'AgreableArticleService::getRelativePath')
    );
  }

  public function getName() {
    return 'agreable_article';
  }
}