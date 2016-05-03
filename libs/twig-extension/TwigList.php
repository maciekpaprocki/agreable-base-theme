<?php
require_once __DIR__ . "/../services/ListService.php";
class AgreableTwigList extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_widget_posts', array('AgreableListService','get_posts')),
      new Twig_SimpleFunction('get_default_related_list', array('AgreableListService','get_default_related_list'))
    );
  }

  public function getName() {
    return 'agreable_list';
  }
}
