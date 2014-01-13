<?php

class AppartmentService {

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

  public function apartments($complex) {
    switch ($complex = "") {

      case "Complex One":
        $apartments = array(
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
        break;
      case "Complex Two":
        $apartments = array(
          array(
            "number" => "2",
            "type" => "10 BR",
            "size" => 6000,
            "available_on" => DateTime("now"),
            "price_per_month" => 12600,
          )
        );
        break;
      default:
        $apartments = array();
    }
    return $apartments;
  }

}
