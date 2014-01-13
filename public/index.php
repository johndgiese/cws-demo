<?php

try {

  $loader = new \Phalcon\Loader();
  $loader->registerDirs(array(
    '../controllers/',
    '../services/',
    '../models/',
  ))->register();


  $di = new Phalcon\DI\FactoryDefault();

  $di->set('logger', function() {
    return new \Phalcon\Logger\Adapter\File('../var/main.log');
  });

  require "../config/config.php"; // defines $settings

  $di->set('config', function() {
    $config = new \Phalcon\Config($settings);
    return $config;
  });

  $di->set('db', function() use ($settings) {
    return new \Phalcon\Db\Adapter\Pdo\Mysql(array(
      "host" => $settings["db"]["host"],
      "username" => $settings["db"]["username"],
      "password" => $settings["db"]["password"],
      "dbname" => $settings["db"]["dbname"],
    ));
  });

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
    $view->setViewsDir('../views/');
    $view->registerEngines(array(
      ".html" => "voltService",
    ));
    return $view;
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


  $application = new \Phalcon\Mvc\Application($di);
  $application->useImplicitView(false);
  echo $application->handle()->getContent();


} catch(Exception $e) {
  echo "Exception: ", $e->getMessage() . "\n";
  var_dump($e->getTrace());
}
