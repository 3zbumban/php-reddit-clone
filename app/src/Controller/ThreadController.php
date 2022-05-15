<?php

namespace Sem\Weben\Controller;

use Exception;
use Propel\Runtime\Exception\PropelException;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\HttpException;
use Sem\Weben\Service\ThreadService;
use Sem\Weben\Service\UserService;


class ThreadController

{
  public function list(RequestInterface $req, ResponseInterface $res): void
  {
    $threads = ThreadService::getThreads();
    $res->setStatusCode(200);
    $res->setBody([
      "threads" => $threads
    ]);
  }

  /**
   * @throws HttpException
   * @throws PropelException
   */
  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - done?
    $body = $req->getBody();
    $header = $req->getHeader();

    if (empty($header['Access-Token']) || empty($body["userId"])) {
      throw new HttpException('Unauthenticated', 401);
    }

    if (empty($body['name'])) {
      throw new HttpException('missing thread name', 400);
    }


    $name = $body["name"];
    $userId = $body["userId"];
    $jwt = $header["Access-Token"];

    try {
      $user = UserService::checkJwtAndUser($jwt, $userId);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 401);
    }

    try {
      $thread = ThreadService::createThread($name);
    } catch (Exception $ex) {
      throw new HttpException($ex->getMessage(), 400);
    }

    $res->setStatusCode(200);
    $res->setBody([
        "name" => $thread->getName(),
        "uid" => $thread->getUid(),
        "createdAt" => $thread->getCreatedat(),
        "user" => $user
    ]);
  }
}