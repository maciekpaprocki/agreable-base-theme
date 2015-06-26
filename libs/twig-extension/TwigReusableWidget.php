<?php
require_once __DIR__ . "/../services/ReusableWidgetService.php";
class TroisiemeTwigReusableWidget extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('getReusableWidget', array('TroisiemeReusableWidgetService','getWidget'))
    );
  }

  public function getName() {
    return 'troisieme_reusable_widget';
  }
}
