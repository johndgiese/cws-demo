<?php 

class mainTask extends \Phalcon\CLI\Task
{

    public function mainAction($url = "") {
      if (!$url) {
        $url = $this->config["defaultComplexListURL"];
      }
      $this->logger->log("Screen scrapping appartment complexes from:\n  $url\n");
    }

}
