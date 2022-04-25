<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\UserService;

class UserController
{

  public function login(RequestInterface $req, ResponseInterface $res): void
  {
    $username = $req->getBody()['username'];
    $password = $req->getBody()['password'];

    $user = UserService::signin($username, $password);

    $res->setBody($user);
    $res->setStatusCode(200);
    $res->json();
  }

  public function signup(RequestInterface $req, ResponseInterface $res): void
  {
    $username = $req->getBody()["username"];
    $password = $req->getBody()["password"];

    $user = UserService::createUser($username, $password);

    $res->setBody($user);
    $res->setStatusCode(200);
    $res->json();
  }
}