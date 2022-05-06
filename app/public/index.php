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

// // todo: how to do this more elegantly?
// if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
//   header("Access-Control-Allow-Origin: *");
//   if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"])) {
//     header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
//   }
//   if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"])) {
//     header("Access-Control-Allow-Headers:" . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
//   }
//   http_response_code(200);
//   exit(0);
// }

try {
  $router->route($req, $res);
  // $res->json();
} catch (HttpException $exception) {
  $res->setStatusCode($exception->getCode());
  $res->setBody([
    "message" => "http error",
    "error" => $exception->getMessage(),
    "code" => $exception->getCode()
  ]);
  // $res->json();
} catch (Exception $exception) {
  $res->setStatusCode(500);
  $res->setBody([
      "message" => "server error",
      "error" => $exception->getMessage()
  ]);
  // todo: custom exception + custom catch for it
  // $res->json();
} finally {
  $res->json();
}
