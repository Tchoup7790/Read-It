<?php

namespace Application;

class Router
{
  private static $routes = [];

  public static function addRoute($method, $path, $callback)
  {
    self::$routes[] = ['method' => $method, 'path' => $path, 'callback' => $callback];
  }

  public static function dispatch($method, $path)
  {
    foreach (self::$routes as $route) {
      if ($route['method'] === $method && $route['path'] === $path) {
        return call_user_func($route['callback']);
      }
    }
    echo "Route not found";
  }
}
