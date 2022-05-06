<?php

declare(strict_types=1);

namespace Sem\Weben;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;

class Router
{
  private array $routes;

  function __construct()
  {
    $this->routes = [];
  }

  /**
   * @throws Exception
   */
  public function route(RequestInterface $req, ResponseInterface $res): bool
  {
    
    $method = $req->getMethod();
    // todo: how to do this more elegantly?
    // echo $method;
    if ($method == "OPTIONS") {
      header("Access-Control-Allow-Origin: *");
      if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"])) {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
      }
      if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"])) {
        header("Access-Control-Allow-Headers:" . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
      }
      http_response_code(200);
      // echo $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'];
      exit(0);
    }

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
            throw new Exception(
                sprintf(
                    'The "%s" controller does not exist or misses the action "%s"',
                    $controllerName,
                    $actionName
                )
            );
          }
        }
      }
    }
    throw new Exception("cannot " . $method . " " . $req->getUrl());
  }

  public function addRoute(string $method, string $path, string $controllerName, string $actionName): void
  {
    $this->routes[$path][$method] = [
        "controllerName" => $controllerName,
        "actionName" => $actionName
    ];
  }
}