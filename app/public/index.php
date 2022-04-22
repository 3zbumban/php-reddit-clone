<?php

// $pdo = new PDO('mysql:dbname=database_dev;host=mysql', 'tester', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
// $query = $pdo->query('SHOW VARIABLES like "version"');
// $row = $query->fetch();

require '../vendor/autoload.php';

use Sem\Weben\Router;
use Sem\Weben\Http\Request;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$req = new Request();
$router = new Router();

// print "Hello " . $req->getQueryParam("name");

// header('Content-Type: application/json');
// print json_encode($_ENV);
