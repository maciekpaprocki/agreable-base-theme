<?php
require_once __DIR__ . "/../services/ArticleService.php";
class AgreableTwigArticle extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_gallery_item_count', array('AgreableArticleService','getGalleryItemCount')),
      new Twig_SimpleFunction('check_widget_exists', array('AgreableArticleService','getWidgetFromPost'))
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
