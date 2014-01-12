<?php

class IndexController extends \Phalcon\Mvc\Controller {
  public function indexAction() {
    $this->logger->log("Inside the indexAction!");
    $context = array(
      "name" => "Ian",
    );
    echo $this->view->render("home", $context);
  }
}
