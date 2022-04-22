<?php

declare(strict_types=1);

// $pdo = new PDO('mysql:dbname=database_dev;host=mysql', 'tester', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// $query = $pdo->query('SHOW VARIABLES like "version"');
// $row = $query->fetch();

require '../vendor/autoload.php';

use Sem\Weben\Router;
use Sem\Weben\Http\Request;
use Sem\Weben\Http\Response;
use Sem\Weben\Controller\ThreadController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$req = new Request();
$res = new Response();
$router = new Router();

$router->addRoute("POST", '/\/threads/', ThreadController::class, "create");
$router->addRoute("GET", '/\/threads/', ThreadController::class, "list");
$router->addRoute("GET", '/\//', ThreadController::class, "list");

//$router->addRoute("POST", '/\//', ThreadController::class, "create");
$router->route($req, $res);
//print json_encode($req->getQueryParams());

// header('Content-Type: application/json');
// print json_encode($_ENV);
//print json_encode($req->getPathParams());
