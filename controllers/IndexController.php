<?php

class IndexController extends \Phalcon\Mvc\Controller {

  public function indexAction() {
    $context = array(
      "complexes" => $this->apartments->complexes(),
    );
    echo $this->view->render("home", $context);
  }

  public function showComplexAction() {
    $complex_id = $this->dispatcher->getParam("complex");
    $complex = Complex::findFirst("id = $complex_id");
    $data = $this->apartments->apartments($complex);
    $context = array(
      "contact" => $data->{'OnSiteContact'},
      "units" => $data->{'Unit'},
      "complex" => $complex,
    );
    echo $this->view->render("apartment-complex", $context);
  }
}
