<?php

$app = new \Phalcon\Mvc\Micro();

$app->get('/', function() {
  echo "<h1>Hello Ian</h1>";
});

$app->handle();

