<?php

$di->set('logger', function() {
  $logger = new \Phalcon\Logger\Adapter\File(SITE_ROOT . '/var/main.log');
  return $logger;
});

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

$di->set('cache', function() use ($settings) {
  $frontCache = new Phalcon\Cache\Frontend\Output(array(
    "lifetime" => $settings["cache"]["lifetime"],
  ));
  $cache = new Phalcon\Cache\Backend\File($frontCache, array(
    "cacheDir" => $settings["cache"]["dir"],
  ));
  return $cache;
});
