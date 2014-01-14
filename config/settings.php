<?php

require "local.php";

$settings = array(
  "defaultComplexListURL" => "http://www.cwsapartments.com/apartments/locations",
  "db" => $db,
  "cache" => array(
    "dir" => SITE_ROOT . "/var/cache/",
    "timeoute" => 172800,
  ),
);

