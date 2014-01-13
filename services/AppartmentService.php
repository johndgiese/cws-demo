<?php

use Phalcon\Mvc\Model\Resultset;

class AppartmentService {

  public function complexes() {
    $complexes = Complex::find();
    $complexes->setHydrateMode(Resultset::HYDRATE_ARRAYS);
    return $complexes;
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
