<?php

  $di->set('apartments', function() {
    return new AppartmentService();
  });

  $di->set('voltService', function($view, $di) {
    $volt = new \Phalcon\Mvc\View\Engine\Volt($view, $di);
    $volt->setOptions(array(
      "compileAlways" => True, // change when in production
    ));
    return $volt;
  });

  $di->set('view', function() {
    $view = new \Phalcon\Mvc\View\Simple();
    $view->setViewsDir(SITE_ROOT . '/views/');
    $view->registerEngines(array(
      ".html" => "voltService",
    ));
    return $view;
  });

  $di->set('url', function() {
    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri('/public/');
    return $url;
  });

  $di->set('router', function() {
    $router = new \Phalcon\Mvc\Router();
    $router->add(
      "/",
      array(
        "controller" => "index",
        "action" => "index",
      )
    );
    $router->add(
      "/complex/([0-9]+)/:params",
      array(
        "controller" => "index",
        "action" => "showComplex",
        "complex" => 1,
      )
    );
    return $router;
  });
