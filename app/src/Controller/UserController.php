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

    if (empty($body['username']) || empty($body['password'])) {
      throw new HttpException('Missing parameters', 400);
    }

    $username = $body["username"];
    $password = $body["password"];

    try {
      $user = UserService::signin($username, $password);
    } catch (Exception $e) {
      throw new HttpException($e->getMessage(), 400);
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

    if (empty($body['username']) || empty($body['password'])) {
      throw new HttpException('Missing parameters', 400);
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

    if (empty($query['userId']) || empty($header['Access-Token'])) {
      throw new HttpException('Missing authorization header', 401);
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