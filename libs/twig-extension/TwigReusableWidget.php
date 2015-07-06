<?php
require_once __DIR__ . "/../services/ReusableWidgetService.php";
class AgreableTwigReusableWidget extends Twig_Extension {
  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('get_reusable_widget', array('AgreableReusableWidgetService','getWidget'))
    );
  }

  public function getName() {
    return 'agreable_reusable_widget';
  }
}
