<?php

class Application {
  public function run() {
    $requestFormat = 'xml';
    $responseFormat = 'xml';
    if (isset($_SERVER['HTTP_CONTENT_TYPE']) &&
        $_SERVER['HTTP_CONTENT_TYPE'] == 'application/json') {
      $requestFormat = 'json';
    }
    if (isset($_SERVER['HTTP_ACCEPT']) &&
        $_SERVER['HTTP_ACCEPT'] == 'application/json') {
      $responseFormat = 'json';
    }
    $path = strtok($_SERVER['REQUEST_URI'], '?');
    $elements = preg_split('(/)', $path);
    while (count($elements) > 0 && empty($elements[0])) {
      array_shift($elements);
    }
    $classname = ucfirst(array_shift($elements));
    $method = strtolower($_SERVER['REQUEST_METHOD']);
    $headersOnly = FALSE;
    if ($method == 'options') {
      $api = new Api($requestFormat, $responseFormat);
      header("HTTP/1.1 200 OK");
      $api->sendCorsHeaders();
      return;
    }
    if ($method == 'head') {
      $method = 'get';
      $headersOnly = TRUE;
    }
    if (!class_exists($classname)) {
      $api = new Api($requestFormat, $responseFormat);
      $api->notFound();
      return;
    }
    $instance = new $classname($requestFormat, $responseFormat, $headersOnly);
    if (!method_exists($instance, $method)) {
      $instance->notImplemented();
      return;
    }
    $instance->$method($elements);
  }
}

