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

$router->addRoute("POST", '/^\/auth\/signup$/', UserController::class, "signup");
$router->addRoute("POST", '/^\/auth\/login$/', UserController::class, "login");
$router->addRoute("POST", '/^\/thread\/?$/', ThreadController::class, "create");
$router->addRoute("GET", '/^\/thread\/?$/', ThreadController::class, "list");
$router->addRoute("POST", '/^\/post\/?$/', PostController::class, "create");
$router->addRoute("GET", '/^\/post\/[0-9A-z]{8}-[0-9A-z]{4}-4[0-9A-z]{3}-[0-9A-z][0-9A-z]{3}-[0-9A-z]{12}\/?/', PostController::class, "get");
$router->addRoute("GET", '/^\/post\/?/', PostController::class, "list");
$router->addRoute("POST", '/^\/comment\/?/', CommentController::class, "create");
$router->addRoute("POST", '/^\/vote\/?/', VoteController::class, "vote");
// $router->addRoute("POST", '/^\/threads\/?/', ThreadController::class, "create");
// $router->addRoute("POST", '/^\/threads\/?/', ThreadController::class, "create");
// $router->addRoute("GET", '/^\/threads\/?/', ThreadController::class, "list");
// $router->addRoute("GET", '/^\/$/', ThreadController::class, "list");

//$router->addRoute("POST", '/\//', ThreadController::class, "create");
$router->route($req, $res);
//print json_encode($req->getQueryParams());

// header('Content-Type: application/json');
// print json_encode($_ENV);
//print json_encode($req->getPathParams());
