<?php

namespace Sem\Weben\Controller;

use Exception;
use Sem\Weben\Http\RequestInterface;
use Sem\Weben\Http\ResponseInterface;
use Sem\Weben\Service\ThreadService;


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

  public function create(RequestInterface $req, ResponseInterface $res): void
  {
    // todo: auth - user uuid
    $body = $req->getBody();
    if (empty($body['name'])) {
      throw new Exception('Missing parameters');
    }
    $name = $body["name"];

    $thread = ThreadService::createThread($name);

    $res->setStatusCode(200);
    $res->setBody([
        "name" => $thread->getName(),
        "uid" => $thread->getUid(),
        "createdAt" => $thread->getCreatedat()
    ]);
  }
}