<?php

class IndexController extends \Phalcon\Mvc\Controller {

  public function indexAction() {
    $context = array(
      "complexes" => $this->apartments->complexes(),
    );
    echo $this->view->render("home", $context);
  }

  public function showComplexAction() {
    $complex = $this->dispatcher->getParam("complex");
    $context = array(
      "apartments" => $this->apartments->apartments($complex),
    );
    $this->logger->log("In complex $complex");
    $this->logger->log("context $context");
    echo $this->view->render("apartment-complex", $context);
  }
}
