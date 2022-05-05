<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\UserService;

class UserController
{

  public function login(RequestInterface $req, ResponseInterface $res): void
  {
    $body = $req->getBody();

    if (empty($body['username']) || empty($body['password'])) {
      throw new Exception('Missing parameters');
    }

    $username = $body["username"];
    $password = $body["password"];

    $user = UserService::signin($username, $password);

    $res->setBody($user);
    $res->setStatusCode(200);
  }

  public function signup(RequestInterface $req, ResponseInterface $res): void
  {
    $body = $req->getBody();

    if (empty($body['username']) || empty($body['password'])) {
      throw new Exception('Missing parameters');
    }

    $username = $body["username"];
    $password = $body["password"];

    $user = UserService::createUser($username, $password);

    $res->setBody($user);
    $res->setStatusCode(200);
  }

  public function refresh(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: uuid
    $query = $req->getQueryParams();
    $header = $req->getHeader();

    // echo json_encode($header);

    if (empty($query['userId']) || empty($header['Access-Token'])) {
      throw new Exception('Missing parameters');
    }

    $userId = $query["userId"];
    $jwt = $header["Access-Token"];

    $user = UserService::checkJwtAndUser($jwt, $userId);

    $res->setBody($user);
    $res->setStatusCode(200);
  }
}