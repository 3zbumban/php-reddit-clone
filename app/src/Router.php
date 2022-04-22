<?php

declare(strict_types=1);

namespace Sem\Weben;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;

class Router {
  private array $routes;
  
  function __construct() {
    $this->routes = [];
  }

  public function route(RequestInterface $req, ResponseInterface $res): void {
//                  echo json_encode(array_keys($this->routes));

      foreach($this->routes as $route => $routeMapping) {
//            echo json_encode($routeMapping);
        if (preg_match($route, strtolower($req->getUrl()))) {
            $method = $req->getMethod();
            if (array_key_exists($method, $routeMapping)) {
                $controllerName = $routeMapping[$method]["controllerName"];
                $actionName = $routeMapping[$method]["actionName"];
//                echo json_encode();
                if (class_exists($controllerName) && method_exists($controllerName, $actionName)) {
//                    echo "console and classes do exist";
                    $controller = new $controllerName();
                    $controller->$actionName($req, $res);
                } else {
                    throw new \Exception(
                        sprintf(
                            'The "%s" controller does not exist of misses the action "%s"',
                            $controllerName,
                            $actionName
                        )
                    );
                }
            } else {
                echo "cannot " . $method;
            }
//            $controllerName = $routeMapping["controllerName"];
        }
      }
  }

  public function addRoute(string $method, string $path,  string $controllerName, string $actionName): void {
    $this->routes[$path][$method] = [
        "controllerName" => $controllerName,
        "actionName" => $actionName
    ];
  }
}