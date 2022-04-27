<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';
require_once '../generated-conf/config.php';

use Sem\Weben\Router;
use Sem\Weben\Http\Request;
use Sem\Weben\Http\Response;
use Sem\Weben\Controller\ThreadController;
use Sem\Weben\Controller\VoteController;
use Sem\Weben\Controller\PostController;
use Sem\Weben\Controller\UserController;
use Sem\Weben\Controller\CommentController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$req = new Request();
$res = new Response();
$router = new Router();

$router->addRoute("POST", '/^\/auth\/signup\/?$/', UserController::class, "signup");
$router->addRoute("POST", '/^\/auth\/login\/?$/', UserController::class, "login");
$router->addRoute("POST", '/^\/auth\/refresh\/?/', UserController::class, "refresh");
$router->addRoute("POST", '/^\/thread\/?$/', ThreadController::class, "create");
$router->addRoute("GET", '/^\/thread\/?$/', ThreadController::class, "list");
$router->addRoute("POST", '/^\/post\/?$/', PostController::class, "create");
$router->addRoute("GET", '/^\/post\/[0-9A-z]{8}-[0-9A-z]{4}-4[0-9A-z]{3}-[0-9A-z][0-9A-z]{3}-[0-9A-z]{12}\/?/', PostController::class, "get");
$router->addRoute("GET", '/^\/post\/?/', PostController::class, "list");
$router->addRoute("POST", '/^\/comment\/?/', CommentController::class, "create");
$router->addRoute("POST", '/^\/vote\/?/', VoteController::class, "vote");

try {
  $router->route($req, $res);
  $res->json();
} catch (Exception $exception) {
  $res->setStatusCode(500);
  $res->setBody([
      "message" => "server error",
      "error" => $exception->getMessage()
  ]);
  // todo: custom exception + custom catch for it
  $res->json();
}
