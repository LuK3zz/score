<?php
namespace LuK3zz\score;

use Jenssegers\Blade\Blade;

/**
 * View Class
 * @package LuK3zz\Core
 */
class View
{
  /**
   * Vykreslení daného View
   *
   * @param string $viewName
   * @param array $data
   * @return string
   */
  public static function show(string $viewName, array $data = []): string
  {
    $viewName = str_replace('.', '/', $viewName);

    $blade = new Blade(dirname(__DIR__) . '/views/', dirname(__DIR__) . '/cache');
    $data['menu'] = 'menu';
    return $blade->render($viewName, $data);
  }
}
