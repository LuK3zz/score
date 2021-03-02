<?php
namespace LuK3zz\score;
/**
 * Request class
 */

class Request {

  public static function get(string $query): string
  {
    if(isset($_GET[$query])) {
      return $_GET[$query];
    } else {
      return "";
    }
  }

  /**
   * Má nastarost všechny session obsluhy
   *
   * @return void
   */
  public static function session() {
    return new class() {
      /**
       * Přidá do session
       *
       * @param String $key
       * @param String $value
       * @return void
       */
      public function put($key, $value) {
        $_SESSION[$key] = $value;
      }

      /**
       * Získá z session
       *
       * @param String $key
       * @return String
       */
      public function get($key) {
        if (isset($_SESSION[$key])) {
          return $_SESSION[$key];
        } else {
          return null;
        }
      }

      /**
       * Vymaže ze session
       *
       * @param String $key
       * @return void
       */
      public function delete($key) {
        unset($_SESSION[$key]);
      }
    };
  }

}
