<?php

try {

  $loader = new \Phalcon\Loader();
  $loader->registerDirs(array(
    'controllers/',
  ))->register();

  $di = new Phalcon\DI\FactoryDefault();

  $di->set('logger', function() {
    return new \Phalcon\Logger\Adapter\File('var/main.log');
  });

  $di->set('view', function() {
    $view = new \Phalcon\Mvc\View();
    $view->setViewsDir('views/');
    return $view;
  });

  $application = new \Phalcon\Mvc\Application($di);
  echo $application->handle()->getContent();

} catch(Exception $e) {
  echo "Exception: ", $e->getMessage() . "\n";
  var_dump($e->getTrace());
}
