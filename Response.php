<?php
namespace LuK3zz\score;

class Response {
  private $response;

  public function __construct($response) {
    $this->response = $response;
  }

  public function body() {
    return $this->response->getBody();
  }

  public function json() {
    return json_decode($this->body(), true);
  }

  public function status() {
    return $this->response->getStatusCode();
  }

  public function successful() {
    return $this->status() >= 200 && $this->status() < 300;
  }

  public function failed() {
    return $this->status() >= 400;
  }

  public function clientError() {
    return $this->status() === 400;
  }

  public function serverError() {
    return $this->status() === 500;
  }
}
