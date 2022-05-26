<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\HttpException;
use Sem\Weben\Service\UserService;

class UserController
{

  /**
   * @throws HttpException
   */
  public function login(RequestInterface $req, ResponseInterface $res): void
  {
    $body = $req->getBody();

    if (empty(trim($body['username'])) || empty(trim($body['password']))) {
      throw new HttpException('missing username or password', 400);
    }

    $username = $body["username"];
    $password = $body["password"];

    try {
      $user = UserService::signin($username, $password);
    } catch (Exception $e) {
      error_log($e->getMessage());
      throw new HttpException("could not login", 400);
    }

    $res->setBody($user);
    $res->setStatusCode(200);
  }

  /**
   * @throws HttpException
   */
  public function signup(RequestInterface $req, ResponseInterface $res): void
  {
    $body = $req->getBody();

    if (empty(trim($body['username'])) || empty(trim($body['password']))) {
      throw new HttpException('missing username or password', 400);
    }

    $username = $body["username"];
    $password = $body["password"];

    try {
      $user = UserService::createUser($username, $password);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
    }

    $res->setBody($user);
    $res->setStatusCode(200);
  }

  /**
   * @throws HttpException
   */
  public function refresh(RequestInterface $req, ResponseInterface $res): void
  {
    $query = $req->getQueryParams();
    $header = $req->getHeader();

    if (empty($header['Access-Token']) || empty($query['userId'])) {
      throw new HttpException('Unauthenticated', 401);
    }

    $userId = $query["userId"];
    $jwt = $header["Access-Token"];

    try {
      $user = UserService::checkJwtAndUser($jwt, $userId);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
    }

    $res->setBody($user);
    $res->setStatusCode(200);
  }
}