<?php

class Appartments {
  public function complexes() {
    return array(
      array(
        "name" => "Complex One",
        "url" => "complex/1",
        "description" => "Short description goes here",
        "state" => "TX",
      ),
      array(
        "name" => "Complex Two",
        "url" => "complex/2",
        "description" => "Short description goes here",
        "state" => "OK",
      )
    );
  }

  public function appartments($complex) {
    switch ($complex) {
      case "Complex One":
        return array(
          array(
            "number" => "43A",
            "type" => "2 BR",
            "size" => 400,
            "available_on" => DateTime("2014-05-03"),
            "price_per_month" => NULL,
          ),
          array(
            "number" => "4C",
            "type" => "3 BR",
            "size" => 600,
            "available_on" => DateTime("now"),
            "price_per_month" => 5600,
          )
        );
      case "Complex Two":
        return array(
          array(
            "number" => "2",
            "type" => "10 BR",
            "size" => 6000,
            "available_on" => DateTime("now"),
            "price_per_month" => 12600,
          )
        );
      case "default":
        return array();
    }
  }

}
