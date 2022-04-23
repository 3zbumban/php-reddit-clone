<?php

declare(strict_types=1);

namespace Sem\Weben;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;

class Router
{
  private array $routes;

  function __construct()
  {
    $this->routes = [];
  }

  public function route(RequestInterface $req, ResponseInterface $res): bool
  {
    $method = $req->getMethod();
    foreach ($this->routes as $route => $routeMapping) {
      if (preg_match($route, strtolower($req->getUrl()))) {
        if (array_key_exists($method, $routeMapping)) {
          $controllerName = $routeMapping[$method]["controllerName"];
          $actionName = $routeMapping[$method]["actionName"];
          if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
            $controller = new $controllerName();
            $controller->$actionName($req, $res);
            return true;
          } else {
            throw new \Exception(
                sprintf(
                    'The "%s" controller does not exist of misses the action "%s"',
                    $controllerName,
                    $actionName
                )
            );
          }
        }
      }
      // else {
      // echo "cannot " . $method . " " . $req->getUrl();
      // }
    }
    echo "cannot " . $method . " " . $req->getUrl();
    return false;
  }

  public function addRoute(string $method, string $path, string $controllerName, string $actionName): void
  {
    $this->routes[$path][$method] = [
        "controllerName" => $controllerName,
        "actionName" => $actionName
    ];
  }
}