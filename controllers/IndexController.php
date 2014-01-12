<?php

class IndexController extends \Phalcon\Mvc\Controller {
  public function indexAction() {
    $this->logger->log("Inside the indexAction!");
    $context = array(
      "complexes" => $this->appartments->complexes(),
    );
    echo $this->view->render("home", $context);
  }
}
