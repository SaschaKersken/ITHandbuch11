<?php

class Response {
  private $format = 'xml';

  private $xml = NULL;

  public function __construct($format = 'xml') {
    if ($format == 'json') {
      $this->format = 'json';
    }
  }

  public function getRecords($records, $root = 'result', $line = 'record') {
    if ($this->format == 'xml') {
      return $this->xml()->getRecords($records, $root, $line);
    } else {
      return json_encode(array_values($records));
    }
  }

  public function getRecord($record, $line = 'record') {
    if ($this->format == 'xml') {
      return $this->xml()->getRecord($record, $line);
    } else {
      return json_encode($record);
    }
  }

  public function message($content, $type) {
    if ($this->format == 'json') {
      $result = sprintf('{"%s": "%s"}', $type, $content);
    } else {
      $result = $this->xml()->getElement($content, $type);
    }
    return $result;
  }

  public function xml($xml = NULL) {
    if ($xml !== NULL) {
      $this->xml = $xml;
    } elseif ($this->xml === NULL) {
      $this->xml = new Xml();
    }
    return $this->xml;
  }
}
