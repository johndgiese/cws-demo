<?php 

class complexTask extends \Phalcon\CLI\Task
{

    public function updateAction() {

      $url = $this->config["defaultComplexListURL"];
      $this->logger->log("Screen scrapping appartment complexes from:\n  $url");

      Guzzle\Http\StaticClient::mount();
      $response = Guzzle::get($url);

      $doc = new DOMDocument();
      $doc->loadHTML($response->getBody());

      $query = "//div[@id='locations']//dd/a";
      $xpath = new DOMXpath($doc);
      $elements = $xpath->query($query);

      if (!is_null($elements)) {

        // delete previous contents
        $this->logger->log("Deleteing all saved complexes...");
        foreach (Complex::find() as $c) {
          $c->delete();
        }

        $num_complexes = 0;
        foreach ($elements as $element) {
          $num_complexes += 1;
          $raw_text = $element->textContent;
          $raw_text_pieces = explode(",", $raw_text);


          $name = trim($raw_text_pieces[0]);
          $state = trim($raw_text_pieces[1]);
          $url = $element->getAttribute("href");
          
          // get appartment_search_keyword
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

          $apt_search_keyword = $match_array[1];


          $complex = new Complex();
          $complex->name = $name;
          $complex->state = $state;
          $complex->url = $url;
          $complex->apt_search_keyword = $apt_search_keyword;
          $complex->save();
        }
        $this->logger->log("Saved details about $num_complexes apartment complexes.");
      } else {
        $this->logger->log("Couldn't find any apartment complexes on the page.");
      }
      
    }

}
