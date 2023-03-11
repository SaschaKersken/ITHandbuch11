<?php

class Api {
  protected $requestFormat = 'xml';
  protected $responseFormat = 'xml';
  protected $headersOnly = FALSE;
  protected $response = NULL;

  public function __construct($requestFormat = 'xml', $responseFormat = 'xml', $headersOnly = FALSE) {
    if ($requestFormat == 'json') {
      $this->requestFormat = 'json';
    }
    if ($responseFormat == 'json') {
      $this->responseFormat = 'json';
    }
    $this->headersOnly = $headersOnly;
  }

  public function get($elements) {
    $this->notImplemented();
  }

  public function post($elements) {
    $this->notImplemented();
  }

  public function put($elements) {
    $this->notImplented();
  }

  public function delete($elements) {
    $this->notImplemented();
  }

  public function ok($body) {
    header("HTTP/1.1 200 OK");
    $this->output($body);
  }

  public function notFound() {
    header("HTTP/1.1 404 Not found");
    $this->output(
      'The requested resource could not be found.',
      'error'
    );
  }

  public function badRequest($message = '') {
    header("HTTP/1.1 400 Bad request");
    $this->output(
      empty($message) ? 'This request is formally incorrect.' : $message,
      'error'
    );
  }

  public function forbidden() {
    header("HTTP/1.1 403 Forbidden");
    $this->output(
      'You are not allowed to access this resource. User='.$_GET['user'].', Key='.$_GET['key'].'/'.md5($_GET['key']).', '.($_GET['user'] == AUTH_USER ? 'User OK' : 'User NOT OK').', '.(md5($_GET['key']) == AUTH_KEY ? ', Key OK' : ', Key NOT OK'),
      'error'
    );
  }

  public function notImplemented() {
    header("HTTP/1.1 501 Not implemented");
    $this->output(
      'This request method is not implemented.',
      'error'
    );
  }

  public function output($message, $type = NULL) {
    $this->sendCorsHeaders();
    $responseFormattedMessage = $message;
    if (!is_null($type)) {
      $responseFormattedMessage = $this->response()->message($message, $type);
    }
    header(sprintf("Content-type: %s", $this->contentType()));
    header(sprintf("Content-length: %d", strlen($responseFormattedMessage)));
    if (!$this->headersOnly) {
      echo $responseFormattedMessage;
    }
  }

  protected function checkAuthorization() {
    $result = FALSE;
    if (defined('AUTH_USER') && defined('AUTH_KEY')) {
      if (isset($_GET['user']) && $_GET['user'] == AUTH_USER &&
          isset($_GET['key']) && md5($_GET['key']) == AUTH_KEY) {
        $result = TRUE;
      }
    }
    return $result;
  }

  public function sendCorsHeaders() {
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, HEAD");
    header("Access-Control-Allow-Headers: Content-Type");
  }

  public function contentType() {
    $contentType = 'text/xml';
    if ($this->responseFormat == 'json') {
      $contentType = 'application/json';
    }
    return $contentType;
  }

  public function response($response = NULL) {
    if (!is_null($response)) {
      $this->response = $response;
    } elseif (is_null($response)) {
      $this->response = new Response($this->responseFormat);
    }
    return $this->response;
  }
}
