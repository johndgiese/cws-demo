<?php 

use Phalcon\DI\FactoryDefault\CLI as CliDI,
   Phalcon\CLI\Console as ConsoleApp;


define("SITE_ROOT", dirname(__FILE__));

require SITE_ROOT . '/vendor/autoload.php';

require SITE_ROOT . "/config/settings.php"; // defines $settings

$loader = new \Phalcon\Loader();
$loader->registerDirs(
 array(
   SITE_ROOT . '/tasks/',
   SITE_ROOT . '/models/',
 )
);
$loader->register();


// Using the CLI factory default services container
$di = new CliDI();

require SITE_ROOT . '/config/web_and_cli_services.php';

$di->set('logger', function() {
  $logger = new \Phalcon\Logger\Multiple();
  $logger->push(new \Phalcon\Logger\Adapter\File(SITE_ROOT . '/var/main.log'));
  $logger->push(new \Phalcon\Logger\Adapter\Stream('php://stdout'));
  return $logger;
});


// Create a console application
$console = new ConsoleApp();
$console->setDI($di);

// Process the console arguments
$arguments = array();
$params = array();

foreach($argv as $k => $arg) {
 if($k == 1) {
   $arguments['task'] = $arg;
 } elseif($k == 2) {
   $arguments['action'] = $arg;
 } elseif($k >= 3) {
   $params[] = $arg;
 }
}
if(count($params) > 0) {
  $arguments['params'] = $params;
}

try {
  $console->handle($arguments);
}
catch (\Phalcon\Exception $e) {
  echo $e->getMessage();
  exit(255);
}

