<?php
namespace LuK3zz\Core;

use Exception;
use LuK3zz\Core\Response;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Client;

//TODO: Exceptions

class Http {
  private const METHOD_GET = 'GET';
  private const METHOD_POST = 'POST';

  private static $token = '';

  public function __construct(string $token)
  {
    self::$token = $token;
  }

  private static function make(string $method, string $url, array $data = []) {
    $client = new \GuzzleHttp\Client();
    $response = $client->request($method, $url, $data);

    return new Response($response);
  }

  public static function get(string $url) {
    $data = self::$token !== '' ? self::makeHeader() : [];
    return self::make(self::METHOD_GET, $url, $data);
  }

  public static function withToken($token) {
    return new self($token);
  }

  private static function makeHeader() {
    return [
      'Authorization' => 'Bearer ' . self::$token,
    ];
  }

  public static function post(string $url, array $data) {
    return self::make(self::METHOD_POST, $url, $data);
  }
}

