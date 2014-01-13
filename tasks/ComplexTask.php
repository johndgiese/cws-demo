<?php 

class complexTask extends \Phalcon\CLI\Task
{

    public function updateAction($url = "") {
      if (!$url) {
        $url = $this->config["defaultComplexListURL"];
      }
      $this->logger->log("Screen scrapping appartment complexes from:\n  $url\n");
    }

}
