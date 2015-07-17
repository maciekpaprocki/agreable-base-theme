<?php

class AgreableTwigUtilities extends Twig_Extension {

  public function getFunctions() {
    return array(
      new Twig_SimpleFunction('strictly_equals', array($this, 'strictlyEquals'))
    );
  }

  public function striclyEquals($val){

  }

  public function getName() {
    return 'agreable_list';
  }
}
