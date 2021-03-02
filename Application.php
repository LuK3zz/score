<?php
namespace LuK3zz\score;

use LuK3zz\score\Database\Database;

class Application {
  public static Database $database;

  public function __construct()
  {
    self::$database = new Database(env('DB_DSN'), env('DB_USER'), env('DB_PASS'));
  }
}
