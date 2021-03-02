<?php
namespace LuK3zz\score;

/**
 * Router class
 */
class Router
{
  /**
   * Signalizace, zda daný router má nějakou routu
   */
  public static bool $hasRoute = false;

  /**
   * Pole všech rout
   */
  public static array $routes = [];

  /**
   * Pole všechn různych patternů, potřebné v route
   */
  public static array $patterns = [
    ':id[0-9]?' => '([0-9]+)',
    ':url[0-9]?' => '([0-9a-zA-Z-_]+)',
  ];

  public const METHOD_GET = 'get';
  public const METHOD_POST = 'post';

  public static string $prefix = '';

  /**
   * Routa na požadavek GET
   *
   * @param string $path
   * @param $callback
   * @return Router
   */
  public static function get(string $path, $callback): Router
  {
    self::$routes[self::METHOD_GET][self::$prefix . $path] = [
      'callback' => $callback
    ];

    return new self();
  }

  /**
   * Routa na požadavek POST
   *
   * @param string $path
   * @param $callback
   * @return Router
   */
  public static function post(string $path, $callback): Router
  {
    self::$routes[self::METHOD_POST][self::$prefix . $path] = [
      'callback' => $callback
    ];

    return new self();
  }

  /**
   * Vyvolání dané funkce způsobí nastavení všech rout
   *
   * @return void
   */
  public static function dispatch(): void
  {
    $url    = self::getUrl();
    $method = self::getMethod();

    if (!isset(self::$routes[$method])) {
      self::hasRoute();
      echo "test";
      return;
    }

    foreach (self::$routes[$method] as $path => $props) {
      foreach (self::$patterns as $key => $pattern) {
        $path = preg_replace("#$key#", $pattern, $path);
      }
      $pattern = "#^$path$#";


      $url = explode('?', $url)[0];

      if (preg_match($pattern, $url, $params)) {
        self::$hasRoute = true;
        array_shift($params);

        if (array_key_exists('redirect', $props)) {
          //TODO: REDIRECT
        } else {
          $callback = $props['callback'];

          if (is_callable($callback)) {
            echo call_user_func_array($callback, $params);
          } elseif (is_string($callback)) {
            [$className, $methodName] = explode('@', $callback);
            $className = "\LuK3zz\App\Controllers\\$className";
            $controller = new $className();

            echo call_user_func_array([$controller, $methodName], $params);
          }
        }
      }
    }

    self::hasRoute();
  }

  /**
   * Kontrola, zda obsahuje routu
   *
   * @return void
   */
  public static function hasRoute(): void
  {
    if (self::$hasRoute === false) {
      //TODO: 404 page
      exit('Stránka nebyla nalezena');
    }
  }

  /**
   * Získá danou URL
   *
   * @return string
   */
  public static function getUrl(): string
  {
    return $_SERVER['REQUEST_URI'];
  }

  /**
   * Získá danou metodu
   *
   * @return string
   */
  public static function getMethod(): string
  {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }

  /**
   * Nastavení dané URL (helper)
   *
   * @param string $name
   * @param array $params
   * @return string
   */
  public static function url(string $name, array $params = []): string
  {
    $filteredRoute = array_filter(self::$routes[self::METHOD_GET], function ($route) use ($name) {
      return isset($route['name']) && $route['name'] === $name;
    });

    $route = array_key_first($filteredRoute);
    $mapRoute = array_map(fn ($key) => ":$key", array_keys($params));

    return getenv('SITE_URL') . str_replace($mapRoute, array_values($params), $route);
  }

  /**
   * Nastavení jména routy
   *
   * @param string $name
   * @return void
   */
  public function name(string $name): void
  {
    if(isset(self::$routes[self::METHOD_GET])) {
      $key = array_key_last(self::$routes[self::METHOD_GET]);
      self::$routes[self::METHOD_GET][$key]['name'] = $name;
    }
  }

  public static function prefix(string $prefix): Router
  {
      self::$prefix = $prefix;
      return new self();
  }

  /**
   * @param \Closure $closure
   */
  public static function group(\Closure $closure): void
  {
      $closure();
      self::$prefix = '';
  }
}
