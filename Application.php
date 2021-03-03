<?php
namespace LuK3zz\score;

class Application {
  public $db;

  public function __construct()
  {
    $this->db = \ParagonIE\EasyDB\Factory::fromArray([env('DB_DSN'), env('DB_USER'), env('DB_PASS')]);
  }
}
