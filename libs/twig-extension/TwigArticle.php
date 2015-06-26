<?php
require_once __DIR__ . "/../services/ArticleService.php";
class TroisiemeTwigArticle extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_gallery_item_count', array('TroisiemeArticleService','getGalleryItemCount')),
    );
  }
  public function getFilters() {
    return array(
      new Twig_SimpleFilter('get_relative_path', 'TroisiemeArticleService::getRelativePath')
    );
  }

  public function getName() {
    return 'troisieme_article';
  }
}
