<?php

namespace Sem\Weben;

class Router {
  private array $routes;
  
  function __construct() {
    $this->routes = [];
  }

  public function addRoute(string $method, string $path, callable $callback) {
    $this->routes[$method][$path] = $callback;
  }
}