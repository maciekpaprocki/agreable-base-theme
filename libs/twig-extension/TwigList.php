<?php
require_once __DIR__ . "/../services/ListService.php";
class TroisiemeTwigList extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_widget_posts', array('TroisiemeListService','getPosts'))
    );
  }

  public function getName() {
    return 'troisieme_list';
  }
}
