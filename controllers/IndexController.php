<?php

/**
 * @RoutePrefix("/")
 */
class IndexController extends \Phalcon\Mvc\Controller {

  /**
   * @Route("/")
   */
  public function indexAction() {
    $context = array(
      "complexes" => $this->appartments->complexes(),
    );
    echo $this->view->render("home", $context);
  }

  /**
   * @Route("/complex/{$complex:[0-9]+}", name="show-complex")
   */
  public function showComplexAction($complex) {
    $this->logger->log("In complex $complex");
    $context = array(
      "apartments" => $this->appartments->apartments($complex),
    );
    echo $this->view->render("apartment-complex", $context);
  }
}
