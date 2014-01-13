<?php 

require 'vendor/autoload.php';

use Phalcon\DI\FactoryDefault\CLI as CliDI,
   Phalcon\CLI\Console as ConsoleApp;

define('VERSION', '1.0.0');

// Register the autoloader and tell it to register the tasks directory
$loader = new \Phalcon\Loader();
$loader->registerDirs(
 array(
   'tasks/',
   'models/',
 )
);

$loader->register();


//Using the CLI factory default services container
$di = new CliDI();

$di->set('logger', function() {
  $logger = new \Phalcon\Logger\Multiple();
  $logger->push(new \Phalcon\Logger\Adapter\File('var/main.log'));
  $logger->push(new \Phalcon\Logger\Adapter\Stream('php://stdout'));
  return $logger;
});

require "config/config.php"; // defines $settings

$di->set('config', function() use ($settings) {
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

//Create a console application
$console = new ConsoleApp();
$console->setDI($di);

/**
* Process the console arguments
*/
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

