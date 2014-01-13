<?php

class Complex extends \Phalcon\Mvc\Model {

  public $id;
  public $name;
  public $state;
  public $url;

  public function getSource() {
    return "complexes";
  }
  
}
