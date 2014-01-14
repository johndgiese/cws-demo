<?php

use Phalcon\Mvc\Model\Resultset;

require SITE_ROOT . "/lib/util.php";

class AppartmentService implements \Phalcon\DI\InjectionAwareInterface {

  use SimpleDiInjectorTrait;

  public function complexes() {
    $complexes = Complex::find();
    $complexes->setHydrateMode(Resultset::HYDRATE_ARRAYS);
    return $complexes;
  }

  public function apartments($complex) {

    $apt_search_keyword = $complex->apt_search_keyword;

    $cache_key = "apartments" . $apt_search_keyword;
    $data = $this->$cache->get($cache_key);

    if ($data === null) {
      $json_url = "http://property.onesite.realpage.com/templates/tedtest/rpoxml4.asp?w=$apt_search_keyword&rpo=mitsunits,floorplan&returnType=jsonp";

      Guzzle\Http\StaticClient::mount();
      $response = Guzzle::get($json_url);

      $raw_body = $response->getBody();
      $json_txt = substr($raw_body, 12, -1);

      $data = json_decode($json_txt);
      $data = $data->{"rpo_info"}->{"mitsunits"}->{"PhysicalProperty"}->{"Property"};

      $this->$cache->save($cache_key, $data);
    }

    return $data;
  }

}
