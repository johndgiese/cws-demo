<?php 

class complexTask extends \Phalcon\CLI\Task
{

    public function updateAction() {

      $url = $this->config["defaultComplexListURL"];
      $this->logger->log("Screen scrapping appartment complexes from:\n  $url\n");

      Guzzle\Http\StaticClient::mount();
      $response = Guzzle::get($url);

      $doc = new DOMDocument();
      $doc->loadHTML($response->getBody());

      $query = "//div[@id='locations']//dd/a";
      $xpath = new DOMXpath($doc);
      $elements = $xpath->query($query);

      if (!is_null($elements)) {
        foreach ($elements as $element) {
          $raw_text = $element->textContent;
          $raw_text_pieces = explode(",", $raw_text);


          $name = trim($raw_text_pieces[0]);
          $state = trim($raw_text_pieces[1]);
          $url = $element->getAttribute("href");
          
          $complex = new Complex();

          $complex->name = $name;
          $complex->state = $state;
          $complex->url = $url;

          $complex->save();
        }
      }
      
    }

}
