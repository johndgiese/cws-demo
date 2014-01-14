<?php

use Phalcon\Mvc\Model\Resultset;

class AppartmentService {

  public function complexes() {
    $complexes = Complex::find();
    $complexes->setHydrateMode(Resultset::HYDRATE_ARRAYS);
    return $complexes;
  }

  public function apartments($complex) {

    $url = $complex->url;

    Guzzle\Http\StaticClient::mount();
    $response = Guzzle::get($url);

    $doc = new DOMDocument();
    $doc->loadHTML($response->getBody());

    $query = "/html/head/script";
    $xpath = new DOMXpath($doc);
    $elements = $xpath->query($query);
    $script_with_complex_keyword = $elements->item(3);
    $text = $script_with_complex_keyword->textContent;

    $match_array = array();
    $pattern = '/\?w=(.*)\"/';
    preg_match($pattern, $text, $match_array);

    $complex_keyword = $match_array[1];

    $json_url = "http://property.onesite.realpage.com/templates/tedtest/rpoxml4.asp?w=$complex_keyword&rpo=mitsunits,floorplan&returnType=jsonp";

    $response = Guzzle::get($json_url);

    $raw_body = $response->getBody();
    $json_txt = substr($raw_body, 12, -1);

    $data = json_decode($json_txt);
    $data = $data->{"rpo_info"}->{"mitsunits"}->{"PhysicalProperty"}->{"Property"};

    return $data;
  }

}
