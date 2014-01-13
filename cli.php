<?php 

use Phalcon\DI\FactoryDefault\CLI as CliDI,
   Phalcon\CLI\Console as ConsoleApp;

define('VERSION', '1.0.0');

//Using the CLI factory default services container
$di = new CliDI();

$di->set('logger', function() {
  $logger = new \Phalcon\Logger\Multiple();
  $logger->push(new \Phalcon\Logger\Adapter\File('var/main.log'));
  $logger->push(new \Phalcon\Logger\Adapter\Stream('php://stdout'));
  return $logger;
});


// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

// Register the autoloader and tell it to register the tasks directory
$loader = new \Phalcon\Loader();
$loader->registerDirs(
 array(
   APPLICATION_PATH . '/tasks'
 )
);
$loader->register();

$di->set('config', function() {
  require "config/config.php";
  $config = new \Phalcon\Config($settings);
  return $config;
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

// define global constants for the current task and action
define('CURRENT_TASK', (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
 // handle incoming arguments
 $console->handle($arguments);
}
catch (\Phalcon\Exception $e) {
 echo $e->getMessage();
 exit(255);
}

