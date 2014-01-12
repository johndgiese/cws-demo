<?php

try {

  $loader = new \Phalcon\Loader();
  $loader->registerDirs(array(
    'controllers/',
    'services/',
  ))->register();


  $di = new Phalcon\DI\FactoryDefault();

  $di->set('logger', function() {
    return new \Phalcon\Logger\Adapter\File('var/main.log');
  });

  $di->set('appartments', function() {
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
    $view->setViewsDir('views/');
    $view->registerEngines(array(
      ".html" => "voltService",
    ));
    return $view;
  });


  $application = new \Phalcon\Mvc\Application($di);
  $application->useImplicitView(false);
  echo $application->handle()->getContent();


} catch(Exception $e) {
  echo "Exception: ", $e->getMessage() . "\n";
  var_dump($e->getTrace());
}
