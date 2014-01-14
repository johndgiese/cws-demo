<?php

try {

  define("SITE_ROOT", dirname(dirname(__FILE__)));

  require SITE_ROOT . '/vendor/autoload.php';

  require SITE_ROOT . "/config/settings.php"; // defines $settings

  $loader = new \Phalcon\Loader();
  $loader->registerDirs(array(
    SITE_ROOT . '/controllers/',
    SITE_ROOT . '/services/',
    SITE_ROOT . '/models/',
    SITE_ROOT . '/lib/',
  ));
  $loader->register();

  $di = new Phalcon\DI\FactoryDefault();

  require SITE_ROOT . '/config/web_and_cli_services.php';
  require SITE_ROOT . '/config/web_services.php';

  $application = new \Phalcon\Mvc\Application($di);
  $application->useImplicitView(false);
  echo $application->handle()->getContent();


} catch(Exception $e) {
  echo "Exception: ", $e->getMessage() . "\n";
  var_dump($e->getTrace());
}
