<?php
require_once __DIR__ . "/../services/CategoryService.php";

class AgreableTwigCategory extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_post_category_hierarchy', array('AgreableCategoryService','get_post_category_hierarchy'))
    );
  }
  public function getName() {
    return 'agreable_category';
  }
}
