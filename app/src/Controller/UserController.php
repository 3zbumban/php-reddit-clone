<?php

namespace Sem\Weben\Controller;

use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Model\User;

class UserController {

  public function login(RequestInterface $req, ResponseInterface $res): void {
    $res->setBody($req->getBody());
    $res->setStatusCode(200);
    $res->json();
  }

  public function signup(RequestInterface $req, ResponseInterface $res): void {
    $body = $req->getBody();
    $username = $body["username"];
    $password = $body["password"];
    $passwordHash = password_hash($password, PASSWORD_ARGON2I);
    
    $user = new User();
    $user->setUsername($username);
    $user->setPassword($passwordHash);
    $user->save();

    $res->setBody(array("username" => $username, "pw" => $passwordHash, "created" => date_timestamp_get(date_create()), "id" => $user->getId()));
    $res->setStatusCode(200);
    $res->json();
  }
}