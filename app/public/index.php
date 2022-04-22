<?php

require '../vendor/autoload.php';

// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__."/../");
// $dotenv->load();

// $pdo = new PDO('mysql:dbname=database_dev;host=mysql', 'tester', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

// $query = $pdo->query('SHOW VARIABLES like "version"');

// $row = $query->fetch();


use Sem\Weben\Reddit;

$r = new Reddit();

$posts = $r->getPosts();

// print json_encode($_ENV);
// $env = getenv();
// print __DIR__."/../";
// print json_encode($env);
// print $env["FOO"];

// header('Content-Type: application/json');
// print json_encode($posts);