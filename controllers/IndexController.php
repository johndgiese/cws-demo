<?php

class IndexController extends \Phalcon\Mvc\Controller {
  public function indexAction() {
    $this->logger->log("Inside the indexAction!");
    $response = new Phalcon\Http\Response();
    $response->setStatusCode(200, "OK");
    $response->setContent("<html><body>Hello Ian</body></html>");
    $response->send();
  }
}
