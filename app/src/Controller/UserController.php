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
  }

  public function signup(RequestInterface $req, ResponseInterface $res): void
  {
    $username = $req->getBody()["username"];
    $password = $req->getBody()["password"];

    $user = UserService::createUser($username, $password);

    $res->setBody($user);
    $res->setStatusCode(200);
  }

  public function refresh(RequestInterface $req, ResponseInterface $res): void
  {
    $userId = (int)$req->getQueryParams()["userId"];
    $jwt = $req->getHeader()["Acess-Token"];

    // echo json_encode($jwt);

    $user = UserService::checkJwtAndUser($jwt, $userId);

    $res->setBody($user);
    $res->setStatusCode(200);
  }
}