<?php
require_once __DIR__ . "/../services/ListService.php";
class AgreableTwigList extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_widget_posts', array('AgreableListService','getPosts'))
    );
  }

  public function getName() {
    return 'agreable_list';
  }
}
